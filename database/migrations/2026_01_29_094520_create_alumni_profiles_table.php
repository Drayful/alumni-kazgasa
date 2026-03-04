<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ИИН и связь с iPortal
            $table->string('iin', 12)->unique();
            $table->unsignedBigInteger('portal_persons_id')->nullable()->unique();

            // Персональные данные
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('photo')->nullable();

            // Академическая информация
            $table->enum('school', ['ШИ', 'ША', 'ШС', 'ШД']);
            $table->year('graduation_year');
            $table->string('specialty')->nullable();
            $table->string('degree')->nullable();

            // Статус карты выпускника
            $table->enum('status', ['Elite', 'Core', 'Start', 'Connect'])->default('Connect');
            $table->string('public_id', 20)->unique(); // Для QR-кода
            $table->enum('membership_type', ['free', 'paid'])->default('free');
            $table->date('membership_expiry_date')->nullable();

            // Статус верификации
            $table->enum('verification_status', ['pending', 'verified', 'manual'])->default('pending');

            // Контакты и работа
            $table->string('current_company')->nullable();
            $table->string('position')->nullable();
            $table->text('bio')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};
