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
            $table->string('faculty_name')->nullable()->after('institut_id')->comment('Название факультета из portal_sp_faculties');
            $table->string('study_form_name')->nullable()->after('study_form')->comment('Название формы обучения из portal_sp_edu_form');
            $table->string('study_level_name')->nullable()->after('degree')->comment('Степень/уровень из portal_sp_edu_level');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->dropColumn(['faculty_name', 'study_form_name', 'study_level_name']);
        });
    }
};
