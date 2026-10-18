<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f8f4">
    <title>@yield('titulo', 'Pausa | Bienestar estudiantil')</title>
    <meta name="description" content="Un espacio de bienestar emocional para estudiantes: recursos útiles, reflexión y apoyo.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <link href="{{ asset('css/salud.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <a class="skip-link" href="#contenido">Saltar al contenido</a>

    <header class="site-header">
        <nav class="navbar navbar-expand-lg" aria-label="Navegación principal">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('inicio') }}" aria-label="Pausa, ir al inicio">
                    <span class="brand-mark" aria-hidden="true">✦</span>
                    <span>Pausa<span class="brand-dot">.</span></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegacion"
                        aria-controls="navegacion" aria-expanded="false" aria-label="Abrir navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navegacion">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}"
                               @if (request()->routeIs('inicio')) aria-current="page" @endif>Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('informacion.*') ? 'active' : '' }}" href="{{ route('informacion.index') }}"
                               @if (request()->routeIs('informacion.*')) aria-current="page" @endif>Información</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('quiz.*') ? 'active' : '' }}" href="{{ route('quiz.index') }}"
                               @if (request()->routeIs('quiz.*')) aria-current="page" @endif>Quiz</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('desarrolladores.index') ? 'active' : '' }}" href="{{ route('desarrolladores.index') }}"
                               @if (request()->routeIs('desarrolladores.index')) aria-current="page" @endif>Desarrolladores</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main id="contenido" class="flex-grow-1">
        @yield('contenido')
    </main>

    <footer class="site-footer mt-auto">
        <div class="container py-4 py-md-5">
            <div class="row g-4 align-items-end">
                <div class="col-md-7">
                    <a class="footer-brand" href="{{ route('inicio') }}">Pausa<span class="brand-dot">.</span></a>
                    <p class="mb-0 mt-2">Un espacio para aprender, reflexionar y pedir apoyo cuando lo necesites.</p>
                </div>
                <div class="col-md-5 text-md-end">
                    <p class="mb-2">Proyecto académico · Diseño y Programación Web III</p>
                    <a href="{{ route('informacion.index') }}">Recursos</a>
                    <span class="mx-2" aria-hidden="true">·</span>
                    <a href="{{ route('quiz.index') }}">Quiz orientativo</a>
                </div>
            </div>
            <div class="footer-bottom mt-4 pt-3">2026 · Tu bienestar también importa.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
