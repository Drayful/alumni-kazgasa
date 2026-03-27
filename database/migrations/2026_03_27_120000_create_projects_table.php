<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('icon')->default('🎓');
            $table->string('title');
            $table->string('tags')->nullable();
            $table->string('button_text');
            $table->text('short');
            $table->text('how_it_works');
            $table->text('what_you_get');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

