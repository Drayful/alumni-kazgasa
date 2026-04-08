<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // All project texts now live in `translations` JSON.
            $table->dropColumn([
                'title',
                'tags',
                'button_text',
                'short',
                'how_it_works',
                'what_you_get',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title')->after('icon');
            $table->string('tags')->nullable()->after('title');
            $table->string('button_text')->after('tags');
            $table->text('short')->after('button_text');
            $table->text('how_it_works')->after('short');
            $table->text('what_you_get')->after('how_it_works');
        });
    }
};

