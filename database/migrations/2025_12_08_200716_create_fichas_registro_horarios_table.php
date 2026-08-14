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
        Schema::create('fichas_registro_horarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ficha_registro_id');
            $table->foreign('ficha_registro_id')->references('id')->on('fichas_registro')->onDelete('cascade');

            // 1 = Lunes, 2 = Martes ... 7 = Sábado
            $table->unsignedTinyInteger('dia_semana');

            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_registro_horarios');
    }
};
