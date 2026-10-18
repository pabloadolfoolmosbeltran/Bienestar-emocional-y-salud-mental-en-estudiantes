@extends('layouts.app')

@section('titulo', $articulo->titulo . ' | Pausa')
@section('contenido')
    <section class="page-intro">
        <div class="container article-body">
            <nav aria-label="Ruta de navegación">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('informacion.index') }}">Información</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Artículo</li>
                </ol>
            </nav>
            <x-categoria :nombre="$articulo->categoria" />
            <h1 class="mt-3 mb-3">{{ $articulo->titulo }}</h1>
            <p class="lead mb-0">{{ $articulo->resumen }}</p>
        </div>
    </section>

    <section class="section-space">
        <div class="container article-body">
            <article class="card card-lift">
                <div class="card-body p-4 p-md-5">
                    <div class="article-content">{!! $articulo->contenido !!}</div>
                </div>
            </article>
            <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                <a class="btn btn-pausa-outline" href="{{ route('informacion.index') }}">← Volver a los artículos</a>
                <a class="btn btn-pausa" href="{{ route('quiz.index') }}">Conocer el quiz orientativo</a>
            </div>
        </div>
    </section>
@endsection
