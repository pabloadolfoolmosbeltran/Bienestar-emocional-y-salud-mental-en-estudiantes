@props(['nombre'])

@php
    $etiquetas = [
        'estres' => 'Estrés',
        'sueno' => 'Sueño',
        'tiempo' => 'Tiempo y estudio',
        'animo' => 'Ánimo',
        'apoyo' => 'Apoyo',
    ];
@endphp

<span class="category-pill">{{ $etiquetas[$nombre] ?? ucfirst($nombre) }}</span>
