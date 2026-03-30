<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archive_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('decade', 10);
            $table->string('path');
            $table->timestamps();

            $table->index(['decade', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archive_photos');
    }
};
