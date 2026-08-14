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
        Schema::create('firma_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ficha_registro_id');
            $table->foreign('ficha_registro_id')->on('fichas_registro')->references('id')->cascadeOnDelete();
            $table->string('email');
            $table->enum('tipo', ['empresa', 'jefe_directo']);
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firma_tokens');
    }
};
