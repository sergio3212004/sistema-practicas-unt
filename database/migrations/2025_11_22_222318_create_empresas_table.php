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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11)->unique();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('nombre');
            $table->string('telefono', 9)->nullable(); // Cambiado a 15 para números internacionales
            $table->string('departamento', 50)->nullable(); // ← AGREGADO
            $table->string('provincia', 50)->nullable();    // ← AGREGADO
            $table->string('distrito', 50)->nullable();     // ← AGREGADO
            $table->string('direccion', 255)->nullable();   // ← AGREGADO y aumentado tamaño
            $table->boolean('aprobado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
