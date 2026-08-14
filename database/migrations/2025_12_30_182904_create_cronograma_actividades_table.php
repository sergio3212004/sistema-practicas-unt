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
        Schema::create('cronograma_actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cronograma_id')
                ->constrained('cronogramas')
                ->onDelete('cascade');

            $table->string('actividad');

            // Mes 1
            $table->boolean('m1_s1')->default(false);
            $table->boolean('m1_s2')->default(false);
            $table->boolean('m1_s3')->default(false);
            $table->boolean('m1_s4')->default(false);

            // Mes 2
            $table->boolean('m2_s1')->default(false);
            $table->boolean('m2_s2')->default(false);
            $table->boolean('m2_s3')->default(false);
            $table->boolean('m2_s4')->default(false);

            // Mes 3
            $table->boolean('m3_s1')->default(false);
            $table->boolean('m3_s2')->default(false);
            $table->boolean('m3_s3')->default(false);
            $table->boolean('m3_s4')->default(false);

            // Mes 4
            $table->boolean('m4_s1')->default(false);
            $table->boolean('m4_s2')->default(false);
            $table->boolean('m4_s3')->default(false);
            $table->boolean('m4_s4')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cronograma_actividades');
    }
};
