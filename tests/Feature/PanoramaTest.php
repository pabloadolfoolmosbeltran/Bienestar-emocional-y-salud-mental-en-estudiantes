<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanoramaTest extends TestCase
{
    use RefreshDatabase;

    public function test_panorama_tiene_ruta_fuentes_limites_y_apoyo_y_se_enlaza_desde_inicio(): void
    {
        $this->assertSame('/panorama', route('panorama', [], false));

        $this->get(route('panorama'))
            ->assertOk()
            ->assertSee('Salud mental estudiantil en Bolivia')
            ->assertSee('Dato mundial')
            ->assertSee('Estudio en Bolivia')
            ->assertSee('Información oficial')
            ->assertSee('No existen estadísticas nacionales publicadas de salud mental de estudiantes en Bolivia')
            ->assertSee('Universidad Cristiana de Bolivia')
            ->assertSee('800 11 30 40')
            ->assertSee('77797667')
            ->assertSee('18/10/2026')
            ->assertSee('COMPLETAR')
            ->assertSee('https://www.unicef.org/bolivia/familia-segura', false);

        $this->get(route('inicio'))
            ->assertOk()
            ->assertSee('Conocer el panorama en Bolivia');
    }
}
