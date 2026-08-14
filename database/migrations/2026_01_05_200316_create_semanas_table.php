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
        Schema::create('semanas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aula_id')->constrained('aulas')->onDelete('cascade');
            $table->unsignedBigInteger('numero'); // 1 a 15
            $table->string('nombre')->nullable(); // Semana 1, Semana 2, Informe Unidad I, Informe Final
/*            $table->boolean('es_informe')->default(false);
            $table->boolean('es_final')->default(false);*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semanas');
    }
};
