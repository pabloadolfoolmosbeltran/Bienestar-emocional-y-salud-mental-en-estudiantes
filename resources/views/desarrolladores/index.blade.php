@extends('layouts.app')

@section('titulo', 'Desarrolladores | Pausa')

@section('contenido')
    <section class="page-intro">
        <div class="container">
            <p class="eyebrow mb-3">Detrás del proyecto</p>
            <h1 class="mb-3">Conoce al equipo</h1>
            <p class="lead mb-0">Pausa es un proyecto académico creado por dos estudiantes de Diseño y Programación Web III para acercar información y reflexión sobre bienestar emocional.</p>
        </div>
    </section>

    <section class="section-space" aria-labelledby="equipo-titulo">
        <div class="container">
            <div class="section-heading mb-4">
                <p class="eyebrow mb-2">Nuestro equipo</p>
                <h2 id="equipo-titulo" class="h2 mb-2">Dos personas, una idea compartida</h2>
                <p class="mb-0">Los nombres, fotos y enlaces se completarán con los datos reales del equipo.</p>
            </div>
            <div class="row g-3 g-lg-4">
                <div class="col-md-6">
                    <article class="card card-lift">
                        <div class="card-body">
                            <div class="team-avatar mb-4" aria-label="Foto pendiente de completar">FOTO<br>COMPLETAR</div>
                            <p class="eyebrow mb-2">Integrante 1</p>
                            <h3 class="h4 mb-2">COMPLETAR</h3>
                            <p class="text-muted-custom mb-0">Enlaces: COMPLETAR</p>
                        </div>
                    </article>
                </div>
                <div class="col-md-6">
                    <article class="card card-lift">
                        <div class="card-body">
                            <div class="team-avatar mb-4" aria-label="Foto pendiente de completar">FOTO<br>COMPLETAR</div>
                            <p class="eyebrow mb-2">Integrante 2</p>
                            <h3 class="h4 mb-2">COMPLETAR</h3>
                            <p class="text-muted-custom mb-0">Enlaces: COMPLETAR</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space surface-soft" aria-labelledby="proposito-titulo">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <p class="eyebrow mb-2">Por qué existe Pausa</p>
                    <h2 id="proposito-titulo" class="h2 mb-3">Bienestar cercano y sin barreras</h2>
                    <p class="text-muted-custom">Queremos que estudiantes que combinan clases, trabajo y otras responsabilidades encuentren ideas útiles en un lugar sencillo de consultar. El contenido invita a reflexionar y a pedir ayuda cuando haga falta.</p>
                    <p class="text-muted-custom mb-0">El quiz ofrece una orientación inicial; no reemplaza la evaluación de un profesional de salud mental.</p>
                </div>
                <div class="col-lg-6">
                    <div class="card card-lift">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="h4 mb-3">Funcionalidades implementadas</h3>
                            <ul class="mb-0 text-muted-custom">
                                <li class="mb-2">Artículos informativos organizados por categoría.</li>
                                <li class="mb-2">Quiz anónimo con preguntas y opciones desde la base de datos.</li>
                                <li class="mb-2">Resultado orientativo con puntaje por categoría.</li>
                                <li>Lecturas sugeridas según las respuestas.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space" aria-labelledby="tecnologias-titulo">
        <div class="container">
            <p class="eyebrow mb-2">Cómo se construyó</p>
            <h2 id="tecnologias-titulo" class="h2 mb-4">Tecnologías y créditos</h2>
            <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="tech-chip">Laravel</span>
                <span class="tech-chip">PHP</span>
                <span class="tech-chip">MySQL</span>
                <span class="tech-chip">Blade</span>
                <span class="tech-chip">Bootstrap 5</span>
                <span class="tech-chip">JavaScript</span>
            </div>
            <p class="text-muted-custom mb-2">Diseño y desarrollo: equipo del proyecto (nombres: COMPLETAR).</p>
            <p class="text-muted-custom mb-0">
                Referencias generales de bienestar: <a href="https://www.who.int/es/news-room/questions-and-answers/item/stress" target="_blank" rel="noopener noreferrer">Organización Mundial de la Salud</a>
                y <a href="https://www.cdc.gov/sleep/about/" target="_blank" rel="noopener noreferrer">CDC, información sobre sueño</a>.
            </p>
        </div>
    </section>
@endsection
