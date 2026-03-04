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
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->string('study_group_name')->nullable()->after('study_group')->comment('Название группы из portal_agroups');
            $table->string('edu_op_name')->nullable()->after('edu_op')->comment('Название ОП из portal_sp_edu_op');
            $table->string('edu_program_name')->nullable()->after('edu_program')->comment('Название ГОП из portal_sp_group_edu_op');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->dropColumn(['study_group_name', 'edu_op_name', 'edu_program_name']);
        });
    }
};
