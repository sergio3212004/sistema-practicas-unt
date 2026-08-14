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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aula_id')->constrained('aulas')->cascadeOnDelete();
            $table->foreignId('semana_id')->constrained('semanas')->cascadeOnDelete();
            $table->foreignId('tipo_actividad_id')->constrained('tipos_actividad')->cascadeOnDelete();

            $table->string('titulo');
            $table->text('descripcion')->nullable();

            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_limite');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
