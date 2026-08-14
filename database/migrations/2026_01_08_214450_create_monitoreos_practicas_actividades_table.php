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
        Schema::create('monitoreos_practicas_actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoreo_practica_id')->constrained('monitoreos_practicas')->onDelete('cascade');
            $table->foreignId('cronograma_actividad_id')->constrained('cronograma_actividades')->onDelete('cascade');
            $table->boolean('al_dia')->default(false);
            $table->string('observacion')->nullable();
            $table->string('firma_practicante')->nullable();
            $table->string('firma_supervisor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoreos_practicas_actividades');
    }
};
