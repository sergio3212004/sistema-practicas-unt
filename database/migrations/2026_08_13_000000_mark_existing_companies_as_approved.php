<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Company records only exist after an administrator approves or creates them.
        DB::table('empresas')->update(['aprobado' => true]);
    }

    public function down(): void
    {
        // Approval state is business data and must not be destructively reverted.
    }
};
