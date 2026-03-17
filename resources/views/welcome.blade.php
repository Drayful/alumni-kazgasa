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

    {{-- 3. HERO + ОБРАТНЫЙ ОТСЧЁТ --}}
    <section id="hero" class="relative min-h-[90vh] flex items-end lg:items-center">
        <div class="absolute inset-0">
            @if(file_exists(public_path('images/hero-bg.jpg')))
                <img src="{{ asset('images/hero-bg.jpg') }}" alt="" class="w-full h-full object-cover" />
            @else
                <div class="w-full h-full" style="background: linear-gradient(135deg, #1F2A44 0%, #2B2B2B 50%, #5E0F14 100%);"></div>
            @endif
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 lg:pb-12 flex flex-col lg:flex-row lg:items-end gap-8">
            <div class="hidden lg:block lg:w-[35%] lg:flex-shrink-0 lg:self-end">
                @if(file_exists(public_path('images/hero-photo.jpg')))
                    <img src="{{ asset('images/hero-photo.jpg') }}" alt="" class="w-full max-w-sm object-cover object-bottom rounded-t-lg shadow-2xl" style="max-height: 70vh;" />
                @else
                    <div class="w-full max-w-sm h-96 rounded-t-lg shadow-2xl flex items-center justify-center text-white/60 bg-[#2B2B2B]/80">
                        <span>Портрет</span>
                    </div>
                @endif
            </div>

            <div class="flex-1 flex flex-col justify-center lg:pl-12 space-y-6">
                <div>
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/80 text-xs sm:text-sm font-medium mb-3" style="color: #8F161C;">
                        15 апреля · Слёт выпускников KazGASA Alumni
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight max-w-2xl">
                        Дорогие выпускники КазГАСА / ААСИ / КазПТИ
                    </h1>
                    <p class="mt-3 text-base sm:text-lg text-white/95 max-w-lg">
                        45‑летие архитектурного образования Казахстана: встреча поколений, авторские экскурсии,
                        концертная программа и праздничный салют на кампусе КазГАСА.
                    </p>
                </div>

                {{-- Обратный отсчёт до 15 апреля 2026 --}}
                <div class="inline-block bg-white/90 rounded-2xl px-4 py-3 sm:px-5 sm:py-4 shadow-lg">
                    <p class="text-[11px] sm:text-xs font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                        До начала слёта
                    </p>
                    <div class="grid grid-cols-4 gap-2 sm:gap-3" data-countdown-root>
                        @foreach(['дней','часов','минут','секунд'] as $label)
                            <div class="flex flex-col items-center justify-center rounded-xl border px-2 py-2 sm:py-3"
                                 style="border-color: #E5C68D33; background-color: #F6F2EA;">
                                <span class="font-bold text-lg sm:text-2xl text-[#8F161C]" data-countdown-value>00</span>
                                <span class="text-[10px] uppercase tracking-wide text-[#2B2B2B]">
                                    {{ $label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-2 text-[11px] text-[#F97316]">
                        Событие состоится 15 апреля 2026 года на кампусе КазГАСА.
                    </p>
                </div>

                <div class="mt-2 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium rounded-lg transition-colors hover:opacity-90"
                       style="background-color: #8F161C; color: #FFFFFF; border: 1px solid #E5C68D;">
                        Зарегистрироваться как выпускник
                    </a>
                    <a href="#program" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium rounded-lg border transition-colors hover:bg-white/10"
                       style="border-color: #E5C68D; color: #F6F2EA;">
                        Смотреть программу дня
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. STATS --}}
    <section class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: #F6F2EA;">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">30000+</div>
                    <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">Выпускников</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">45+</div>
                    <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">Лет истории</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">50+</div>
                    <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">Партнёров</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">100+</div>
                    <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">Мероприятий</div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. ПРОГРАММА 15 АПРЕЛЯ — СЛЁТ ВЫПУСКНИКОВ --}}
    <section id="program" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-5xl mx-auto">
            <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                15 апреля 2026 · Слёт выпускников
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold mb-6" style="color: #2B2B2B;">
                Программа вечера
            </h2>

            @php
                $eventDate = '2026-04-15';
                $slots = [
                    [
                        'time' => '15:00 – 15:30',
                        'start' => '15:00',
                        'end' => '15:30',
                        'title' => 'Регистрация участников',
                        'details' => 'Встреча и регистрация выпускников у входа на территорию КазГАСА.',
                    ],
                    [
                        'time' => '15:30 – 16:30',
                        'start' => '15:30',
                        'end' => '16:30',
                        'title' => 'Торжественное открытие мероприятия',
                        'details' => "Показ фильма «КазГАСА: 45 лет в кадре», приветственные слова руководства,\nпрезентация цифровой Платформы выпускников, выступления и подарки от выпускников.",
                    ],
                    [
                        'time' => '16:30 – 17:20',
                        'start' => '16:30',
                        'end' => '17:20',
                        'title' => 'Авторские экскурсии по школам',
                        'details' => 'Экскурсии по факультетам и обновлённым пространствам КазГАСА от преподавателей и выпускников.',
                    ],
                    [
                        'time' => '17:20 – 18:00',
                        'start' => '17:20',
                        'end' => '18:00',
                        'title' => 'Фуршет и концертная программа',
                        'details' => 'Фуршет и живая музыка в праздничном шатре на территории кампуса.',
                    ],
                    [
                        'time' => '18:00 – 18:30',
                        'start' => '18:00',
                        'end' => '18:30',
                        'title' => 'Финальный блок: общее караоке',
                        'details' => 'Совместное исполнение любимых песен выпускников и студентов.',
                    ],
                    [
                        'time' => '18:30',
                        'start' => '18:30',
                        'end' => '18:35',
                        'title' => 'Праздничный салют',
                        'details' => 'Салют в честь 45‑летия архитектурного образования Казахстана.',
                    ],
                    [
                        'time' => '18:40 – 19:00',
                        'start' => '18:40',
                        'end' => '19:00',
                        'title' => 'Завершение вечера',
                        'details' => 'Прощание, обмен контактами и планы на новые встречи KazGASA Alumni.',
                    ],
                ];
            @endphp

            <div class="space-y-3" id="program-timeline">
                @foreach($slots as $index => $slot)
                    <div class="flex items-start gap-3 sm:gap-4 rounded-2xl border px-3 sm:px-4 py-3 sm:py-3.5 bg-[#FDFBF7]"
                         data-slot
                         data-slot-start="{{ $eventDate }}T{{ $slot['start'] }}:00+06:00"
                         data-slot-end="{{ $eventDate }}T{{ $slot['end'] }}:00+06:00"
                         style="border-color: #D9D9D9;">
                        <div class="pt-1">
                            <span class="text-xs sm:text-sm font-semibold tracking-wide text-[#2B2B2B]">
                                {{ $slot['time'] }}
                            </span>
                        </div>
                        <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 bg-[#D9D9D9]" data-slot-dot></div>
                        <div class="flex-1">
                            <p class="text-sm sm:text-base font-semibold" style="color: #2B2B2B;">
                                {{ $slot['title'] }}
                            </p>
                            <p class="mt-1 text-xs sm:text-sm whitespace-pre-line" style="color: #2B2B2B99;">
                                {!! nl2br(e($slot['details'])) !!}
                            </p>
                        </div>
                        <span class="hidden text-[10px] font-semibold uppercase tracking-wide px-2 py-1 rounded-full"
                              data-slot-badge
                              style="background-color: #E5C68D33; color: #8F161C;">
                            Сейчас
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 6. КАРТА ВЫПУСКНИКА --}}
    <section id="card" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold" style="color: #8F161C;">Цифровая карта выпускника</h2>
                    <p class="mt-4 text-base leading-relaxed" style="color: #2B2B2B;">
                        Получите персональную цифровую карту выпускника КазГАСА — подтверждение вашего статуса и связь с альма-матер. Карта с QR-кодом доступна после регистрации в личном кабинете.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center mt-6 px-6 py-3 text-base font-medium text-white rounded transition-colors hover:opacity-90" style="background-color: #8F161C;">
                        Получить карту
                    </a>
                </div>
                <div class="flex justify-center lg:justify-end">
                    @if(file_exists(public_path('images/alumni-card-fon.png')))
                        <div class="w-full max-w-sm rounded-xl shadow-xl overflow-hidden aspect-[1.6]" style="background-image: url('{{ asset('images/alumni-card-fon.png') }}'); background-size: 100% 100%; background-repeat: no-repeat;"></div>
                    @else
                        <div class="w-full max-w-sm rounded-xl shadow-xl aspect-[1.6] flex items-center justify-center text-[#8F161C] font-semibold" style="background-color: #F6F2EA;">Карта выпускника</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- 5.5. ВАКАНСИИ ДЛЯ ВЫПУСКНИКОВ --}}
    @php
        $latestJobs = app(\App\Services\JobService::class)->getActiveJobs(3);
    @endphp
    <section class="bg-white py-16">
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

    {{-- 6. ДЕКАДА НАУКИ --}}
    <section id="science" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: #F6F2EA;">
        <div class="max-w-5xl mx-auto">
            <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                13 апреля 2026
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold mb-4" style="color: #2B2B2B;">
                Декада науки
            </h2>
            <p class="text-sm sm:text-base leading-relaxed mb-6" style="color: #2B2B2B;">
                Научно‑практическая программа с участием выпускников и преподавателей КазГАСА: актуальные
                исследования в области архитектуры, урбанистики и строительства.
            </p>

            <div class="space-y-3">
                <div class="flex items-start gap-3 rounded-2xl border bg-white px-4 py-3 sm:py-4"
                     style="border-color: #D9D9D9;">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-lg"
                         style="background-color: #F6F2EA; color: #8F161C;">
                        📄
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold" style="color: #2B2B2B;">
                            Устойчивая архитектура в аридном климате
                        </p>
                        <p class="text-xs mt-0.5" style="color: #2B2B2B99;">
                            Доклад выпускников кафедры архитектуры · 2026
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-2xl border bg-white px-4 py-3 sm:py-4"
                     style="border-color: #D9D9D9;">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-lg"
                         style="background-color: #F6F2EA; color: #8F161C;">
                        📄
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold" style="color: #2B2B2B;">
                            BIM‑технологии в реконструкции исторической застройки
                        </p>
                        <p class="text-xs mt-0.5" style="color: #2B2B2B99;">
                            Исследование выпускников строительного факультета
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-2xl border bg-white px-4 py-3 sm:py-4"
                     style="border-color: #D9D9D9;">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-lg"
                         style="background-color: #F6F2EA; color: #8F161C;">
                        📄
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold" style="color: #2B2B2B;">
                            Алматы 2050: сценарии устойчивого развития города
                        </p>
                        <p class="text-xs mt-0.5" style="color: #2B2B2B99;">
                            Совместный проект выпускников и студентов
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 7. АРХИВ KAZGASA --}}
    <section id="archive" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-5xl mx-auto">
            <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                История в фотографиях
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold mb-4" style="color: #2B2B2B;">
                Архив KazGASA Alumni
            </h2>
            <p class="text-sm sm:text-base leading-relaxed mb-5" style="color: #2B2B2B;">
                Фотографии кампуса, выпусков и знаковых событий разных десятилетий. Вы можете прислать свои
                снимки и пополнить архив.
            </p>

            <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-2">
                @foreach(['80‑е', '90‑е', '00‑е', '10‑е', '20‑е'] as $idx => $label)
                    <button type="button"
                            class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold border whitespace-nowrap
                                   {{ $idx === 1 ? 'bg-[#8F161C] text-white border-[#8F161C]' : 'bg-white text-[#2B2B2B] border-[#D9D9D9]' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="mt-4 grid grid-cols-3 gap-2 sm:gap-3">
                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                     style="background: linear-gradient(135deg, #1F2A44, #5E0F14);">
                    🏛️
                </div>
                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                     style="background: linear-gradient(135deg, #8F161C, #E5C68D);">
                    🎓
                </div>
                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                     style="background: linear-gradient(135deg, #2B2B2B, #8F161C);">
                    📐
                </div>
                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                     style="background: linear-gradient(135deg, #E5C68D, #5E0F14);">
                    🏗️
                </div>
                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                     style="background: linear-gradient(135deg, #1F2A44, #E5C68D);">
                    🎨
                </div>
                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                     style="background: linear-gradient(135deg, #5E0F14, #2B2B2B);">
                    🏙️
                </div>
            </div>

            <div class="mt-5">
                <button type="button"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border-2 text-sm font-semibold"
                        style="border-color: #D9D9D9; color: #2B2B2B; background-color: #F6F2EA;">
                    <span>📷</span>
                    <span>Загрузить своё фото в архив</span>
                </button>
            </div>
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
                            <a href="https://www.instagram.com/kazgasa_alumni?igsh=MWlyc3o5OGN2eHZ4MA=="
                               target="_blank" rel="noopener"
                               class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white">
                                <img src="{{ asset('images/instagram.png') }}" class="w-8 h-8">
                            </a>

                            <a href="https://www.facebook.com/profile.php?id=61582749477218" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white">
                                <img src="{{ asset('images/facebook.png') }}" class="w-8 h-8">
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

@push('scripts')
    <script>
        (function () {
            // Обратный отсчёт до 15 апреля 2026 (Алматы, GMT+6)
            const target = new Date('2026-04-15T00:00:00+06:00').getTime();
            const root = document.querySelector('[data-countdown-root]');
            const values = root ? root.querySelectorAll('[data-countdown-value]') : null;

            function updateCountdown() {
                if (!values || values.length !== 4) return;
                const now = Date.now();
                let diff = target - now;
                if (diff <= 0) {
                    ['00', '00', '00', '00'].forEach((val, i) => values[i].textContent = val);
                    return;
                }
                const day = 1000 * 60 * 60 * 24;
                const hour = 1000 * 60 * 60;
                const minute = 1000 * 60;

                const days = Math.floor(diff / day);
                diff -= days * day;
                const hours = Math.floor(diff / hour);
                diff -= hours * hour;
                const minutes = Math.floor(diff / minute);
                diff -= minutes * minute;
                const seconds = Math.floor(diff / 1000);

                const nums = [days, hours, minutes, seconds].map(n => String(n).padStart(2, '0'));
                nums.forEach((val, i) => values[i].textContent = val);
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);

            // Подсветка текущего слота программы 15 апреля 2026
            const slotNodes = document.querySelectorAll('#program-timeline [data-slot]');
            function updateCurrentSlot() {
                const now = new Date();
                slotNodes.forEach(node => {
                    node.classList.remove('ring-2', 'ring-offset-2');
                    node.style.borderColor = '#D9D9D9';
                    const dot = node.querySelector('[data-slot-dot]');
                    const badge = node.querySelector('[data-slot-badge]');
                    if (dot) dot.style.backgroundColor = '#D9D9D9';
                    if (badge) badge.style.display = 'none';
                });

                const today = new Date('2026-04-15T00:00:00+06:00');
                if (now.toDateString() !== today.toDateString()) {
                    return;
                }

                slotNodes.forEach(node => {
                    const startStr = node.getAttribute('data-slot-start');
                    const endStr = node.getAttribute('data-slot-end');
                    if (!startStr || !endStr) return;
                    const start = new Date(startStr);
                    const end = new Date(endStr);
                    if (now >= start && now <= end) {
                        node.classList.add('ring-2', 'ring-offset-2');
                        node.style.borderColor = '#E5C68D';
                        const dot = node.querySelector('[data-slot-dot]');
                        const badge = node.querySelector('[data-slot-badge]');
                        if (dot) dot.style.backgroundColor = '#E5C68D';
                        if (badge) badge.style.display = 'inline-flex';
                    }
                });
            }

            updateCurrentSlot();
            setInterval(updateCurrentSlot, 60 * 1000);
        })();
    </script>
@endpush
