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
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('numero');

            $table->unsignedBigInteger('semestre_id')->nullable();
            $table->foreign('semestre_id')
                ->references('id')
                ->on('semestres')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('profesor_id')->nullable();
            $table->foreign('profesor_id')
                ->references('id')
                ->on('profesores')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};
