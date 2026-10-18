@extends('layouts.app')

@section('titulo', 'Información | Pausa')

@section('contenido')
    <section class="page-intro">
        <div class="container">
            <p class="eyebrow mb-3">Recursos para estudiantes</p>
            <h1 class="mb-3">Información que acompaña</h1>
            <p class="lead mb-0">Consejos breves y prácticos sobre estrés, descanso, estudio y apoyo para quienes combinan clases con otras responsabilidades.</p>
        </div>
    </section>

    <section class="section-space" aria-labelledby="lista-articulos">
        <div class="container">
            <form class="filter-panel row g-4 align-items-end section-gap" method="get" action="{{ route('informacion.index') }}">
                <div class="col-md-8">
                    <label class="form-label fw-bold" for="categoria">Explorar por tema</label>
                    <select class="form-select" id="categoria" name="categoria">
                        <option value="">Todos los temas</option>
                        <option value="estres" @selected($categoria === 'estres')>Estrés</option>
                        <option value="sueno" @selected($categoria === 'sueno')>Sueño</option>
                        <option value="tiempo" @selected($categoria === 'tiempo')>Tiempo y estudio</option>
                        <option value="animo" @selected($categoria === 'animo')>Ánimo</option>
                        <option value="apoyo" @selected($categoria === 'apoyo')>Apoyo</option>
                    </select>
                </div>
                <div class="col-md-4 d-grid d-sm-flex d-md-grid gap-4">
                    <button class="btn btn-pausa" type="submit">Filtrar artículos</button>
                </div>
            </form>

            <div class="section-head-row d-flex flex-wrap align-items-end justify-content-between gap-4">
                <div>
                    <p class="eyebrow mb-2">Biblioteca</p>
                    <h2 id="lista-articulos" class="h3 mb-0">Artículos disponibles</h2>
                </div>
                <span class="text-muted-custom">{{ $articulos->total() }} artículos</span>
            </div>

            <div class="row g-4">
                @forelse ($articulos as $articulo)
                    <div class="col-md-6 col-lg-4">
                        <article class="card card-lift">
                            <x-articulo-imagen :articulo="$articulo" />
                            <div class="card-body d-flex flex-column">
                                <x-categoria :nombre="$articulo->categoria" />
                                <h3 class="article-card-title h4 mt-3">
                                    <a href="{{ route('informacion.show', $articulo) }}">{{ $articulo->titulo }}</a>
                                </h3>
                                <p class="text-muted-custom mb-3">{{ $articulo->resumen }}</p>
                                <a class="arrow-link mt-auto" href="{{ route('informacion.show', $articulo) }}">Leer artículo</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="notice-card">
                            <h3 class="h5 mb-2">Aún no hay artículos en este tema</h3>
                            <p class="mb-3">Prueba con otra categoría o explora todas las lecturas.</p>
                            <a class="arrow-link" href="{{ route('informacion.index') }}">Ver todos los artículos</a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="section-gap-top d-flex justify-content-center">
                {{ $articulos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
@endsection
