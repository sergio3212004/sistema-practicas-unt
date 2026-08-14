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
        Schema::create('fichas_registro', function (Blueprint $table) {
            $table->id();
            // Datos del alumno
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')
                ->references('id')
                ->on('alumnos')
                ->onDelete('cascade');
            $table->unsignedInteger('ciclo');
            $table->unsignedBigInteger('semestre_id');
            $table->foreign('semestre_id')
                ->references('id')
                ->on('semestres')
                ->onDelete('cascade');

            // Datos de la empresa
            $table->string('razon_social', 80);
            $table->char('ruc', 11);
            $table->string('correo_empresa'); // Correo de la empresa
            $table->string('nombre_gerente', 80);
            $table->string('nombre_jefe_rrhh', 80);
            $table->string('direccion', 255);
            $table->string('telefono_fijo', 10);
            $table->string('telefono_movil', 9);
            $table->string('departamento', 50);
            $table->string('provincia', 50);
            $table->string('distrito', 50);

            // Caracteristicas de la práctica
            $table->date('fecha_inicio');
            $table->date('fecha_termino');

            $table->text('descripcion');
            $table->string('area_practicas', 50);
            $table->string('cargo', 50);
            $table->string('nombre_jefe_directo', 80);
            $table->string('telefono_jefe_directo', 80);
            $table->string('correo_jefe_directo');
            // Firmas
            $table->string('firma_empresa')->nullable();
            $table->string('firma_programa')->nullable();
            $table->string('firma_practicante')->nullable();
            $table->boolean('aceptado')->default(null)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_registro');
    }
};
