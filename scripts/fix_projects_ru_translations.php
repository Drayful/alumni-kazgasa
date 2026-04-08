<?php

declare(strict_types=1);

use App\Models\Project;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$fields = ['title', 'tags', 'button_text', 'short', 'how_it_works', 'what_you_get'];

$updated = 0;
$checked = 0;

Project::query()->orderBy('id')->chunkById(100, function ($projects) use ($fields, &$updated, &$checked): void {
    foreach ($projects as $p) {
        $checked++;
        $tr = is_array($p->translations) ? $p->translations : [];

        foreach (['ru', 'kk', 'en'] as $loc) {
            if (! isset($tr[$loc]) || ! is_array($tr[$loc])) {
                $tr[$loc] = [];
            }
        }

        $changed = false;
        foreach ($fields as $f) {
            $ruCol = (string) ($p->getRawOriginal($f) ?? '');
            if (($tr['ru'][$f] ?? '') === '' && $ruCol !== '') {
                $tr['ru'][$f] = $ruCol;
                $changed = true;
            }
        }

        if ($changed) {
            $p->translations = $tr;
            $p->save();
            $updated++;
        }
    }
});

echo "checked={$checked}\n";
echo "updated={$updated}\n";

