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
        Schema::create('formatos_doce_alumno', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formato_doce_id')->constrained('formatos_doce')->onDelete('cascade');
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->enum('nivel', ['inicial', 'intermedio', 'avanzado'])->default('inicial');
            $table->string('sede_practica');
            $table->string('responsable');
            $table->string('contacto_responsable');
            $table->boolean('al_dia')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formatos_doce_alumno');
    }
};
