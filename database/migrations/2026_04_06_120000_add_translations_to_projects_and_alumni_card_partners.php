<?php

use App\Models\AlumniCardPartner;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('what_you_get');
        });

        Schema::table('alumni_card_partners', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('note');
        });

        $projectFields = ['title', 'tags', 'button_text', 'short', 'how_it_works', 'what_you_get'];
        Project::query()->orderBy('id')->chunkById(50, function ($projects) use ($projectFields): void {
            foreach ($projects as $p) {
                $ru = [];
                foreach ($projectFields as $f) {
                    $ru[$f] = (string) ($p->getRawOriginal($f) ?? '');
                }
                $p->translations = [
                    'ru' => $ru,
                    'kk' => array_fill_keys($projectFields, ''),
                    'en' => array_fill_keys($projectFields, ''),
                ];
                $p->saveQuietly();
            }
        });

        $partnerFields = ['name', 'discount', 'description', 'popup', 'note'];
        AlumniCardPartner::query()->orderBy('id')->chunkById(50, function ($partners) use ($partnerFields): void {
            foreach ($partners as $p) {
                $ru = [];
                foreach ($partnerFields as $f) {
                    $ru[$f] = (string) ($p->getRawOriginal($f) ?? '');
                }
                $p->translations = [
                    'ru' => $ru,
                    'kk' => array_fill_keys($partnerFields, ''),
                    'en' => array_fill_keys($partnerFields, ''),
                ];
                $p->saveQuietly();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('translations');
        });

        Schema::table('alumni_card_partners', function (Blueprint $table) {
            $table->dropColumn('translations');
        });
    }
};
