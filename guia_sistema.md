# Guía del sistema Pausa

**Estado revisado:** 18 de octubre de 2026. **Proyecto:** `salud`. **Base de datos local:** `salud_estudiantil`.

Esta guía describe lo que **existe y funciona actualmente** en el código y en la instalación local revisada. También indica qué falta de la expansión planificada. Los conteos de datos son una captura de esta fecha: cambiarán cuando se use el quiz o se agregue contenido.

## 1. ¿Qué es Pausa?

Pausa es un sitio académico de bienestar emocional para estudiantes, pensado especialmente para quienes trabajan de día y estudian de noche. Ofrece artículos educativos y un quiz anónimo de reflexión. **El quiz es orientativo; no diagnostica ni reemplaza la atención de un profesional.**

El sitio está construido con Laravel 12, PHP 8.2, MySQL, Blade, Bootstrap 5 cargado por CDN, CSS propio y un poco de JavaScript en la vista del quiz. Las páginas actuales no necesitan `npm install` ni un build de Vite: el layout carga Bootstrap por CDN y `public/css/salud.css` directamente. `package.json`, `vite.config.js` y `resources/js` son archivos del esqueleto de Laravel; el layout actual no los usa.

## 2. ¿Hasta dónde está hecho?

| Parte | Estado actual |
| --- | --- |
| Inicio | Funciona. Tiene un hero sobre salud mental y estudio, aviso orientativo, botones a artículos y quiz, franja con un dato mundial, 3 mensajes clave y los 3 artículos más recientes. |
| Información | Funciona. Muestra 8 artículos, filtro por categoría, 6 por página y detalle. |
| Panorama Bolivia | Funciona. Página estática con fuentes visibles, distinción entre dato mundial, estudios locales e información oficial, y canales de apoyo. |
| Quiz | Funciona. Tiene 12 preguntas activas, 4 opciones por pregunta, progreso visual, validación y resultados. |
| Resultados | Funciona. Guarda el intento, calcula puntaje y nivel, muestra desglose por categoría y hasta 3 artículos sugeridos. |
| Desarrolladores | Funciona como página estática. Los datos personales del equipo siguen marcados `COMPLETAR`. |
| Imágenes, fase 1 de expansión | Implementada. Hay 12 fotos locales de Pexels; los 8 artículos tienen una imagen y crédito visible. |
| Noticias, mensajes, otras páginas previstas, funciones técnicas extra y rediseño de expansión | **Pendientes.** Panorama es una página nueva independiente; las demás fases todavía no están implementadas. |
| Publicación en un servidor público | **Pendiente.** Solo se verificó esta instalación local de XAMPP; no hay dominio o hosting público configurado en el proyecto. |

### Datos actuales de la instalación local

| Dato | Cantidad comprobada |
| --- | ---: |
| Preguntas | 12 |
| Opciones | 48 |
| Rangos de resultado | 3 |
| Artículos | 8 |
| Imágenes registradas y archivos locales | 12 |
| Artículos con imagen asignada | 8 de 8 |
| Intentos / respuestas guardadas | 1 / 12, al revisar esta guía |

## 3. Dónde está cada cosa

La carpeta raíz en este equipo es:

```text
D:\xampp\htdocs\web3\10_18_2026_UltimaPractica4toBimestre\salud
```

