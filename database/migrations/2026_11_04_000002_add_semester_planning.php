<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
 Schema::table('semestres', function(Blueprint $t) { $t->date('fecha_inicio')->nullable(); $t->date('fecha_fin')->nullable(); });
 Schema::table('semanas', function(Blueprint $t) { $t->text('planificacion')->nullable(); });
 }
 public function down(): void {
 Schema::table('semanas', fn(Blueprint $t) => $t->dropColumn('planificacion'));
 Schema::table('semestres', fn(Blueprint $t) => $t->dropColumn(['fecha_inicio','fecha_fin']));
 }
};
