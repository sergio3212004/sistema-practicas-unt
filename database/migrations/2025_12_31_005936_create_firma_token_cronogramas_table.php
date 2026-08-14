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
        Schema::create('firma_token_cronogramas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cronograma_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('token')->unique();
            $table->string('rol'); // jefe_directo
            $table->timestamp('usado_en')->nullable();
            $table->timestamp('expira_en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firma_token_cronogramas');
    }
};
