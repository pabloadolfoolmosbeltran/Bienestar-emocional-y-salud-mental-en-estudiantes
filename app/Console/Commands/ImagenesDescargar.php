<?php

namespace App\Console\Commands;

use App\Models\Articulo;
use App\Models\Imagen;
use GdImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImagenesDescargar extends Command
{
    protected $signature = 'imagenes:descargar {--cantidad=18 : Total de imágenes, entre 12 y 20} {--catalogo : Descarga 12 fotos verificadas sin clave API}';

    protected $description = 'Descarga una vez imágenes de Pexels, guarda sus créditos y las asigna a los artículos';

    private const TEMAS = [
        'estudio nocturno' => 'student studying at night',
        'estres' => 'student study desk',
        'descanso' => 'resting after studying',
        'apoyo' => 'friends talking together',
        'naturaleza' => 'peaceful nature landscape',
        'calma' => 'calm evening landscape',
    ];

    private const TEMA_POR_ARTICULO = [
        'Una pausa breve también cuenta' => 'calma',
        'Antes de un examen: prepara lo que sí controlas' => 'estres',
        'Cuidar el sueño cuando estudias de noche' => 'descanso',
        'Organiza una semana con tiempo real' => 'estudio nocturno',
        'Estudia en bloques que puedas sostener' => 'estudio nocturno',
        'Háblate como hablarías a un compañero' => 'naturaleza',
        'Cómo empezar a pedir ayuda' => 'apoyo',
        'Construye una red de apoyo posible' => 'apoyo',
    ];

    public function handle(): int
    {
        if ($this->option('catalogo')) {
            return $this->descargarCatalogo();
        }

        $cantidad = filter_var($this->option('cantidad'), FILTER_VALIDATE_INT);

        if ($cantidad === false || $cantidad < 12 || $cantidad > 20) {
            $this->error('La cantidad debe estar entre 12 y 20.');

            return self::FAILURE;
        }

        $clave = config('services.pexels.key');

        if (! is_string($clave) || trim($clave) === '') {
            $this->error('Falta PEXELS_API_KEY en .env. El sitio puede seguir funcionando sin imágenes.');

            return self::FAILURE;
        }

        if (! extension_loaded('gd')) {
            $this->error('La extensión GD de PHP es necesaria para reducir las imágenes.');

            return self::FAILURE;
        }

        $nuevas = 0;
        $base = intdiv($cantidad, count(self::TEMAS));
        $restantes = $cantidad % count(self::TEMAS);

        foreach (self::TEMAS as $tema => $busqueda) {
            $objetivo = $base + ($restantes-- > 0 ? 1 : 0);
            $actuales = Imagen::query()->where('tema', $tema)->count();

            if ($actuales >= $objetivo) {
                continue;
            }

            try {
                $respuesta = Http::withHeaders(['Authorization' => $clave])
                    ->acceptJson()
                    ->timeout(20)
                    ->get('https://api.pexels.com/v1/search', [
                        'query' => $busqueda,
                        'orientation' => 'landscape',
                        'per_page' => 15,
                    ]);

                $respuesta->throw();

                $fotos = $respuesta->json('photos', []);

                foreach (is_array($fotos) ? $fotos : [] as $foto) {
                    if ($actuales >= $objetivo) {
                        break;
                    }

                    if (is_array($foto) && $this->guardarFoto($foto, $tema)) {
                        $actuales++;
                        $nuevas++;
                    }
                }
            } catch (Throwable $error) {
                Log::warning('No se pudieron descargar imágenes del tema.', [
                    'tema' => $tema,
                    'error' => $error->getMessage(),
                ]);
                $this->warn("No se pudo completar el tema: {$tema}.");
            }
        }

        $asignadas = $this->asignarArticulos();
        $total = Imagen::query()->count();
        $this->info("Imágenes nuevas: {$nuevas}. Registradas: {$total}. Artículos asignados: {$asignadas}.");

        if ($total < 12) {
            $this->warn('La colección sigue incompleta: se necesitan al menos 12 imágenes. Puedes repetir el comando.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function descargarCatalogo(): int
    {
        if (! extension_loaded('gd')) {
            $this->error('La extensión GD de PHP es necesaria para reducir las imágenes.');

            return self::FAILURE;
        }

        $nuevas = 0;

        foreach (config('imagenes.catalogo', []) as $foto) {
            if ($this->guardarFoto($foto, $foto['tema'])) {
                $nuevas++;
            }
        }

        $asignadas = $this->asignarArticulos();
        $total = Imagen::query()->count();
        $this->info("Imágenes nuevas: {$nuevas}. Registradas: {$total}. Artículos asignados: {$asignadas}.");

        if ($total < 12) {
            $this->warn('No se pudieron guardar las 12 fotos del catálogo. Revisa el registro y vuelve a ejecutar el comando.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function guardarFoto(array $foto, string $tema): bool
    {
        $id = filter_var($foto['id'] ?? null, FILTER_VALIDATE_INT);
        $origen = $foto['url'] ?? null;
        $src = data_get($foto, 'src.large2x');

        if (! $id || ! $this->esUrlPermitida($origen, 'www.pexels.com') || ! $this->esUrlPermitida($src, 'images.pexels.com')) {
            return false;
        }

        if (Imagen::query()->where('url_origen', $origen)->exists()) {
            return false;
        }

        $archivo = "pexels-{$id}.jpg";
        $ruta = "imagenes/{$archivo}";

        if (Imagen::query()->where('ruta', $ruta)->exists()) {
            return false;
        }

        try {
            $respuesta = Http::timeout(25)->get($src);
            $respuesta->throw();
            $cuerpo = $respuesta->body();

            if (strlen($cuerpo) > 15 * 1024 * 1024) {
                throw new \RuntimeException('La imagen supera el tamaño permitido.');
            }

            $jpg = $this->convertirAJpeg($cuerpo);

            if (! Storage::disk('public')->put($ruta, $jpg)) {
                throw new \RuntimeException('No se pudo guardar la imagen local.');
            }

            Imagen::query()->create([
                'archivo' => $archivo,
                'ruta' => $ruta,
                'tema' => $tema,
                'descripcion' => Str::limit(is_string($foto['alt'] ?? null) && trim($foto['alt']) !== ''
                    ? $foto['alt'] : "Fotografía relacionada con {$tema}", 255, ''),
                'autor' => is_string($foto['photographer'] ?? null)
                    ? Str::limit($foto['photographer'], 255, '') : null,
                'fuente' => 'Pexels',
                'licencia' => 'Licencia de Pexels',
                'url_origen' => $origen,
            ]);

            return true;
        } catch (Throwable $error) {
            Storage::disk('public')->delete($ruta);
            Log::warning('No se pudo guardar una imagen de Pexels.', [
                'tema' => $tema,
                'id' => $id,
                'error' => $error->getMessage(),
            ]);

            return false;
        }
    }

    private function convertirAJpeg(string $bytes): string
    {
        $medidas = @getimagesizefromstring($bytes);

        if (! $medidas || $medidas[0] <= 0 || $medidas[1] <= 0) {
            throw new \RuntimeException('El archivo recibido no es una imagen válida.');
        }

        $origen = @imagecreatefromstring($bytes);

        if (! $origen instanceof GdImage) {
            throw new \RuntimeException('El formato de imagen no es compatible con GD.');
        }

        $ancho = min(1600, $medidas[0]);
        $alto = max(1, (int) round($medidas[1] * $ancho / $medidas[0]));
        $destino = imagecreatetruecolor($ancho, $alto);
        imagefill($destino, 0, 0, imagecolorallocate($destino, 255, 255, 255));
        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $ancho, $alto, $medidas[0], $medidas[1]);

        ob_start();
        imagejpeg($destino, null, 82);
        $jpg = ob_get_clean();
        imagedestroy($origen);
        imagedestroy($destino);

        if (! is_string($jpg) || $jpg === '') {
            throw new \RuntimeException('No se pudo convertir la imagen.');
        }

        return $jpg;
    }

    private function esUrlPermitida(mixed $url, string $host): bool
    {
        return is_string($url)
            && parse_url($url, PHP_URL_SCHEME) === 'https'
            && parse_url($url, PHP_URL_HOST) === $host;
    }

    private function asignarArticulos(): int
    {
        $asignadas = 0;
        $usadas = Articulo::query()->whereNotNull('imagen')->pluck('imagen')->all();

        foreach (Articulo::query()->whereNull('imagen')->get() as $articulo) {
            $tema = self::TEMA_POR_ARTICULO[$articulo->titulo] ?? null;

            if (! $tema) {
                continue;
            }

            $imagen = Imagen::query()
                ->where('tema', $tema)
                ->whereNotIn('ruta', $usadas)
                ->orderBy('id')
                ->first();

            if ($imagen) {
                $articulo->update(['imagen' => $imagen->ruta]);
                $usadas[] = $imagen->ruta;
                $asignadas++;
            }
        }

        return $asignadas;
    }
}
