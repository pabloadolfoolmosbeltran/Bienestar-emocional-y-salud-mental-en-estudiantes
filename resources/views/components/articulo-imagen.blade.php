@props(['articulo', 'variant' => 'card'])

@if ($articulo->imagen && $articulo->imagenRegistro)
    <figure class="article-image article-image-{{ $variant }} mb-0">
        <img src="{{ asset('storage/'.$articulo->imagen) }}"
             alt="{{ $articulo->imagenRegistro->descripcion ?: 'Fotografía relacionada con '.$articulo->categoria }}"
             loading="lazy" decoding="async">
        <figcaption>
            Foto: {{ $articulo->imagenRegistro->autor ?: 'autor por verificar' }}
            en <a href="{{ $articulo->imagenRegistro->url_origen }}" target="_blank" rel="noopener noreferrer">Pexels</a>
        </figcaption>
    </figure>
@endif
