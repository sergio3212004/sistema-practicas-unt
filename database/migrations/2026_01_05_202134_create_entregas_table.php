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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades')->cascadeOnDelete();
            $table->foreignId('alumno_id')->constrained('alumnos')->cascadeOnDelete();

            $table->string('ruta')->nullable();

            $table->enum('estado', [
                'pendiente',
                'entregado',
                'observado',
                'aprobado'
            ])->default('pendiente');

            $table->decimal('nota', 5, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_entrega')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
