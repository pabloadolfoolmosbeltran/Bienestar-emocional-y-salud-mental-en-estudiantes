<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('archivo');
            $table->string('ruta')->unique();
            $table->string('tema');
            $table->string('descripcion')->nullable();
            $table->string('autor')->nullable();
            $table->string('fuente')->nullable();
            $table->string('licencia')->nullable();
            $table->string('url_origen')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
