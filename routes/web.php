<?php

use App\Http\Controllers\AlumniCardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Profile\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\ApplicationController;
use App\Http\Controllers\SuperAdmin\StatsController;
use App\Http\Controllers\Wallet\AppleWalletController;
use App\Http\Controllers\Wallet\GoogleWalletController;
use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faces', function () {
    $faces = [
        ['name' => 'Кушербаев Крымбек Елеуович', 'subtitle' => 'Выпускник', 'role' => 'Бывший Министр науки и высшего образования Республики Казахстан'],
        ['name' => 'Касымбек Женис Махмудович', 'subtitle' => 'Выпускник', 'role' => 'Аким города Астаны'],
        ['name' => 'Белович Александр Якубович', 'subtitle' => 'Выпускник', 'role' => 'Председатель Совета директоров ТОО «Холдинговая компания BAZIS»'],
        ['name' => 'Абдуллин Нурлан Муханович', 'subtitle' => 'Выпускник', 'role' => 'Казахстанский эстрадный певец, телеведущий, бизнесмен. Заслуженный деятель Казахстана. Почётный строитель Республики Казахстан'],
        ['name' => 'Ким Владимир Сергеевич', 'subtitle' => 'Выпускник', 'role' => 'Президент, неисполнительный директор и акционер KAZ Minerals Ltd'],
        ['name' => 'Баталов Раимбек Анварович', 'subtitle' => 'Выпускник', 'role' => 'Казахстанский предприниматель, общественный деятель, основатель и председатель совета директоров холдинга Raimbek Group'],
        ['name' => 'Татыгулов Айдар Абдысагитович', 'subtitle' => 'Член совета', 'role' => 'Президент «KAZGOR»'],
        ['name' => 'Кулмаханов Шерхан Кельдебекович', 'subtitle' => 'Выпускник', 'role' => 'Советник Первого Президента РК - Елбасы'],
        ['name' => 'Фазылов Сайран Ахметжанович', 'subtitle' => 'Выпускник', 'role' => 'Директор ТОО «Arkaz Engineering»'],
        ['name' => 'Бектемирова Жанна', 'subtitle' => 'Выпускник', 'role' => 'Основательница Шар Курылыс и GLB'],
        ['name' => 'Султангали Серик Султангалиевич', 'subtitle' => 'Выпускник', 'role' => 'Председатель совета директоров АО «КазТрансГаз»'],
        ['name' => 'Турсунбаев Шерхан Шаймерденович', 'subtitle' => 'Выпускник', 'role' => 'Заместитель руководителя аппарата акима города Алматы'],
        ['name' => 'Сандыкбаев Болаткан Айткожанович', 'subtitle' => 'Выпускник', 'role' => 'Экс-Председатель Правления АО «Samruk-Kazyna Construction»'],
        ['name' => 'Салемов Серик Жаксылыкович', 'subtitle' => 'Выпускник', 'role' => 'Заместитель акима Жамбылской области'],
        ['name' => 'Абаканов Танаткан Доскараевич', 'subtitle' => 'Выпускник / ППС', 'role' => 'Доктор технических наук, академик КазНАЕН, эксперт ЮНЕСКО по проблемам землетрясений'],
        ['name' => 'Аужанов Нурбек Габдулхамитович', 'subtitle' => 'Выпускник ША', 'role' => 'Директор ТОО «Градкомплекс»'],
        ['name' => 'Ажгалиев Аубакир Гусманович', 'subtitle' => 'Выпускник', 'role' => 'Председатель ПРК «Актюбгражданпроект», почётный строитель РК, кавалер ордена «Құрмет»'],
        ['name' => 'Алдабергенов Нурлан Шадибекович', 'subtitle' => 'Выпускник', 'role' => 'Экс-ответственный секретарь Министерства национальной экономики РК'],
        ['name' => 'Баталов Аскар Болатович', 'subtitle' => 'Выпускник', 'role' => 'Экс-Генеральный директор ПСК «Астана»'],
        ['name' => 'Бижанов Нурахмет Кусаинович', 'subtitle' => 'Выпускник', 'role' => 'Председатель Агентства РК по чрезвычайным ситуациям, к.т.н.'],
        ['name' => 'Бисенов Кылышбай Алдабергенович', 'subtitle' => 'Выпускник', 'role' => 'Учёный в области строительства, основатель научной школы по энергоресурсосберегающим технологиям, «Қазақстанның еңбек сіңірген қайраткері»'],
        ['name' => 'Дюсембинов Султан Мырзабекович', 'subtitle' => 'Выпускник', 'role' => 'Депутат Сената Парламента Казахстана'],
        ['name' => 'Ермекбаев Нурлан Байузакович', 'subtitle' => 'Выпускник', 'role' => 'Генеральный секретарь Шанхайской организации сотрудничества'],
        ['name' => 'Сембаев Еркебулан Алдашевич', 'subtitle' => 'Выпускник', 'role' => 'Заместитель руководителя управления архитектуры и градостроительства'],
        ['name' => 'Ордабаев Алмас Баймуханович', 'subtitle' => 'Выпускник', 'role' => 'Доктор философии по архитектуре, вице-президент Союза дизайнеров Казахстана, почётный архитектор Казахстана'],
        ['name' => 'Стамбеков Ерлан Даулетович', 'subtitle' => 'Выпускник', 'role' => 'Депутат Мажилиса Парламента РК VIII созыва'],
        ['name' => 'Жунусов Сарсембек Ендибаевич', 'subtitle' => 'Выпускник', 'role' => 'Директор ТОО «НИПИ «Астанагенплан» / депутат маслихата г. Астана'],
        ['name' => 'Кенбаев Алмас Адилбаевич', 'subtitle' => 'Выпускник', 'role' => 'Директор филиала РГП «Национальный центр геодезии и пространственной информации»'],
        ['name' => 'Мусина Бактыгуль Рамазановна', 'subtitle' => 'Выпускник', 'role' => 'Глава крестьянского хозяйства «Дина», член Совета деловых женщин при НПП «Атамекен»'],
        ['name' => 'Кабдолдин Ринат Мырзаканович', 'subtitle' => 'Выпускник', 'role' => 'Директор Ras Group (архитектурно-проектная компания)'],
        ['name' => 'Евсеев Александр', 'subtitle' => 'Выпускник', 'role' => 'Директор ТОО «КазСтрой АкЖол Курылыс», Caravan Resources Group'],
        ['name' => 'Темирбаев Ильяс Келгенбаевич', 'subtitle' => 'Выпускник', 'role' => 'Директор ТОО «Казгипроград»'],
        ['name' => 'Жунусов Бейсен', 'subtitle' => 'Выпускник', 'role' => 'Главный архитектор районов Алматы, генеральный директор Художественного фонда КазССР'],
        ['name' => 'Баккулов Марат Сатыбалдиевич', 'subtitle' => 'Выпускник', 'role' => 'Основатель и владелец ТОО «АВЗ» (Алматинский вентиляторный завод)'],
        ['name' => 'Ганина Светлана Александровна', 'subtitle' => 'Выпускник ШИ', 'role' => 'Генеральный директор АО «Ремстройтехника» (2010–2021), 40 лет в строительстве'],
        ['name' => 'Дәулет Нурбек', 'subtitle' => 'Выпускник ШИ', 'role' => 'Исполнительный директор ИП NB GROUP'],
        ['name' => 'Ершов Сергей Михайлович', 'subtitle' => 'Выпускник ШС', 'role' => 'Вице-президент ТОО Корпорация «Казахмыс»'],
    ];

    return view('faces.index', compact('faces'));
})->name('faces.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Публичный экран карты выпускника по public_id
Route::get('/card/{publicId}', [AlumniCardController::class, 'show'])
    ->name('alumni.card.show');

// Публичная выдача Apple Wallet (.pkpass) по public_id профиля
Route::get('/wallet/apple/{publicId}', [AppleWalletController::class, 'downloadPublic'])
    ->name('wallet.apple');

// Публичная ссылка "Save to Google Wallet" по public_id профиля
Route::get('/wallet/google/{publicId}', [GoogleWalletController::class, 'redirectPublic'])
    ->name('wallet.google');

// 1x1 прозрачный PNG для Google Wallet (logo класса)
Route::get('/wallet/blank.png', function () {
    $base64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAOZ3aX8AAAAASUVORK5CYII=';
    $bin = base64_decode($base64, true);
    abort_if($bin === false, 500, 'Не удалось декодировать PNG');

    return response($bin, 200, [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->name('wallet.blank-png');

// Подача заявки на партнёрство (для формы на главной)
Route::post('/partner/apply', [PartnerController::class, 'apply'])
    ->name('partner.apply');

// Кабинет супер-админа
Route::prefix('super-admin')
    ->middleware(['auth', 'super.admin'])
    ->name('super-admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('users', SuperAdminUserController::class);
        Route::patch('users/{user}/status', [SuperAdminUserController::class, 'updateStatus'])
            ->name('users.status');
        Route::post('users/{user}/reset-password', [SuperAdminUserController::class, 'resetPassword'])
            ->name('users.reset-password');

        Route::get('applications', [ApplicationController::class, 'index'])
            ->name('applications.index');
        Route::get('applications/{application}', [ApplicationController::class, 'show'])
            ->name('applications.show');
        Route::patch('applications/{application}/approve', [ApplicationController::class, 'approve'])
            ->name('applications.approve');
        Route::patch('applications/{application}/reject', [ApplicationController::class, 'reject'])
            ->name('applications.reject');
        Route::patch('applications/{application}/suspend', [ApplicationController::class, 'suspend'])
            ->name('applications.suspend');

        Route::get('stats', [StatsController::class, 'index'])
            ->name('stats');
    });

Route::middleware('auth')->group(function () {
    Route::get('/vacancies', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/vacancies/{id}', [JobController::class, 'show'])
        ->name('jobs.show')
        ->where('id', '[0-9]+');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/alumni', [ProfileController::class, 'updateAlumni'])->name('profile.alumni.update');
    Route::post('/profile/photo', [PhotoController::class, 'update'])->name('profile.photo.update');
    Route::delete('/profile/photo', [PhotoController::class, 'destroy'])->name('profile.photo.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
