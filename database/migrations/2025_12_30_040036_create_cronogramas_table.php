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
        Schema::create('cronogramas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ficha_id');
            $table->foreign('ficha_id')
                ->references('id')
                ->on('fichas_registro')
                ->onDelete('cascade');
            // Estados de firma
            $table->string('firma_practicante')->nullable();
            $table->string('firma_jefe_directo')->nullable();
            $table->string('firma_profesor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cronogramas');
    }
};