| Ruta dentro del proyecto | Función |
| --- | --- |
| `routes/web.php` | Define las 8 rutas de la aplicación. |
| `app/Http/Controllers/` | Prepara los datos de cada página y ejecuta el flujo del quiz. |
| `app/Http/Requests/GuardarQuizRequest.php` | Valida todas las respuestas antes de guardarlas. |
| `app/Models/` | Modelos Eloquent y relaciones de las tablas. |
| `database/migrations/` | Define las tablas y sus claves. |
| `database/seeders/` | Inserta o actualiza preguntas, rangos y artículos iniciales. |
| `resources/views/` | Vistas Blade: inicio, artículos, panorama, quiz, resultado y desarrolladores. |
| `resources/views/layouts/app.blade.php` | Layout común, menú, pie, Bootstrap CDN y CSS. |
| `resources/views/components/` | Componentes reutilizables de categoría y foto con crédito. |
| `public/css/salud.css` | Colores, tarjetas, imágenes, diseño responsive y otros estilos propios. |
| `public/index.php` | Entrada HTTP de Laravel. El servidor web debe apuntar a `public/`. |
| `app/Console/Commands/ImagenesDescargar.php` | Comando para descargar, redimensionar y asignar fotos. |
| `config/imagenes.php` | Catálogo de 12 fotos públicas verificadas de Pexels. |
| `config/panorama.php` | Textos, tipos de dato, fuentes y fecha de consulta del Panorama. |
| `config/ayuda.php` | Números y horario publicados de Familia Segura; requiere verificar vigencia con UNICEF. |
| `config/services.php` | Lee la clave API opcional de Pexels desde el entorno. |
| `storage/app/public/imagenes/` | Archivos JPG descargados. Actualmente ocupa unos 3,2 MB. |
| `public/storage` | Enlace local hacia `storage/app/public`; permite servir las fotos. |
| `tests/Feature/` | Pruebas de datos, flujo del quiz, imágenes y Panorama. |
| `.env` | Configuración privada de este equipo; no se debe publicar. |
| `.env.example` | Plantilla de variables de entorno para otra instalación. |

La ruta `storage/app/public/imagenes/` está ignorada por Git. **Subir solo el código o ejecutar solo los seeders no transporta las fotos**: hay que copiar esos JPG al servidor o volver a ejecutar el comando de descarga allí.

## 4. Páginas y rutas

Todas las rutas de la aplicación están en `routes/web.php`:

| Método y URL | Nombre | Controlador | Qué hace |
| --- | --- | --- | --- |
| `GET /` | `inicio` | `InicioController@index` | Muestra el hero, dato mundial, mensajes clave y 3 artículos recientes. |
| `GET /informacion` | `informacion.index` | `ArticuloController@index` | Lista artículos; admite `?categoria=estres`, `sueno`, `tiempo`, `animo` o `apoyo`. |
| `GET /informacion/{articulo}` | `informacion.show` | `ArticuloController@show` | Muestra el artículo indicado por su ID. |
| `GET /panorama` | `panorama` | Vista estática | Muestra el panorama estudiantil en Bolivia y sus fuentes. |
| `GET /quiz` | `quiz.index` | `QuizController@index` | Muestra preguntas activas ordenadas y sus opciones. |
| `POST /quiz` | `quiz.store` | `QuizController@store` | Valida respuestas y crea el intento. |
| `GET /quiz/resultado/{intento}` | `quiz.resultado` | `QuizController@resultado` | Muestra el resultado guardado del intento indicado por su ID. |
| `GET /desarrolladores` | `desarrolladores.index` | `DesarrolladorController@index` | Muestra la página estática del equipo. |

Laravel también incluye la ruta técnica `/up` para comprobar salud del servidor; no es una página de contenido. Los artículos y resultados usan IDs numéricos en la URL. No hay inicio de sesión ni cuenta de estudiante. Los resultados se consultan mediante su URL pública: si más adelante se manejan datos sensibles o se requiere privacidad por persona, habrá que diseñar un control de acceso antes de publicar esa función.

### Vistas concretas

| Archivo | Contenido |
| --- | --- |
| `resources/views/inicio.blade.php` | Hero, aviso orientativo, dos botones, franja de dato mundial, propósito, tres mensajes y artículos recientes. |
| `resources/views/articulos/index.blade.php` | Filtro, tarjetas, estado vacío y paginación Bootstrap. |
| `resources/views/articulos/show.blade.php` | Título, resumen, foto y cuerpo HTML del artículo. |
| `resources/views/panorama.blade.php` | Tarjetas con tipos de dato y fuentes, apoyo, límites y aviso orientativo. |
| `resources/views/quiz/index.blade.php` | Aviso, formulario, errores y barra de progreso con JavaScript. |
| `resources/views/quiz/resultado.blade.php` | Puntaje, nivel, recomendación, desglose y lecturas sugeridas. |
| `resources/views/desarrolladores/index.blade.php` | Equipo, propósito, funciones y tecnologías. |
| `resources/views/components/articulo-imagen.blade.php` | Imagen, texto alternativo, autor y enlace al origen en Pexels. |
| `resources/views/components/categoria.blade.php` | Nombre visible de una categoría. |

### Contenido actual de Inicio

