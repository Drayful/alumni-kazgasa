<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->string('manual_edu_op_name')->nullable()->after('edu_op_name');
            $table->string('manual_edu_program_name')->nullable()->after('edu_program_name');
            $table->string('manual_study_group_name')->nullable()->after('study_group_name');
        });

        // Preserve earlier manual entries that were stored in the iPortal display-name columns.
        DB::table('alumni_profiles')
            ->whereNull('edu_op')
            ->whereNotNull('edu_op_name')
            ->update(['manual_edu_op_name' => DB::raw('edu_op_name')]);
        DB::table('alumni_profiles')
            ->whereNull('edu_program')
            ->whereNotNull('edu_program_name')
            ->update(['manual_edu_program_name' => DB::raw('edu_program_name')]);
        DB::table('alumni_profiles')
            ->whereNull('study_group')
            ->whereNotNull('study_group_name')
            ->update(['manual_study_group_name' => DB::raw('study_group_name')]);
    }

    public function down(): void
    {
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'manual_edu_op_name',
                'manual_edu_program_name',
                'manual_study_group_name',
            ]);
        });
    }
};
