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
        Schema::create('formatos_once_alumno', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formato_once_id')->constrained('formatos_once')->onDelete('cascade');
            $table->foreignId('alumno_id')->constrained('alumnos')->cascadeOnDelete();
            $table->string('sede_practicas');
            $table->string('ciclo_nivel');
            $table->string('competencias');
            $table->string('capacidades');
            $table->string('actividades');
            $table->string('producto');
            $table->boolean('conformidad');
            $table->string('comentarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formatos_once_alumno');
    }
};
