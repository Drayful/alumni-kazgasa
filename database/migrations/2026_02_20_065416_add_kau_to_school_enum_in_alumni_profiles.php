<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE alumni_profiles MODIFY COLUMN school ENUM('ШИ','ША','ШС','ШД','КАУ') NOT NULL");
    }

    public function down(): void
    {
        // Перед удалением КАУ нужно обновить записи с school='КАУ' на другое значение
        DB::table('alumni_profiles')->where('school', 'КАУ')->update(['school' => 'ШИ']);
        DB::statement("ALTER TABLE alumni_profiles MODIFY COLUMN school ENUM('ШИ','ША','ШС','ШД') NOT NULL");
    }
};
