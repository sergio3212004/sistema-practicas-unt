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
        Schema::create('informes_finales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->string('archivo_pdf'); // path del archivo
            $table->string('nombre_original'); // nombre original del archivo
            $table->bigInteger('tamanio'); // tamaño en bytes
            $table->foreignId('semestre_id')->nullable()->constrained('semestres')->onDelete('set null');
            $table->timestamp('fecha_subida');

            // Un alumno solo puede tener un informe final por semestre
            $table->unique(['alumno_id', 'semestre_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes_finales');
    }
};
