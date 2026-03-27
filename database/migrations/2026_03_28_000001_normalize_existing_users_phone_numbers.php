<?php

use App\Support\PhoneNormalizer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereNotNull('phone')
            ->orderBy('id')
            ->chunkById(100, function ($users): void {
                foreach ($users as $row) {
                    $normalized = PhoneNormalizer::normalize($row->phone);
                    if ($normalized !== null && $normalized !== $row->phone) {
                        DB::table('users')->where('id', $row->id)->update(['phone' => $normalized]);
                    }
                }
            });
    }

    public function down(): void
    {
        // Неотменяемо: исходные форматы не сохранялись
    }
};
