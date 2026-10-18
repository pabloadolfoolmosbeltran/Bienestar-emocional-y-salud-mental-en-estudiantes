# Capa de datos: bienestar estudiantil

Esta etapa prepara únicamente las tablas, modelos y datos iniciales. El quiz será anónimo y orientativo; el puntaje y el nivel se calcularán en el controlador de una etapa posterior.

## 1. Comandos Artisan para generar los archivos

Estos comandos sirven para reproducir el esqueleto en un proyecto Laravel nuevo. En este proyecto los archivos ya están creados; no los vuelvas a ejecutar.

```powershell
php artisan make:model Pregunta
php artisan make:model Opcion
php artisan make:model Intento
php artisan make:model Respuesta
php artisan make:model RangoResultado
php artisan make:model Articulo

php artisan make:migration create_preguntas_table
php artisan make:migration create_opciones_table
php artisan make:migration create_intentos_table
php artisan make:migration create_respuestas_table
php artisan make:migration create_rangos_resultado_table
php artisan make:migration create_articulos_table

php artisan make:seeder PreguntaSeeder
php artisan make:seeder RangoResultadoSeeder
php artisan make:seeder ArticuloSeeder
```

Las migraciones que crean `preguntas` e `intentos` deben ejecutarse antes de las que crean `opciones` y `respuestas`, por sus claves foráneas. Los nombres de archivo actuales ya respetan ese orden. Se usaron nombres explícitos para `opciones` y `rangos_resultado`, porque la pluralización automática de Artisan no produce esos nombres.

## 2. Migraciones

| Archivo | Qué hace |
| --- | --- |
| [create_preguntas_table.php](database/migrations/2026_10_18_190822_create_preguntas_table.php) | Guarda cada pregunta, su categoría, orden y estado activo. |
| [create_opciones_table.php](database/migrations/2026_10_18_190823_create_opciones_table.php) | Guarda cuatro opciones por pregunta y sus puntos; se borran al borrar la pregunta. |
| [create_intentos_table.php](database/migrations/2026_10_18_190824_create_intentos_table.php) | Guarda el puntaje y nivel de un intento anónimo. |
| [create_respuestas_table.php](database/migrations/2026_10_18_190825_create_respuestas_table.php) | Vincula cada respuesta con su intento, pregunta y opción. |
| [create_rangos_resultado_table.php](database/migrations/2026_10_18_190827_create_rangos_resultado_table.php) | Guarda los límites y recomendaciones de los tres niveles. |
| [create_articulos_table.php](database/migrations/2026_10_18_190828_create_articulos_table.php) | Guarda el contenido educativo y una ruta opcional de imagen. |

## 3. Modelos

| Archivo | Qué hace |
| --- | --- |
| [Pregunta.php](app/Models/Pregunta.php) | Permite guardar preguntas y obtener sus opciones. |
| [Opcion.php](app/Models/Opcion.php) | Usa la tabla española `opciones` y pertenece a una pregunta. |
| [Intento.php](app/Models/Intento.php) | Representa un quiz anónimo y reúne sus respuestas. |
| [Respuesta.php](app/Models/Respuesta.php) | Relaciona un intento con la pregunta y la opción elegida. |
| [RangoResultado.php](app/Models/RangoResultado.php) | Usa la tabla `rangos_resultado` para buscar el nivel según el puntaje. |
| [Articulo.php](app/Models/Articulo.php) | Representa un artículo informativo editable desde el seeder. |

Los modelos declaran `$fillable` para permitir la creación con arreglos de campos permitidos. `Pregunta` convierte `activa` a booleano.

## 4. Seeders

| Archivo | Qué hace |
| --- | --- |
| [PreguntaSeeder.php](database/seeders/PreguntaSeeder.php) | Inserta o actualiza 12 preguntas activas, cada una con opciones de 0, 1, 2 y 3 puntos. |
| [RangoResultadoSeeder.php](database/seeders/RangoResultadoSeeder.php) | Inserta o actualiza los rangos 0–12, 13–24 y 25–36, con textos orientativos. |
| [ArticuloSeeder.php](database/seeders/ArticuloSeeder.php) | Inserta o actualiza ocho artículos breves para estudiantes que trabajan y estudian de noche. |
| [DatabaseSeeder.php](database/seeders/DatabaseSeeder.php) | Ejecuta los tres seeders de la aplicación. |

Se usó `updateOrCreate` para que repetir `php artisan db:seed` actualice el contenido inicial sin duplicar filas.

## 5. Configuración de MySQL

El archivo local [`.env`](.env) y la plantilla [`.env.example`](.env.example) contienen:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=33067
DB_DATABASE=salud_estudiantil
DB_USERNAME=root
DB_PASSWORD=
```

La base `salud_estudiantil` ya existía en este equipo. En otro equipo, créala antes de migrar. En el servidor público habrá que usar las credenciales y el puerto que proporcione el proveedor de alojamiento.

## 6. Ejecutar y comprobar

```powershell
php artisan config:clear
php artisan migrate
php artisan db:seed
php artisan migrate:status
php artisan test
```

Para comprobar las cantidades en MySQL:

```powershell
& 'D:\xampp\mysql\bin\mysql.exe' --host=127.0.0.1 --port=33067 --user=root --database=salud_estudiantil --execute="SELECT COUNT(*) AS preguntas FROM preguntas; SELECT COUNT(*) AS opciones FROM opciones; SELECT COUNT(*) AS rangos FROM rangos_resultado; SELECT COUNT(*) AS articulos FROM articulos;"
```

Se esperan 12 preguntas, 48 opciones, 3 rangos y 8 artículos. `intentos` y `respuestas` quedan vacías hasta que se implemente el quiz. Laravel también crea sus tablas técnicas predeterminadas (`users`, `cache`, `jobs`, etc.); este proyecto no usa registro ni inicio de sesión.

Para preparar los textos orientativos se revisaron las recomendaciones generales de la [OMS sobre estrés](https://www.who.int/es/news-room/questions-and-answers/item/stress), la [OMS sobre salud mental adolescente](https://www.who.int/es/news-room/fact-sheets/detail/adolescent-mental-health) y los [CDC sobre sueño](https://www.cdc.gov/sleep/about/).
