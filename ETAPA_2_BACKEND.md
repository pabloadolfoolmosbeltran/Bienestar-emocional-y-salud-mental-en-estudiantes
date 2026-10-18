# Etapa 2: rutas y lógica del quiz

Se implementó el backend sin cambiar las tablas de la etapa 1. Las vistas son HTML mínimo para probar el flujo; se reemplazarán durante la etapa de diseño.

## Comandos Artisan

Estos comandos ya se ejecutaron en este proyecto. Sirven como referencia si necesitas explicar cómo se generaron los archivos:

```powershell
php artisan make:controller InicioController
php artisan make:controller ArticuloController
php artisan make:controller DesarrolladorController
php artisan make:controller QuizController
php artisan make:request GuardarQuizRequest
```

## Archivos y responsabilidad

| Archivo | Explicación breve |
| --- | --- |
| [routes/web.php](routes/web.php) | Declara las siete rutas web y sus nombres para generar enlaces sin escribir URL fijas. |
| [InicioController.php](app/Http/Controllers/InicioController.php) | Envía a inicio los tres artículos más recientes. |
| [ArticuloController.php](app/Http/Controllers/ArticuloController.php) | Pagina artículos de seis en seis, permite filtrar por categoría y muestra un artículo por su ID. |
| [DesarrolladorController.php](app/Http/Controllers/DesarrolladorController.php) | Devuelve la página estática del equipo. |
| [GuardarQuizRequest.php](app/Http/Requests/GuardarQuizRequest.php) | Exige una respuesta para cada pregunta activa, rechaza preguntas inactivas y comprueba que cada opción pertenezca a su pregunta. Sus mensajes están en español. |
| [QuizController.php](app/Http/Controllers/QuizController.php) | Carga preguntas con opciones, guarda intento y respuestas en una transacción, calcula puntaje y nivel y prepara el resultado con desglose y artículos relacionados. |

El formulario envía un arreglo con esta forma:

```text
respuestas[ID_PREGUNTA] = ID_OPCION
```

La validación consulta los IDs activos y las opciones seleccionadas en conjunto. El guardado vuelve a comprobar las opciones dentro de `DB::transaction`; si falta un rango para el puntaje, la transacción revierte el intento y sus respuestas. En la página de resultado, una consulta agrupa los puntos por `preguntas.categoria`; la categoría con mayor suma aporta hasta tres artículos. En caso de empate, se elige la primera categoría en orden alfabético.

Las vistas mínimas están en [resources/views](resources/views): inicio, índice y detalle de artículos, quiz, resultado, desarrolladores y un layout compartido. La vista del quiz muestra el aviso antes de comenzar; la de resultado lo repite.

## Probar el flujo desde el navegador

1. Comprueba que MySQL de XAMPP esté activo en el puerto `33067` y que `salud_estudiantil` tenga los datos de la etapa 1. Si falta contenido, ejecuta `php artisan db:seed`.
2. En la carpeta del proyecto, ejecuta `php artisan serve --host=127.0.0.1 --port=8000`.
3. Abre `http://127.0.0.1:8000/`. Debes ver tres artículos recientes.
4. Entra a `/informacion` y prueba `/informacion?categoria=sueno`; abre un artículo y vuelve al listado.
5. Entra a `/quiz`. Lee el aviso, responde las doce preguntas y pulsa **Ver mi resultado**.
6. Comprueba el puntaje, nivel, recomendación, puntajes por categoría, artículos sugeridos y el aviso orientativo en `/quiz/resultado/{intento}`.
7. Abre `/desarrolladores` para comprobar la última ruta.

Para verificar en MySQL el último intento creado:

```sql
SELECT id, puntaje_total, nivel FROM intentos ORDER BY id DESC LIMIT 1;
SELECT COUNT(*) AS total_respuestas FROM respuestas
WHERE intento_id = (SELECT MAX(id) FROM intentos);
```

Las pruebas automatizadas están en [FlujoQuizTest.php](tests/Feature/FlujoQuizTest.php). Ejecuta `php artisan test` para comprobar rutas, validación, cálculo, transacción y vistas sin modificar los intentos reales de MySQL; PHPUnit usa SQLite temporal.
