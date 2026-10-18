<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rangos_resultado', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('min');
            $table->unsignedSmallInteger('max');
            $table->string('nivel');
            $table->string('titulo');
            $table->text('recomendacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangos_resultado');
    }
};
