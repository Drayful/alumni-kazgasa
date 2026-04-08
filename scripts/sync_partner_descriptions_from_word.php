<?php

declare(strict_types=1);

use App\Models\AlumniCardPartner;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

/**
 * Word source: "казгаса перевод.docx" section "7. Описания партнёров"
 * Extracted text snapshot stored in storage/app/_w_site.txt (for traceability).
 *
 * This script updates alumni_card_partners.translations JSON (kk/en name+description),
 * and aligns the RU description column with the Word RU line.
 *
 * NOTE: We intentionally do not touch discount/popup/note translations here.
 */
$map = [
    'Школа KazGASA' => [
        'ru' => ['name' => 'Школа KazGASA', 'description' => 'Скидка распространяется на детей и внуков выпускников KazGASA.'],
        'kk' => ['name' => 'KazGASA мектебі', 'description' => 'Жеңілдік KazGASA түлектерінің балалары мен немерелеріне таралады.'],
        'en' => ['name' => 'KazGASA School', 'description' => 'Discount applies to children and grandchildren of KazGASA alumni.'],
    ],
    'Школа КАУ' => [
        'ru' => ['name' => 'Школа КАУ', 'description' => 'Скидка применяется к стоимости обучения за первый учебный год.'],
        'kk' => ['name' => 'КАУ мектебі', 'description' => 'Жеңілдік бірінші оқу жылының құнына қолданылады.'],
        'en' => ['name' => 'KAU School', 'description' => 'Discount applies to the first academic year tuition fee.'],
    ],
    'Digital колледж KazGASA' => [
        'ru' => ['name' => 'Digital колледж KazGASA', 'description' => 'Скидка действует при оформлении договора на первый год.'],
        'kk' => ['name' => 'KazGASA Digital колледжі', 'description' => 'Жеңілдік бірінші жылға шарт жасасқан кезде іс-қимыл жасайды.'],
        'en' => ['name' => 'KazGASA Digital College', 'description' => 'Discount applies upon signing the contract for the first year.'],
    ],
    'Колледж КАУ' => [
        'ru' => ['name' => 'Колледж КАУ', 'description' => 'Подача договора - и скидка активируется по карте выпускника.'],
        'kk' => ['name' => 'КАУ колледжі', 'description' => 'Шарт берілгенде - жеңілдік түлек картасы арқылы іске қосылады.'],
        'en' => ['name' => 'KAU College', 'description' => 'Upon submitting the contract, the discount activates via the Alumni Card.'],
    ],
    'Магистратура KazGASA' => [
        'ru' => ['name' => 'Магистратура KazGASA', 'description' => 'Скидка на поступление и обучение для выпускников и семьи.'],
        'kk' => ['name' => 'KazGASA магистратурасы', 'description' => 'Түлектер мен отбасы мүшелеріне қабылдау және оқыту жеңілдігі.'],
        'en' => ['name' => "KazGASA Master's Programme", 'description' => 'Discount on admission and tuition for alumni and family members.'],
    ],
    'Докторантура KazGASA' => [
        'ru' => ['name' => 'Докторантура KazGASA', 'description' => 'Поддержка выпускников на этапе докторантуры.'],
        'kk' => ['name' => 'KazGASA докторантурасы', 'description' => 'Докторантура кезеңіндегі түлектерді қолдау.'],
        'en' => ['name' => 'KazGASA Doctoral Programme', 'description' => 'Support for alumni at the doctoral stage.'],
    ],
    'FabLab' => [
        'ru' => ['name' => 'FabLab', 'description' => 'Современное пространство для воплощения архитектурных идей в модели.'],
        'kk' => ['name' => 'FabLab', 'description' => 'Сәулеттік идеяларды үлгілерге айналдыру үшін заманауи кеңістік.'],
        'en' => ['name' => 'FabLab', 'description' => 'A modern space for turning architectural ideas into physical models.'],
    ],
    'Лаборатория Дронов' => [
        'ru' => ['name' => 'Лаборатория Дронов', 'description' => 'Аэрофото, тепловизия, 3D-моделирование и пилотирование.'],
        'kk' => ['name' => 'Дрондар зертханасы', 'description' => 'Аэрофото, жылу бейнелеу, 3D-модельдеу және пилотталу.'],
        'en' => ['name' => 'Drone Laboratory', 'description' => 'Aerial photography, thermal imaging, 3D modelling and piloting.'],
    ],
    'Gaudi Paint' => [
        'ru' => ['name' => 'Gaudi Paint', 'description' => 'Скидка на ассортимент водно-дисперсионных акриловых красок и декоративных покрытий.'],
        'kk' => ['name' => 'Gaudi Paint', 'description' => 'Су-дисперсиялық акрил бояулар мен сәндік жабындар ассортиментіне жеңілдік.'],
        'en' => ['name' => 'Gaudi Paint', 'description' => 'Discount on the range of water-based acrylic paints and decorative coatings.'],
    ],
    'Автошкола Sapar' => [
        'ru' => ['name' => 'Автошкола Sapar', 'description' => 'Права с нуля Алматы: теория + практика + экзамен.'],
        'kk' => ['name' => 'Sapar автомектебі', 'description' => 'Алматыда нөлден жүргізуші куәлігі: теория + практика + емтихан.'],
        'en' => ['name' => 'Sapar Driving School', 'description' => "Driver's licence from scratch in Almaty: theory + practice + exam."],
    ],
];

$updated = 0;
$missing = [];

foreach ($map as $ruKey => $t) {
    /** @var AlumniCardPartner|null $partner */
    $partner = AlumniCardPartner::query()->where('name', $ruKey)->first();
    if (! $partner) {
        $missing[] = $ruKey;
        continue;
    }

    $translations = is_array($partner->translations) ? $partner->translations : [];
    foreach (['ru', 'kk', 'en'] as $loc) {
        if (! isset($translations[$loc]) || ! is_array($translations[$loc])) {
            $translations[$loc] = [];
        }
    }

    foreach (['ru', 'kk', 'en'] as $loc) {
        $translations[$loc]['name'] = $t[$loc]['name'];
        $translations[$loc]['description'] = $t[$loc]['description'];
    }

    $partner->translations = $translations;
    $partner->description = $t['ru']['description'];
    $partner->save();
    $updated++;
}

echo "updated={$updated}\n";
if ($missing) {
    echo 'missing=' . implode(';', $missing) . "\n";
}

