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
            $table->unsignedInteger('study_group')->nullable()->after('specialty')->comment('Группа из iPortal');
            $table->unsignedInteger('study_form')->nullable()->after('study_group')->comment('Форма обучения');
            $table->unsignedInteger('institut_id')->nullable()->after('study_form')->comment('Факультет/институт');
            $table->unsignedInteger('edu_op')->nullable()->after('institut_id')->comment('ОП — образовательная программа');
            $table->unsignedInteger('edu_program')->nullable()->after('edu_op')->comment('ГОП');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->dropColumn(['study_group', 'study_form', 'institut_id', 'edu_op', 'edu_program']);
        });
    }
};
