<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE alumni_profiles MODIFY verification_status
            ENUM(
                'pending',
                'verified',
                'rejected',
                'inactive',
                'expired',
                'suspended'
            ) DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // При необходимости можно вернуть прежний ENUM.
    }
};
