@extends('layouts.home')

@section('title', 'Главная')

@section('content')
<div x-data="{ mobileMenuOpen: false }" class="min-h-screen flex flex-col">
    {{-- 1. TOP BAR --}}
    <div class="w-full h-9 flex items-center justify-end px-4 sm:px-6 lg:px-8" style="background-color: #8F161C;">
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="text-xs font-medium uppercase tracking-wider text-white border border-white px-4 py-1.5 rounded hover:bg-white hover:text-[#8F161C] transition-colors">
                    Личный кабинет
                </a>
            @else
                <a href="{{ route('login') }}" class="text-xs font-medium uppercase tracking-wider text-white border border-white px-4 py-1.5 rounded hover:bg-white hover:text-[#8F161C] transition-colors">
                    Вход
                </a>
                <a href="{{ route('register') }}" class="text-xs font-medium uppercase tracking-wider text-white border border-white px-4 py-1.5 rounded hover:bg-white hover:text-[#8F161C] transition-colors">
                    Регистрация
                </a>
            @endauth
        </div>
    </div>

    {{-- 2. NAVBAR --}}
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-3">
                    @if(file_exists(public_path('images/AV-logotip-2.svg')))
                        <img src="{{ asset('images/AV-logotip-2.svg') }}" alt="KazGASA" class="h-8 sm:h-10 w-auto" />
                    @else
                        <div class="h-10 w-10 rounded flex items-center justify-center font-bold text-white" style="background-color: #8F161C;">K</div>
                    @endif
                    <span class="font-bold text-lg sm:text-xl" style="color: #8F161C;">KazGASA Alumni</span>
                </a>

                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ url('/') }}#hero" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Главная</a>
                    <a href="{{ url('/') }}#card" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Карта выпускника</a>
                    <a href="#" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Встреча</a>
                    <a href="#" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Архив KazGASA</a>
                    @auth
                        <a href="{{ route('profile.edit') }}" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Личный кабинет</a>
                    @endauth
                    <button type="button" class="p-2 rounded-full hover:bg-[#F6F2EA] transition-colors" aria-label="Поиск">
                        <svg class="w-5 h-5" style="color: #2B2B2B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden p-2 rounded-md hover:bg-[#F6F2EA]" aria-label="Меню">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div x-show="mobileMenuOpen" x-transition class="lg:hidden border-t border-[#D9D9D9]">
                <div class="py-4 flex flex-col gap-2">
                    <a href="{{ url('/') }}#hero" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">Главная</a>
                    <a href="{{ url('/') }}#card" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">Карта выпускника</a>
                    <a href="#" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">Встреча</a>
                    <a href="#" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">Архив KazGASA</a>
                    @auth
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">Личный кабинет</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    {{-- 3. HERO — СЛЁТ ВЫПУСКНИКОВ --}}
    <section id="hero" class="relative min-h-[85vh] flex items-end lg:items-center">
        <div class="absolute inset-0">
            @if(file_exists(public_path('images/hero-bg.jpg')))
                <img src="{{ asset('images/hero-bg.jpg') }}" alt="" class="w-full h-full object-cover" />
            @else
                <div class="w-full h-full" style="background: radial-gradient(circle at 0 0, #E5C68D20, transparent 55%), linear-gradient(135deg, #1F2A44 0%, #2B2B2B 45%, #5E0F14 100%);"></div>
            @endif
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="absolute inset-0 opacity-20"
                 style="background-image: repeating-linear-gradient(45deg, rgba(229,198,141,0.3) 0, rgba(229,198,141,0.3) 1px, transparent 1px, transparent 24px);">
            </div>
        </div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 lg:pb-14 flex flex-col lg:flex-row lg:items-end gap-8">
            <div class="lg:w-[40%] lg:flex-shrink-0 lg:self-end">
                <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/90 text-xs font-semibold tracking-[0.18em] uppercase mb-4"
                     style="color: #8F161C;">
                    13 апреля · Алматы
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[44px] font-bold text-white leading-tight">
                    Слёт выпускников
                    <span class="block text-[0.9em]" style="color: #E5C68D;">KazGASA Alumni 2026</span>
                </h1>
                <p class="mt-4 text-sm sm:text-base text-white/90 max-w-md">
                    45 лет архитектурному образованию Казахстана. Встреча выпускников КазГАСА / ААСИ / КазПТИ,
                    научная программа, открытия аудиторий и нетворкинг.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-sm sm:text-base font-semibold rounded-lg transition-colors hover:opacity-95"
                       style="background-color: #8F161C; color: #FFFFFF; border: 1px solid #E5C68D;">
                        Зарегистрироваться как выпускник
                    </a>
                    <a href="#program"
                       class="inline-flex items-center justify-center px-5 py-3 text-sm font-semibold rounded-lg border transition-colors"
                       style="border-color: #E5C68D; color: #F6F2EA; background-color: transparent;">
                        Смотреть программу дня
                    </a>
                </div>
            </div>

            <div class="flex-1 flex flex-col md:flex-row lg:flex-col gap-4 lg:gap-6 lg:pl-10">
                <div class="flex-1 bg-white/95 rounded-2xl shadow-lg p-4 sm:p-5 backdrop-blur">
                    <p class="text-[11px] tracking-[0.2em] uppercase font-semibold mb-2" style="color: #8F161C;">
                        До начала слёта
                    </p>
                    <div class="grid grid-cols-4 gap-2 sm:gap-3">
                        @php
                            $eventDate = \Carbon\Carbon::create(2026, 4, 13, 9, 0, 0, 'Asia/Almaty');
                            $now = now('Asia/Almaty');
                            $diff = $eventDate->isFuture() ? $eventDate->diff($now) : null;
                        @endphp
                        @foreach([
                            ['label' => 'дней', 'value' => $diff?->d + ($diff?->m ?? 0)*30 + ($diff?->y ?? 0)*365],
                            ['label' => 'часов', 'value' => $diff?->h],
                            ['label' => 'минут', 'value' => $diff?->i],
                            ['label' => 'секунд', 'value' => $diff?->s],
                        ] as $item)
                            <div class="flex flex-col items-center justify-center rounded-xl border text-center px-1.5 py-2 sm:py-3"
                                 style="border-color: #E5C68D33; background-color: #F6F2EA;">
                                <span class="font-bold text-lg sm:text-2xl"
                                      style="color: #8F161C;">
                                    {{ str_pad(max(0, (int) ($item['value'] ?? 0)), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-[10px] uppercase tracking-wide text-[#2B2B2B]">
                                    {{ $item['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-3 text-[11px] text-[#2B2B2B]/70">
                        По данным программы «15 апреля». Время указано по Алматы.
                    </p>
                </div>

                <div class="flex-1 bg-[#F6F2EA]/95 rounded-2xl shadow-lg p-4 sm:p-5 flex gap-3">
                    <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-full flex items-center justify-center text-center text-xs font-bold"
                         style="background: radial-gradient(circle at 30% 20%, #E5C68D, #8F161C); color: #FFFFFF;">
                        Kaz<br>GASA
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em]" style="color: #8F161C;">
                            Приветствие выпускникам
                        </p>
                        <p class="text-sm font-semibold" style="color: #2B2B2B;">
                            «45 лет — это не просто юбилей. Это тысячи зданий и проектов, которые мы создали вместе.
                            Добро пожаловать домой в КазГАСА Alumni!»
                        </p>
                        <p class="text-xs text-[#2B2B2B]/70">
                            Руководство Ассоциации выпускников
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. НАВИГАЦИЯ ПО РАЗДЕЛАМ ДНЯ --}}
    <section class="border-y" style="border-color: #D9D9D9; background-color: #FFFFFF;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 overflow-x-auto">
            <div class="flex gap-3 sm:gap-4 text-xs sm:text-sm whitespace-nowrap">
                <a href="#program" class="px-3 sm:px-4 py-1.5 rounded-full font-medium border"
                   style="border-color: #8F161C; color: #8F161C; background-color: #F6F2EA;">
                    Программа
                </a>
                <a href="#card" class="px-3 sm:px-4 py-1.5 rounded-full font-medium border text-[#2B2B2B] hover:bg-[#F6F2EA]/60 transition"
                   style="border-color: #D9D9D9;">
                    Карта выпускника
                </a>
                <a href="#faces" class="px-3 sm:px-4 py-1.5 rounded-full font-medium border text-[#2B2B2B] hover:bg-[#F6F2EA]/60 transition"
                   style="border-color: #D9D9D9;">
                    Лица КазГАСА
                </a>
                <a href="#gifts" class="px-3 sm:px-4 py-1.5 rounded-full font-medium border text-[#2B2B2B] hover:bg-[#F6F2EA]/60 transition"
                   style="border-color: #D9D9D9;">
                    Вклад выпускников
                </a>
                <a href="#jobs" class="px-3 sm:px-4 py-1.5 rounded-full font-medium border text-[#2B2B2B] hover:bg-[#F6F2EA]/60 transition"
                   style="border-color: #D9D9D9;">
                    Вакансии
                </a>
                <a href="#science" class="px-3 sm:px-4 py-1.5 rounded-full font-medium border text-[#2B2B2B] hover:bg-[#F6F2EA]/60 transition"
                   style="border-color: #D9D9D9;">
                    Декада науки
                </a>
                <a href="#archive" class="px-3 sm:px-4 py-1.5 rounded-full font-medium border text-[#2B2B2B] hover:bg-[#F6F2EA]/60 transition"
                   style="border-color: #D9D9D9;">
                    Архив
                </a>
            </div>
        </div>
    </section>

    {{-- 5. ПРОГРАММА ДНЯ --}}
    <section id="program" class="py-14 px-4 sm:px-6 lg:px-8" style="background-color: #F6F2EA;">
        <div class="max-w-5xl mx-auto">
            <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                13 апреля 2026 · Алматы
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold mb-6" style="color: #2B2B2B;">
                Программа слёта выпускников
            </h2>

            <div class="space-y-3">
                @php
                    $programItems = [
                        ['time' => '09:00', 'title' => 'Регистрация участников', 'place' => 'Главный вход КазГАСА', 'state' => 'past'],
                        ['time' => '10:00', 'title' => 'Торжественное открытие', 'place' => 'Большой актовый зал', 'state' => 'past'],
                        ['time' => '12:00', 'title' => 'Декада науки. Доклады выпускников', 'place' => 'Конференц‑зал, 3 этаж', 'state' => 'current'],
                        ['time' => '14:00', 'title' => 'Открытие аудиторий выпускников', 'place' => 'Корпус 2, 2 этаж', 'state' => 'future'],
                        ['time' => '16:00', 'title' => 'Фотовыставка «Архив КазГАСА»', 'place' => 'Атриум главного корпуса', 'state' => 'future'],
                        ['time' => '19:00', 'title' => 'Торжественный банкет', 'place' => 'Ресторан «Арка»', 'state' => 'future'],
                    ];
                @endphp

                @foreach($programItems as $item)
                    @php
                        $isCurrent = $item['state'] === 'current';
                        $isPast = $item['state'] === 'past';
                    @endphp
                    <div class="flex items-start gap-3 sm:gap-4 rounded-xl px-3 sm:px-4 py-3 sm:py-3.5 border transition"
                         @class([
                            'opacity-60' => $isPast,
                         ])
                         style="
                            border-color: {{ $isCurrent ? '#E5C68D' : '#D9D9D9' }};
                            background-color: {{ $isCurrent ? '#FFFFFF' : '#FFFFFFCC' }};
                         ">
                        <div class="pt-1">
                            <span class="text-xs font-semibold tracking-wide"
                                  style="color: {{ $isCurrent ? '#8F161C' : '#2B2B2B' }};">
                                {{ $item['time'] }}
                            </span>
                        </div>
                        <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                             style="background-color: {{ $isCurrent ? '#E5C68D' : '#D9D9D9' }};"></div>
                        <div class="flex-1">
                            <p class="text-sm sm:text-base font-semibold" style="color: #2B2B2B;">
                                {{ $item['title'] }}
                            </p>
                            <p class="text-xs sm:text-sm mt-0.5" style="color: #2B2B2B99;">
                                {{ $item['place'] }}
                            </p>
                        </div>
                        @if($isCurrent)
                            <span class="mt-1 inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold uppercase tracking-wide"
                                  style="background-color: #E5C68D33; color: #8F161C;">
                                Сейчас
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="{{ asset('mockups/program.pdf') }}" target="_blank"
                   class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border text-sm font-semibold gap-2"
                   style="border-color: #D9D9D9; color: #2B2B2B; background-color: #FFFFFF;">
                    <span>📄</span>
                    <span>Программа в PDF</span>
                </a>
                <a href="#archive"
                   class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border text-sm font-semibold gap-2"
                   style="border-color: #D9D9D9; color: #2B2B2B; background-color: #FFFFFF;">
                    <span>🗺️</span>
                    <span>Карта кампуса и архив</span>
                </a>
            </div>
        </div>
    </section>

    {{-- 6. ЦИФРОВАЯ КАРТА ВЫПУСКНИКА --}}
    <section id="card" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-10 lg:gap-14 items-center">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                    Скидки и привилегии
                </p>
                <h2 class="text-2xl sm:text-3xl font-bold" style="color: #2B2B2B;">
                    Цифровая карта выпускника
                </h2>
                <p class="mt-4 text-sm sm:text-base leading-relaxed" style="color: #2B2B2B;">
                    Персональная карта выпускника KazGASA Alumni с QR‑кодом — подтверждение вашего статуса и доступ
                    к партнёрским льготам. Карта формируется автоматически после регистрации и верификации профиля.
                </p>
                <ul class="mt-4 space-y-2 text-sm" style="color: #2B2B2B;">
                    <li class="flex gap-2"><span>•</span><span>Привязана к вашему профилю выпускника и IIN.</span></li>
                    <li class="flex gap-2"><span>•</span><span>Показывайте на экране телефона — партнёры сканируют QR.</span></li>
                    <li class="flex gap-2"><span>•</span><span>Статусы Connect / Start / Core / Elite в зависимости от участия.</span></li>
                </ul>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold rounded-lg transition-colors hover:opacity-95"
                       style="background-color: #8F161C; color: #FFFFFF;">
                        Получить карту выпускника
                    </a>
                    @auth
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center justify-center px-5 py-3 text-sm font-semibold rounded-lg border transition-colors"
                           style="border-color: #D9D9D9; color: #2B2B2B;">
                            Открыть мой профиль
                        </a>
                    @endauth
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-center lg:justify-end">
                    @if(file_exists(public_path('images/alumni-card-fon.png')))
                        <div class="w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden aspect-[1.6]"
                             style="background-image: url('{{ asset('images/alumni-card-fon.png') }}'); background-size: 100% 100%; background-repeat: no-repeat;">
                        </div>
                    @else
                        <div class="w-full max-w-sm rounded-2xl shadow-2xl aspect-[1.6] flex items-center justify-center text-[#8F161C] font-semibold"
                             style="background-color: #F6F2EA;">
                            Цифровая карта выпускника
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-3 gap-3 text-xs">
                    <div class="rounded-xl px-3 py-2.5 border" style="border-color: #D9D9D9; background-color: #F6F2EA;">
                        <p class="font-semibold" style="color: #8F161C;">12</p>
                        <p class="text-[11px]" style="color: #2B2B2B;">аудиторий от выпускников</p>
                    </div>
                    <div class="rounded-xl px-3 py-2.5 border" style="border-color: #D9D9D9; background-color: #F6F2EA;">
                        <p class="font-semibold" style="color: #8F161C;">₸84M</p>
                        <p class="text-[11px]" style="color: #2B2B2B;">пожертвований</p>
                    </div>
                    <div class="rounded-xl px-3 py-2.5 border" style="border-color: #D9D9D9; background-color: #F6F2EA;">
                        <p class="font-semibold" style="color: #8F161C;">50+</p>
                        <p class="text-[11px]" style="color: #2B2B2B;">партнёров</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 7. ЛИЦА КАЗГАСА --}}
    <section id="faces" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: #F6F2EA;">
        <div class="max-w-7xl mx-auto">
            <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                Гордость университета
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold mb-6" style="color: #2B2B2B;">
                Лица KazGASA Alumni
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                @foreach([
                    ['initials' => 'АД', 'name' => 'Асель Досымова', 'role' => 'Главный архитектор Алматы', 'year' => 'Выпуск 1998'],
                    ['initials' => 'КМ', 'name' => 'Кайрат Мухамеджанов', 'role' => 'CEO строительного холдинга', 'year' => 'Выпуск 2001'],
                    ['initials' => 'НС', 'name' => 'Нуржан Сейткали', 'role' => 'Лауреат международных премий', 'year' => 'Выпуск 1995'],
                    ['initials' => 'ДА', 'name' => 'Диана Ахметова', 'role' => 'Профессор, ректор МОК', 'year' => 'Выпуск 1987'],
                ] as $alum)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border" style="border-color: #D9D9D9;">
                        <div class="h-24 sm:h-28 flex items-center justify-center text-2xl sm:text-3xl font-bold"
                             style="background: radial-gradient(circle at 0 0, #E5C68D33, transparent 55%), linear-gradient(135deg, #1F2A44, #5E0F14); color: #E5C68D;">
                            {{ $alum['initials'] }}
                        </div>
                        <div class="px-3 sm:px-4 py-3">
                            <p class="text-sm font-semibold" style="color: #2B2B2B;">
                                {{ $alum['name'] }}
                            </p>
                            <p class="mt-0.5 text-xs" style="color: #2B2B2B99;">
                                {{ $alum['role'] }}
                            </p>
                            <p class="mt-1 text-[11px] font-semibold" style="color: #8F161C;">
                                {{ $alum['year'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 8. ВКЛАД ВЫПУСКНИКОВ / ПОДАРКИ --}}
    <section id="gifts" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: #FFFFFF;">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-10 lg:gap-14 items-start">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                    Вклад выпускников
                </p>
                <h2 class="text-2xl sm:text-3xl font-bold mb-6" style="color: #2B2B2B;">
                    Что мы дали университету
                </h2>
                <div class="grid grid-cols-3 gap-3 mb-6 text-center">
                    <div class="rounded-2xl px-3 py-4" style="background-color: #F6F2EA;">
                        <p class="text-2xl font-bold" style="color: #8F161C;">12</p>
                        <p class="mt-1 text-xs" style="color: #2B2B2B;">аудиторий открыто</p>
                    </div>
                    <div class="rounded-2xl px-3 py-4" style="background-color: #F6F2EA;">
                        <p class="text-2xl font-bold" style="color: #8F161C;">₸84M</p>
                        <p class="mt-1 text-xs" style="color: #2B2B2B;">пожертвований</p>
                    </div>
                    <div class="rounded-2xl px-3 py-4" style="background-color: #F6F2EA;">
                        <p class="text-2xl font-bold" style="color: #8F161C;">6</p>
                        <p class="mt-1 text-xs" style="color: #2B2B2B;">лабораторий</p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed" style="color: #2B2B2B;">
                    Слёт выпускников — это не только встреча друзей, но и возможность поддержать новые поколения
                    студентов. Оборудованные аудитории, современные лаборатории, стипендии и научные фонды —
                    всё это результат совместной работы выпускников KazGASA Alumni.
                </p>
            </div>

            <div class="space-y-4">
                <div class="bg-[#F6F2EA] rounded-2xl border shadow-sm overflow-hidden" style="border-color: #D9D9D9;">
                    <div class="h-28 sm:h-32 flex items-center justify-center text-3xl sm:text-4xl">
                        🏛️
                    </div>
                    <div class="px-4 sm:px-5 py-4">
                        <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color: #8F161C;">
                            Выпуск 1995 · Архитектурный факультет
                        </p>
                        <p class="text-sm font-semibold" style="color: #2B2B2B;">
                            Аудитория «Архитектурное наследие»
                        </p>
                        <p class="mt-1 text-sm" style="color: #2B2B2B99;">
                            Полностью обновлённое пространство с мультимедиа‑оборудованием, библиотекой и зонами для проектной работы.
                        </p>
                    </div>
                </div>
                <div class="bg-[#F6F2EA] rounded-2xl border shadow-sm overflow-hidden" style="border-color: #D9D9D9;">
                    <div class="h-28 sm:h-32 flex items-center justify-center text-3xl sm:text-4xl">
                        💻
                    </div>
                    <div class="px-4 sm:px-5 py-4">
                        <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color: #8F161C;">
                            Выпуск 2003 · Строительный факультет
                        </p>
                        <p class="text-sm font-semibold" style="color: #2B2B2B;">
                            Компьютерная лаборатория BIM
                        </p>
                        <p class="mt-1 text-sm" style="color: #2B2B2B99;">
                            30 рабочих мест с современным программным обеспечением для архитектурного и инженерного моделирования.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 9. ВАКАНСИИ ДЛЯ ВЫПУСКНИКОВ --}}
    @php
        $latestJobs = app(\App\Services\JobService::class)->getActiveJobs(3);
    @endphp
    <section id="jobs" class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-1">
                            Карьера
                        </p>
                        <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl">
                            Вакансии для выпускников
                        </h2>
                    </div>
                    @auth
                        <a href="{{ route('jobs.index') }}"
                           class="hidden sm:block text-[#8F161C] text-sm font-semibold hover:text-[#5E0F14] hover:underline transition">
                            Все вакансии →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden sm:block text-[#8F161C] text-sm font-semibold hover:text-[#5E0F14] hover:underline transition">
                            Все вакансии →
                        </a>
                    @endauth
                </div>

                @if($latestJobs->isEmpty())
                    <div class="border border-dashed border-[#D9D9D9] rounded-2xl p-8 text-center text-sm text-gray-500">
                        Вакансий пока нет. Загляните позже.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($latestJobs as $job)
                            <div class="border border-[#D9D9D9] rounded-2xl p-5 hover:border-[#8F161C] hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center gap-3 mb-3">
                                    @if($job->company_logo_path)
                                        <img src="{{ $job->company_logo_path }}"
                                             class="w-10 h-10 rounded-lg object-contain border border-[#D9D9D9] p-1"
                                             alt="{{ $job->company_name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-[#F6F2EA] flex items-center justify-center border border-[#D9D9D9]">
                                            <span class="text-[#8F161C] font-bold">
                                                {{ mb_substr($job->company_name ?? 'K', 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                    <p class="text-sm font-medium text-[#2B2B2B] truncate">
                                        {{ $job->company_name }}
                                    </p>
                                </div>

                                <h3 class="font-bold text-[#2B2B2B] text-sm leading-snug mb-2 line-clamp-2 group-hover:text-[#8F161C] transition-colors">
                                    {{ $job->position_name }}
                                </h3>

                                @if($job->salary)
                                    <p class="text-[#8F161C] text-xs font-semibold mb-3">
                                        {{ $job->salary }}
                                    </p>
                                @endif

                                <a href="{{ route('jobs.show', $job->id) }}"
                                   class="block w-full text-center bg-[#8F161C] text-white py-2 rounded-lg text-xs font-semibold uppercase tracking-wide hover:bg-[#5E0F14] transition-colors mt-3">
                                    Подробнее →
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="sm:hidden text-center mt-6">
                        @auth
                            <a href="{{ route('jobs.index') }}"
                               class="inline-block border-2 border-[#8F161C] text-[#8F161C] px-8 py-3 rounded-xl font-semibold text-sm hover:bg-[#8F161C] hover:text-white transition-colors">
                                Смотреть все вакансии
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-block border-2 border-[#8F161C] text-[#8F161C] px-8 py-3 rounded-xl font-semibold text-sm hover:bg-[#8F161C] hover:text-white transition-colors">
                                Смотреть все вакансии
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </section>

    {{-- 6. FOOTER --}}
    <footer class="mt-auto">
        <div class="py-12 px-4 sm:px-6 lg:px-8" style="background-color: #2B2B2B;">
            <div class="max-w-7xl mx-auto">
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div>
                        <a href="{{ url('/') }}" class="flex items-center gap-2">
                            @if(file_exists(public_path('images/AV-logotip-2.svg')))
                                <img src="{{ asset('images/AV-logotip-2.svg') }}" alt="KazGASA" class="h-8 w-auto brightness-0 invert opacity-90" />
                            @endif
                            <span class="font-bold text-white">KazGASA Alumni</span>
                        </a>
                        <p class="mt-2 text-sm text-white/80">Сообщество выпускников КазГАСА</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">Навигация</h3>
                        <ul class="mt-3 space-y-2">
                            <li><a href="{{ url('/') }}#hero" class="text-sm text-white/80 hover:text-white">Главная</a></li>
                            <li><a href="{{ url('/') }}#card" class="text-sm text-white/80 hover:text-white">Карта выпускника</a></li>
                            <li><a href="{{ route('login') }}" class="text-sm text-white/80 hover:text-white">Вход</a></li>
                            <li><a href="{{ route('register') }}" class="text-sm text-white/80 hover:text-white">Регистрация</a></li>
                        </ul>
                    </div>
                    <div class="sm:col-span-2">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">Контакты</h3>
                        <p class="mt-3 text-sm text-white/80">Международная Образовательная Корпорация</p>
                        <p class="mt-1 text-sm text-white/80">г. Алматы, Казахстан</p>
                        <div class="mt-4 flex items-center gap-4">
                            <a href="https://www.instagram.com/kazgasa_alumni?igsh=MWlyc3o5OGN2eHZ4MA==" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white">
                                <span class="text-xl">📷</span>
                                <span>Instagram</span>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61582749477218" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white">
                                <span class="text-xl">📘</span>
                                <span>Facebook</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-white/80" style="background-color: #5E0F14;">
            © {{ date('Y') }} KazGASA Alumni. Все права защищены.
        </div>
    </footer>
</div>
@endsection
