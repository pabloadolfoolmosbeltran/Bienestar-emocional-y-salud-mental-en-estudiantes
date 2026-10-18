<?php

namespace Tests\Feature;

use App\Models\Articulo;
use App\Models\Imagen;
use Database\Seeders\ArticuloSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImagenesTest extends TestCase
{
    use RefreshDatabase;

    public function test_sin_clave_el_comando_no_modifica_articulos_ni_hace_peticiones(): void
    {
        $this->seed(ArticuloSeeder::class);
        config()->set('services.pexels.key', null);
        Http::fake();

        $this->artisan('imagenes:descargar')->assertExitCode(1);

        $this->assertSame(0, Imagen::count());
        $this->assertSame(0, Articulo::whereNotNull('imagen')->count());
        Http::assertNothingSent();
    }

    public function test_descarga_guarda_creditos_asigna_articulos_y_no_duplica_al_repetir(): void
    {
        Storage::fake('public');
        $this->seed(ArticuloSeeder::class);
        config()->set('services.pexels.key', 'clave-de-prueba');

        $original = imagecreatetruecolor(1800, 900);
        ob_start();
        imagejpeg($original);
        $jpeg = ob_get_clean();
        imagedestroy($original);

        Http::fake(function (Request $request) use ($jpeg) {
            if (str_starts_with($request->url(), 'https://api.pexels.com/v1/search')) {
                parse_str((string) parse_url($request->url(), PHP_URL_QUERY), $query);
                $base = abs(crc32($query['query'])) % 100000;
                $photos = [];

                for ($number = 1; $number <= 3; $number++) {
                    $id = $base + $number;
                    $photos[] = [
                        'id' => $id,
                        'url' => "https://www.pexels.com/photo/foto-{$id}/",
                        'photographer' => 'Fotógrafa de prueba',
                        'alt' => 'Mesa de estudio con luz suave',
                        'src' => ['large2x' => "https://images.pexels.com/photos/{$id}/foto.jpg"],
                    ];
                }

                return Http::response(['photos' => $photos]);
            }

            return Http::response($jpeg, 200, ['Content-Type' => 'image/jpeg']);
        });

        $this->artisan('imagenes:descargar')->assertExitCode(0);

        $this->assertSame(18, Imagen::count());
        $this->assertSame(8, Articulo::whereNotNull('imagen')->count());
        $imagen = Imagen::firstOrFail();
        Storage::disk('public')->assertExists($imagen->ruta);
        $dimensiones = getimagesizefromstring(Storage::disk('public')->get($imagen->ruta));
        $this->assertLessThanOrEqual(1600, $dimensiones[0]);
        $this->assertSame('Pexels', $imagen->fuente);
        $this->assertSame('Fotógrafa de prueba', $imagen->autor);
        $this->assertSame('Mesa de estudio con luz suave', $imagen->descripcion);

        $articulo = Articulo::firstOrFail();
        $ruta = $articulo->imagen;
        $this->get(route('informacion.show', $articulo))
            ->assertOk()
            ->assertSee('loading="lazy"', false)
            ->assertSee('Mesa de estudio con luz suave')
            ->assertSee('Fotógrafa de prueba');

        $this->seed(ArticuloSeeder::class);
        $this->assertSame($ruta, $articulo->fresh()->imagen);
        $this->artisan('imagenes:descargar')->assertExitCode(0);
        $this->assertSame(18, Imagen::count());
    }

    public function test_catalogo_verificado_permita_descargar_sin_clave_api(): void
    {
        Storage::fake('public');
        $this->seed(ArticuloSeeder::class);
        config()->set('services.pexels.key', null);

        $original = imagecreatetruecolor(1800, 900);
        ob_start();
        imagejpeg($original);
        $jpeg = ob_get_clean();
        imagedestroy($original);

        Http::fake(fn () => Http::response($jpeg, 200, ['Content-Type' => 'image/jpeg']));

        $this->artisan('imagenes:descargar', ['--catalogo' => true])->assertExitCode(0);

        $this->assertSame(12, Imagen::count());
        $this->assertSame(8, Articulo::whereNotNull('imagen')->count());
        $this->assertTrue(Imagen::all()->every(fn ($imagen) => Storage::disk('public')->exists($imagen->ruta)));
        Http::assertSentCount(12);
        Http::assertNotSent(fn (Request $request) => str_contains($request->url(), 'api.pexels.com'));
    }
}