El hero muestra el título **«Cuidar tu salud mental también es parte de estudiar»**. Su introducción habla de la acumulación de clases, trabajo y responsabilidades; se dirige especialmente a estudiantes que trabajan de día y estudian de noche; y presenta los artículos, el quiz anónimo y la orientación inicial para pedir ayuda. Debajo aparece el aviso **«Este sitio es orientativo y no reemplaza la atención de un profesional»** y dos botones: **«Leer los artículos»** (`/informacion`) y **«Hacer el quiz»** (`/quiz`). El panel lateral conserva el objetivo del proyecto.

El panel lateral incluye ahora **«Conocer el panorama en Bolivia»**, que abre `/panorama`. El menú principal también contiene **«Panorama Bolivia»** y marca activa esa página cuando se visita.

Después del hero hay una franja marcada **«Dato mundial»**: **1 de cada 7 jóvenes de 10 a 19 años (14,3 %) tiene un problema de salud mental**. El texto aclara que la estimación es mundial y corresponde a ese grupo de edad; no se presenta como una cifra de Bolivia ni de todos los estudiantes. La franja enlaza a la [nota de Infocop](https://www.infocop.es/la-oms-actualiza-sus-datos-sobre-salud-mental-en-la-adolescencia/) indicada para esta página. El enlace oficial de la OMS sigue marcado **«Enlace oficial OMS: COMPLETAR»**.

Debajo continúan sin cambios los tres mensajes clave (descanso, apoyo y progreso) y las tarjetas de los tres artículos recientes, incluidos sus créditos fotográficos. La distribución usa las clases responsive existentes de Bootstrap: a 360 px, los botones y las columnas de la franja se apilan y no hay desbordamiento horizontal en la comprobación visual realizada.

### Contenido del Panorama Bolivia

`GET /panorama` usa una vista Blade estática, sin tablas ni controlador nuevos. Sus textos y las 10 fuentes se editan en `config/panorama.php`; los canales de Familia Segura se editan en `config/ayuda.php`. Cada tarjeta indica **Dato mundial**, **Estudio en Bolivia** o **Información oficial**, con enlace a la fuente. La página explica la diferencia entre contexto global, avances oficiales y resultados de muestras concretas. La nota de alcance advierte que no hay estadísticas nacionales publicadas de salud mental de estudiantes en Bolivia en las fuentes usadas; los estudios citados no se extrapolan al país entero.

El bloque de ayuda muestra la línea **800 11 30 40**, WhatsApp **77797667** y el horario publicado **6:00 a 24:00**, con enlace a [UNICEF Familia Segura](https://www.unicef.org/bolivia/familia-segura) y aviso de verificar vigencia. También propone hablar con alguien de confianza o acudir a un centro de salud. La lista final repite todas las fuentes y su fecha de consulta, **18/10/2026**. El enlace oficial OMS permanece como `COMPLETAR`, de acuerdo con el encargo de esta página.

## 5. Base de datos

La conexión local está configurada para MySQL en `127.0.0.1:33067`, base `salud_estudiantil`, usuario `root` y contraseña vacía. Estos son **datos de desarrollo local**, no una configuración adecuada para publicar. Las credenciales reales se definen en `.env` y nunca deben escribirse en las vistas ni subirse al repositorio.

### Tablas de Pausa

| Tabla | Datos principales | Uso y relaciones |
| --- | --- | --- |
| `preguntas` | `texto`, `categoria`, `orden`, `activa` | Preguntas del quiz. Cada una tiene muchas opciones. |
| `opciones` | `pregunta_id`, `texto`, `puntos` | Opciones de una pregunta; los puntos van de 0 a 3 en los datos iniciales. |
| `intentos` | `puntaje_total`, `nivel`, fechas | Un envío anónimo del quiz; tiene muchas respuestas. |
| `respuestas` | `intento_id`, `pregunta_id`, `opcion_id` | Conecta cada intento con la pregunta y la opción elegida. |
| `rangos_resultado` | `min`, `max`, `nivel`, `titulo`, `recomendacion` | Traduce puntaje total a nivel y texto orientativo. |
| `articulos` | `titulo`, `resumen`, `contenido`, `categoria`, `imagen` | Contenido educativo. `contenido` guarda HTML simple; `imagen` guarda la ruta relativa del JPG. |
| `imagenes` | `archivo`, `ruta`, `tema`, `descripcion`, `autor`, `fuente`, `licencia`, `url_origen` | Registro de fotos y créditos. `articulos.imagen` se relaciona con `imagenes.ruta`. |

Laravel creó además tablas técnicas como `users`, `cache`, `jobs`, `sessions` y otras según sus migraciones. **Pausa no usa registro ni inicio de sesión**: la existencia de `users` proviene del esqueleto de Laravel, no de una función propia.

### Categorías y contenido inicial

Las categorías internas son `estres`, `sueno`, `tiempo`, `animo` y `apoyo`. Las 12 preguntas se distribuyen así: estrés 3, sueño 2, tiempo 3, ánimo 2 y apoyo 2. Cada pregunta tiene 4 opciones, por eso el máximo total es 36 puntos.

| ID | Artículo | Categoría |
| ---: | --- | --- |
| 1 | Una pausa breve también cuenta | `estres` |
| 2 | Antes de un examen: prepara lo que sí controlas | `estres` |
| 3 | Cuidar el sueño cuando estudias de noche | `sueno` |
| 4 | Organiza una semana con tiempo real | `tiempo` |
| 5 | Estudia en bloques que puedas sostener | `tiempo` |
| 6 | Háblate como hablarías a un compañero | `animo` |
| 7 | Cómo empezar a pedir ayuda | `apoyo` |
| 8 | Construye una red de apoyo posible | `apoyo` |

Los rangos guardados son `bajo` (0–12), `medio` (13–24) y `alto` (25–36). Son **etiquetas orientativas del quiz**, no diagnósticos clínicos.

### De dónde salen los datos

- `database/seeders/PreguntaSeeder.php`: crea o actualiza las 12 preguntas y sus 48 opciones.
- `database/seeders/RangoResultadoSeeder.php`: crea o actualiza los 3 rangos y sus recomendaciones.
- `database/seeders/ArticuloSeeder.php`: crea o actualiza los 8 artículos ampliados. Conserva la columna `imagen` existente para no quitar fotos al repetir el seeder.
- `database/seeders/DatabaseSeeder.php`: ejecuta los tres seeders anteriores.

Los seeders usan `updateOrCreate`; repetir `php artisan db:seed` no debería duplicar esos registros. Sí puede actualizar sus textos iniciales. **No ejecutar `php artisan migrate:fresh` sobre una base con datos que quieras conservar**: elimina y reconstruye tablas, incluidos intentos, respuestas e imágenes registradas.

## 6. Cómo funciona el quiz

1. `QuizController@index` busca solo preguntas con `activa = true`, ordena por `orden` e ID y carga sus opciones de una vez para evitar consultas por cada pregunta.
2. La persona elige una opción por pregunta. El formulario envía `respuestas[ID_PREGUNTA] = ID_OPCION`; una barra muestra cuántas respondió. El JavaScript solo actualiza esa barra: la validación verdadera se hace en el servidor.
3. `GuardarQuizRequest` exige **todas** las preguntas activas, rechaza preguntas inactivas y comprueba que cada opción pertenezca a su pregunta. Los mensajes de error son en español.
4. `QuizController@store` abre una transacción de base de datos, crea el intento, guarda las respuestas, suma los puntos, encuentra el rango cuyo `min <= puntaje <= max` y actualiza `puntaje_total` y `nivel`. Si el guardado falla, la transacción se revierte.
5. `QuizController@resultado` agrupa puntos por `preguntas.categoria`, elige la categoría con mayor puntaje y trae hasta 3 artículos de esa categoría. En empate, el orden alfabético de la categoría decide cuál aparece primero.
6. La pantalla repite que el resultado es orientativo y no es un diagnóstico.

No se guarda nombre, correo ni una cuenta de quien responde. Sí quedan guardados el intento, las opciones escogidas, el puntaje, el nivel y las fechas técnicas de las filas.

## 7. Imágenes y sus créditos

La fase 1 de expansión agregó la tabla `imagenes` y el comando `php artisan imagenes:descargar`. Las 12 fotos actuales provienen de páginas públicas de Pexels verificadas y están descritas en `config/imagenes.php`, dos por tema: estudio nocturno, estrés, descanso, apoyo, naturaleza y calma. Los JPG se reducen a **máximo 1600 píxeles de ancho**. Las vistas leen archivos locales, por lo que una visita normal no consulta la API de Pexels.

```powershell
# Reponer fotos del catálogo si faltan; no requiere clave API
php artisan imagenes:descargar --catalogo

# Modalidad opcional de búsqueda por API, solo con PEXELS_API_KEY configurada
php artisan imagenes:descargar --cantidad=18

# Crear public/storage si aún no existe
php artisan storage:link
```

El comando omite imágenes ya registradas y asigna una foto por artículo que todavía no tenga foto. El componente Blade muestra `loading="lazy"`, descripción alternativa y crédito con enlace a la página de Pexels. La clave `PEXELS_API_KEY` está vacía en esta instalación; la descarga realizada fue mediante `--catalogo`, sin usar la contraseña de una cuenta. **No pegar credenciales personales en el código ni en esta guía.**

Si un artículo no tiene una imagen registrada, el componente no muestra una foto. Si el registro existe pero falta el JPG, aparecerá una imagen rota: comprueba también que el archivo esté en `storage/app/public/imagenes/`. Si el hosting no permite crear el enlace `public/storage`, se pueden copiar los archivos a `public/storage/imagenes/` y mantener la misma URL `/storage/imagenes/...`; habrá que repetir la copia cada vez que cambien las fotos.

## 8. Ejecutar el proyecto en este equipo

Desde PowerShell, entra a la carpeta raíz del proyecto y verifica que MySQL de XAMPP esté activo en el puerto `33067`:

```powershell
cd 'D:\xampp\htdocs\web3\10_18_2026_UltimaPractica4toBimestre\salud'
composer install
php artisan migrate:status
php artisan serve --host=127.0.0.1 --port=8000
```

Abre `http://127.0.0.1:8000/`. No hace falta ejecutar `db:seed`, migraciones ni descargar imágenes en cada arranque si ya están cargadas. Si faltan las tablas o los datos en una instalación **nueva**:

```powershell
Copy-Item .env.example .env
php artisan key:generate
# Crear antes la base MySQL salud_estudiantil y ajustar .env.
php artisan migrate
php artisan db:seed
php artisan imagenes:descargar --catalogo
php artisan storage:link
```

La copia de `.env.example` y `key:generate` son para una instalación nueva; no regeneres `APP_KEY` sin necesidad en una instalación existente. El puerto de MySQL y las credenciales pueden cambiar en otro equipo.

### Prueba manual en navegador

1. Abre `/` y comprueba título, introducción, aviso, botones, franja **Dato mundial**, acceso al Panorama, tres mensajes y tres artículos recientes.
2. Abre `/panorama` desde Inicio o el menú. Revisa las etiquetas de tipo, enlaces visibles a fuentes, fecha de consulta y bloque de ayuda. En una ventana de 360 px, comprueba que las tarjetas se apilen sin desplazamiento horizontal.
3. Abre `/informacion`, filtra una categoría y entra al detalle de un artículo. Comprueba foto y crédito.
4. Abre `/quiz`; responde las 12 preguntas. La barra debe avanzar. Prueba también enviar sin completar todo y observa los errores.
5. Envía el quiz completo; en `/quiz/resultado/{id}` comprueba puntaje, nivel, recomendación, categorías, artículos sugeridos y aviso orientativo.
6. Abre `/desarrolladores`. Revisa las páginas también en pantalla estrecha o con el modo móvil del navegador.

Para pruebas automáticas:

```powershell
php artisan test --compact
```

La prueba específica del Panorama está en `tests/Feature/PanoramaTest.php`. Al verificar esta actualización pasaron **15 pruebas con 199 verificaciones**. `phpunit.xml` usa SQLite en memoria, así que las pruebas no deberían agregar intentos a la base MySQL local.

## 9. Cómo se publicaría en un hosting

**Todavía no se ha realizado un despliegue público.** Esta es la preparación necesaria para un servidor compatible con Laravel, PHP 8.2 o superior, Composer, MySQL y extensión PHP GD:

1. Subir el código y configurar el sitio o dominio para que el directorio web apunte a **`salud/public/`**, donde está `index.php`. No exponer la raíz de Laravel ni `.env` como directorio público.
2. Crear una base MySQL en el servidor. Copiar `.env.example` como `.env` allí y poner `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://TU_DOMINIO`, y los datos `DB_*` reales. Generar `APP_KEY` una sola vez en una instalación nueva. La clave API de Pexels es opcional si se trasladan las 12 fotos o se usa el catálogo.
3. Instalar dependencias PHP con `composer install --no-dev --optimize-autoloader`. Para la interfaz actual no se requiere npm ni Vite.
4. Dar permisos de escritura a `storage/` y `bootstrap/cache/`. Ejecutar `php artisan migrate --force`; usar `php artisan db:seed --force` si se necesita cargar los datos iniciales después de respaldar la base existente.
5. Llevar los JPG de `storage/app/public/imagenes/` y los registros correspondientes de `imagenes`/`articulos` en la base, **o** ejecutar `php artisan imagenes:descargar --catalogo` en la instalación nueva. Después ejecutar `php artisan storage:link`; si no hay soporte para enlaces, usar la copia explicada en la sección 7.
6. Con `.env` final configurado, ejecutar `php artisan config:cache`, `php artisan route:cache` y `php artisan view:cache`. Comprobar `/`, `/informacion`, `/panorama`, `/quiz`, `/desarrolladores`, `/up` y una foto en `/storage/imagenes/...`.

Las fotos locales, `.env` y el contenido de MySQL son datos que **no viajan automáticamente con Git**. Se deben respaldar y trasladar por separado. Si se migra la base existente, conservar los IDs y las rutas de `articulos.imagen`; si se parte de una base nueva, cargar el catálogo después de los seeders.

Bootstrap se obtiene de `cdn.jsdelivr.net`. Si no hay Internet, el HTML y el CSS propio pueden cargar, pero los estilos y el menú móvil de Bootstrap pueden verse o funcionar de forma incompleta. Un despliegue que necesite funcionamiento visual completamente sin conexión deberá alojar Bootstrap localmente en una fase futura.

## 10. Pendientes y límites conocidos

- **Expansión pendiente:** Noticias (fase 2), Mensajes y otras páginas de concientización (fase 3), rediseño profesional y estados 404/500 propios (fase 4), estadísticas/buscador/respiración (fase 5) y despliegue público final. Panorama ya existe como sección independiente; no asumir que las demás funciones existen.
- **Contenido por completar:** nombres, fotos y enlaces de los dos integrantes en `resources/views/desarrolladores/index.blade.php`; enlaces específicos OMS/OPS marcados `COMPLETAR: verificar fuente` dentro de `database/seeders/ArticuloSeeder.php`; y el rótulo `Enlace oficial OMS: COMPLETAR` en Inicio y Panorama. Los números de Familia Segura provienen de UNICEF y deben volver a verificarse antes de publicar.
- **Acceso a resultados:** la ruta de resultado usa un ID público sin autenticación; evitar presentar el resultado como información privada individual en su forma actual.
- **Actualización de artículos:** `resources/views/articulos/show.blade.php` muestra `contenido` como HTML. En este proyecto ese HTML proviene del seeder del equipo; si en el futuro se acepta edición por usuarios, habrá que validar o sanear ese contenido antes de mostrarlo.
- **Documentos anteriores:** `CAPA_DATOS.md` y `ETAPA_2_BACKEND.md` explican cómo se construyeron las etapas iniciales, pero describen estados de entonces. Esta guía refleja el estado actual y tiene prioridad para saber qué está implementado hoy.

## 11. Comandos rápidos de diagnóstico

```powershell
php artisan about                 # versión, entorno, drivers y enlace de storage
php artisan route:list --except-vendor
php artisan migrate:status
php artisan test --compact
php artisan config:clear         # útil después de editar .env en desarrollo
```

Si el sitio no conecta a MySQL, revisa XAMPP, puerto `33067`, nombre de base y variables `DB_*` de `.env`. Si no se ven las fotos, verifica que haya archivos en `storage/app/public/imagenes/`, que `public/storage` apunte a `storage/app/public`, que `articulos.imagen` tenga una ruta y que el navegador pueda abrir `/storage/imagenes/NOMBRE.jpg`. Si el diseño aparece incompleto, comprueba la conexión al CDN de Bootstrap y que `public/css/salud.css` responda.
