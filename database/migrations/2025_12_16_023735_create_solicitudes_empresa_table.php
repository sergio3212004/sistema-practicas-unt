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
        Schema::create('solicitudes_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11)->unique();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password'); // Hasheado
            $table->foreignId('razon_social_id')->constrained('razones_sociales');
            $table->string('telefono', 9)->nullable();
            $table->string('departamento', 50)->nullable();
            $table->string('provincia', 50)->nullable();
            $table->string('distrito', 50)->nullable();
            $table->string('direccion')->nullable();
            $table->boolean('email_verificado')->default(false);
            $table->string('codigo_verificacion', 6)->nullable();
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('motivo_rechazo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_empresa');
    }
};
