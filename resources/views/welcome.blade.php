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
                        <a href="{{ url('/') }}#alumni-card" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Карта выпускника</a>
                        <a href="{{ route('contributions.index') }}" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Вклад выпускников</a>
                        <a href="#" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Встреча</a>
                        <a href="https://museum.kazgasa.kz/" target="_blank" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Архив KazGASA</a>
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
                        <a href="{{ url('/') }}#alumni-card" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">Карта выпускника</a>
                        <a href="{{ route('contributions.index') }}" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">Вклад выпускников</a>
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

            <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 lg:pb-12 flex flex-col gap-8">
                <div class="flex flex-col justify-center space-y-6">

                    {{-- HERO TEXT --}}
                    <div>
{{--                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight max-w-none">--}}
{{--                            Слёт выпускников КазГАСА--}}
{{--                        </h1>--}}
                        <p class="mt-3 text-base sm:text-lg text-white/95 max-w-none">
                            45 лет архитектурному образованию Казахстана — встреча всех поколений.
                        </p>
                        <p class="mt-4 text-base sm:text-lg text-white/95 max-w-none">
                            Один день — тысячи историй. Приходи встретить своих однокурсников,
                            увидеть изменения в родных стенах и стать частью истории КазГАСА.
                        </p>
                    </div>

                    {{-- ФОТО + ЦИТАТА ПРЕДСЕДАТЕЛЯ --}}
                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        {{-- СЛЕВА: Фото --}}
                        <div class="relative flex-shrink-0">
                            <div class="absolute -inset-2 rounded-2xl bg-[#8F161C]/20"></div>
                            <img src="{{ asset('images/kusainov.jpg') }}"
                                 onerror="this.src='{{ asset('images/hero-photo.jpg') }}'"
                                 alt="Кусаинов Айгазы Амирланович"
                                 class="relative w-72 h-80 object-cover object-top rounded-2xl shadow-2xl">
                            <div class="absolute -bottom-1 -left-1 -right-1 h-1 bg-[#E5C68D] rounded-b-2xl"></div>
                        </div>

                        {{-- СПРАВА: Цитата --}}
                        <div class="flex flex-col justify-center items-center text-center md:items-start md:text-left">
                            {{-- Большие кавычки --}}
                            <span class="text-[#E5C68D] font-serif leading-none mb-4 text-[60px] md:text-[80px]" style="line-height: 0.8">❝</span>

                            {{-- Текст цитаты --}}
                            <blockquote class="text-white text-lg md:text-xl italic leading-relaxed font-light">
                                КазГАСА — это не просто университет. Это место, где рождается
                                архитектурная душа Казахстана. 45 лет назад здесь начались судьбы
                                тысяч людей, которые сегодня строят нашу страну. Добро пожаловать домой.
                            </blockquote>

                            {{-- Разделитель --}}
                            <div class="w-12 h-0.5 bg-[#E5C68D] my-4"></div>

                            {{-- Имя и должность --}}
                            <div>
                                <p class="text-[#E5C68D] font-bold text-base">
                                    Кусаинов Айгазы Амирланович
                                </p>
                                <p class="text-white/60 text-sm mt-1 leading-snug">
                                    Председатель Наблюдательного совета IEC,<br>
                                    Председатель Правления Международной образовательной
                                    корпорации,<br>владелец группы компаний Verum
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ДАТА + ТАЙМЕР (обратный отсчёт до 15 апреля) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-[#8F161C]">
                            <p class="text-xs text-[#8F161C] uppercase tracking-wide font-medium">📅 Дата</p>
                            <p class="text-[#2B2B2B] font-bold text-sm mt-1">15 апреля 2026 года</p>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-[#8F161C] sm:col-span-2">
                            <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-3" style="color: #8F161C;">
                                До слёта
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
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="flex flex-col md:flex-row gap-4 w-full items-stretch md:items-start justify-center md:justify-start">
                        <a href="#program"
                           class="w-full md:w-auto bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl font-semibold transition shadow-lg shadow-[#8F161C]/30 text-sm sm:text-base text-center">
                            Программа слёта
                        </a>
                        <a href="#alumni-card"
                           class="w-full md:w-auto border-2 border-white/40 text-white hover:border-white hover:bg-white/10 px-8 py-3 rounded-xl font-semibold transition text-sm sm:text-base text-center">
                            Карта выпускника
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
            @php
                $schedule = [
                    ['time' => '15:00', 'start' => '15:00', 'end' => '15:30', 'title' => 'Регистрация участников', 'place' => 'Главный вход КазГАСА'],
                    ['time' => '15:30', 'start' => '15:30', 'end' => '16:30', 'title' => 'Торжественное открытие', 'place' => 'Территория КазГАСА'],
                    ['time' => '15:30', 'start' => '15:30', 'end' => '16:30', 'title' => 'Приветственные слова руководства', 'place' => 'Территория КазГАСА'],
                    ['time' => '15:30', 'start' => '15:30', 'end' => '16:30', 'title' => 'Презентация цифровой платформы', 'place' => 'Территория КазГАСА'],
                    ['time' => '15:30', 'start' => '15:30', 'end' => '16:30', 'title' => 'Выступления и подарки от выпускников', 'place' => 'Территория КазГАСА'],
                    ['time' => '16:30', 'start' => '16:30', 'end' => '18:00', 'title' => 'Экскурсии по факультетам', 'place' => 'Корпуса КазГАСА'],
                    ['time' => '18:00', 'start' => '18:00', 'end' => '19:00', 'title' => 'Фуршет и концертная программа', 'place' => 'Территория КазГАСА'],
                    ['time' => '19:00', 'start' => '19:00', 'end' => '19:30', 'title' => 'Завершение вечера', 'place' => 'Территория КазГАСА'],
                ];
            @endphp

            <div class="max-w-5xl mx-auto">
                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                    15 апреля 2026
                </p>
                <h2 class="text-2xl sm:text-3xl font-bold mb-2" style="color: #2B2B2B;">
                    Программа встречи выпускников
                </h2>
                <p class="text-sm text-gray-500 mb-8">
                    Текущее событие подсвечивается автоматически по времени
                </p>

                <div x-data="{
                    now: new Date(),
                    isActive(start, end) {
                        const today = this.now.toISOString().slice(0, 10);
                        const eventDate = '2026-04-15';
                        if (today !== eventDate) return false;
                        const cur = this.now.getHours() * 60 + this.now.getMinutes();
                        const [sh, sm] = start.split(':').map(Number);
                        const [eh, em] = end.split(':').map(Number);
                        return cur >= (sh * 60 + sm) && cur < (eh * 60 + em);
                    }
                }"
                     x-init="setInterval(() => { now = new Date() }, 30000)"
                     class="relative border-l-2 border-[#E5C68D] ml-2 sm:ml-6">

                    <div id="program-timeline">
                        @foreach($schedule as $item)
                            <div class="relative pl-8 pb-8">
                            <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full
                                         bg-[#8F161C] border-2 border-[#E5C68D]"
                                  :class="isActive('{{ $item['start'] }}','{{ $item['end'] }}') ? 'ring-4 ring-[#8F161C]/30' : ''">
                            </span>

                                <div class="mt-0"
                                     :class="isActive('{{ $item['start'] }}','{{ $item['end'] }}') ?
                                    'bg-[#8F161C] text-white rounded-xl p-4 shadow-lg' :
                                    'bg-white rounded-xl p-4 shadow-sm'">
                                    <div class="flex items-baseline justify-between gap-4">
                                    <span class="text-[#E5C68D] font-bold text-sm"
                                          :class="isActive('{{ $item['start'] }}','{{ $item['end'] }}') ? 'text-white/80' : 'text-[#E5C68D]'">
                                        {{ $item['time'] }}
                                    </span>
                                    </div>
                                    <div class="font-semibold"
                                         :class="isActive('{{ $item['start'] }}','{{ $item['end'] }}') ? 'text-white' : 'text-[#2B2B2B]'">
                                        {{ $item['title'] }}
                                    </div>
                                    <div class="text-sm"
                                         :class="isActive('{{ $item['start'] }}','{{ $item['end'] }}') ? 'text-white/70' : 'text-gray-500'">
                                        {{ $item['place'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ asset('files/program.pdf') }}"
                       download
                       class="inline-flex items-center justify-center bg-[#8F161C] hover:bg-[#5E0F14] text-white px-6 py-2.5 rounded-xl text-sm font-medium transition">
                        📄 Скачать программу (PDF)
                    </a>
                    <a href="#"
                       class="inline-flex items-center justify-center border border-[#8F161C] text-[#8F161C] hover:bg-[#8F161C] hover:text-white px-6 py-2.5 rounded-xl text-sm font-medium transition">
                        🗺 Карта кампуса
                    </a>
                </div>
            </div>
        </section>

        {{-- 6. КАРТА ВЫПУСКНИКА --}}
        <section id="alumni-card" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            @php
                $alumniProfile = auth()->check() ? auth()->user()->alumniProfile : null;
                $publicId = $alumniProfile?->public_id;
            @endphp

            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    {{-- Визуальная карточка (слева) --}}
                    <div class="flex justify-center lg:justify-start">
                        <div class="w-full max-w-sm">
                            <x-alumni-card :alumni-profile="$alumniProfile" />
                        </div>
                    </div>

                    {{-- Текст + кнопки --}}
                    <div>
                        <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-3">Скидки и привилегии</p>
                        <h2 class="text-2xl sm:text-3xl font-bold" style="color: #2B2B2B;">Карта выпускника КазГАСА</h2>
                        <p class="mt-4 text-base leading-relaxed" style="color: #2B2B2B;">
                            Предъявите карту у партнёров — и получите скидку.
                            Сохраняется в Apple Wallet и Google Pay.
                        </p>

                        <div class="mt-6">
                            @auth
                                @if($publicId)
                                    <div class="grid sm:grid-cols-2 gap-3">
                                        <a href="{{ route('wallet.apple', $publicId) }}"
                                           class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-xl font-medium hover:bg-gray-900 transition">
                                            🍎 Добавить в Apple Wallet
                                        </a>
                                        <a href="{{ route('wallet.google', $publicId) }}"
                                           class="flex items-center justify-center gap-2 bg-[#4285F4] text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-600 transition">
                                            G Добавить в Google Pay
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('profile.edit') }}"
                                       class="bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl font-semibold transition inline-flex items-center justify-center w-full">
                                        Заполните профиль, чтобы добавить карту
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl font-semibold transition inline-flex items-center justify-center w-full">
                                    Войти чтобы получить карту
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. ПАРТНЁРЫ Alumni --}}
        <section id="partners" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: #F6F2EA;">
            <div class="max-w-7xl mx-auto">
                <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-2 font-semibold">Партнёры Alumni</p>
                <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl">
                    Партнёры, где работает карта выпускника
                </h2>

                @php
                    $partners = [
                        [
                            'name' => 'Школа КазГАСА',
                            'discount' => 'X%',
                            'desc' => 'Скидка распространяется на детей и внуков выпускников КазГАСА.',
                            'logo' => 'К',
                            'popup' => 'Покажите карту выпускника администратору школы при подаче заявления на поступление. Скидка распространяется на детей и внуков выпускников КазГАСА.',
                            'note' => 'Нужен скан диплома, подтверждающий ваш статус выпускника.',
                        ],
                        [
                            'name' => 'Школа КАУ',
                            'discount' => 'X%',
                            'desc' => 'Скидка применяется к стоимости обучения за первый учебный год.',
                            'logo' => 'К',
                            'popup' => 'Покажите карту выпускника в приёмной комиссии при оформлении договора. Скидка применяется к стоимости обучения за первый учебный год.',
                            'note' => 'Нужен скан диплома.',
                        ],
                        [
                            'name' => 'Digital колледж КазГАСА',
                            'discount' => 'X%',
                            'desc' => 'Скидка действует при оформлении договора на первый год.',
                            'logo' => 'D',
                            'popup' => 'Покажите карту выпускника в приёмной комиссии при оформлении договора. Скидка применяется к стоимости обучения за первый учебный год.',
                            'note' => 'Нужен скан диплома.',
                        ],
                        [
                            'name' => 'Колледж КАУ',
                            'discount' => 'X%',
                            'desc' => 'Подача договора — и скидка активируется по карте выпускника.',
                            'logo' => 'К',
                            'popup' => 'Покажите карту выпускника в приёмной комиссии при оформлении договора. Скидка применяется к стоимости обучения за первый учебный год.',
                            'note' => 'Нужен скан диплома.',
                        ],
                        [
                            'name' => 'Магистратура КазГАСА',
                            'discount' => 'X%',
                            'desc' => 'Скидка на поступление и обучение для выпускников и семьи.',
                            'logo' => 'М',
                            'popup' => 'Покажите карту при подаче заявления. Скидка на детей и внуков выпускников КазГАСА.',
                            'note' => 'Нужен скан диплома.',
                        ],
                        [
                            'name' => 'Докторантура КазГАСА',
                            'discount' => 'X%',
                            'desc' => 'Поддержка выпускников на этапе докторантуры.',
                            'logo' => 'Д',
                            'popup' => 'Покажите карту при подаче заявления. Скидка применяется по программе для детей и внуков выпускников КазГАСА.',
                            'note' => 'Нужен скан диплома.',
                        ],
                        [
                            'name' => 'FabLab',
                            'discount' => 'X%',
                            'desc' => 'Современное пространство для воплощения архитектурных идей в модели.',
                            'logo' => 'F',
                            'popup' => 'Покажите карту выпускника менеджеру. Мы подберём подходящий формат участия и доступ к ресурсам FabLab.',
                            'note' => '',
                        ],
                        [
                            'name' => 'Лаборатория Дронов',
                            'discount' => 'X%',
                            'desc' => 'Аэрофото, тепловизия, 3D-моделирование и пилотирование.',
                            'logo' => 'U',
                            'popup' => 'Покажите карту выпускника менеджеру и получите условия участия по программе партнёрства Alumni.',
                            'note' => '',
                        ],
                        [
                            'name' => 'Gaudi Paint',
                            'discount' => '5%',
                            'desc' => 'Скидка на ассортимент водно-дисперсионных акриловых красок и декоративных покрытий.',
                            'logo' => 'G',
                            'popup' => 'Покажите карту выпускника КазГАСА продавцу-консультанту в магазине. Скидка применяется ко всему ассортименту.',
                            'note' => '',
                        ],
                        [
                            'name' => 'Автошкола Sapar',
                            'discount' => '20%',
                            'desc' => 'Права с нуля Алматы: теория + практика + экзамен.',
                            'logo' => 'S',
                            'popup' => 'Покажите карту выпускника при записи на курс или назовите, что вы выпускник КазГАСА. Скидка действует на полный курс обучения любой категории.',
                            'note' => '',
                        ],
                    ];
                @endphp

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($partners as $p)
                        <div x-data="{ open: false }"
                             class="bg-white rounded-2xl shadow-sm p-5 cursor-pointer
                                border border-transparent hover:border-[#8F161C] transition">
                            <div @click="open = true">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-[#F6F2EA] border border-[#D9D9D9]
                                            flex items-center justify-center text-[#8F161C] font-bold">
                                        {{ $p['logo'] }}
                                    </div>
                                    <span class="bg-[#8F161C] text-white text-sm px-2 py-0.5 rounded-full">
                                    {{ $p['discount'] }}
                                </span>
                                </div>
                                <div class="mt-4">
                                    <p class="font-bold text-[#2B2B2B] text-sm">{{ $p['name'] }}</p>
                                    <p class="text-sm text-gray-500 mt-2">{{ $p['desc'] }}</p>
                                </div>
                            </div>

                            {{-- Pop-up --}}
                            <div x-show="open" x-cloak @click.away="open = false"
                                 class="fixed inset-0 bg-black/50 flex items-center
                                    justify-center z-50 px-4">
                                <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-xl">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-[#8F161C] font-bold text-xl">
                                                {{ $p['name'] }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                Скидка: <span class="font-semibold text-[#8F161C]">{{ $p['discount'] }}</span>
                                            </p>
                                        </div>
                                        <button @click="open = false"
                                                class="text-gray-400 hover:text-gray-600 text-xl">
                                            ✕
                                        </button>
                                    </div>

                                    <p class="text-sm text-[#2B2B2B] mt-4 whitespace-pre-line">
                                        {{ $p['popup'] }}
                                    </p>
                                    @if(!empty($p['note']))
                                        <p class="text-xs text-gray-400 mt-3">
                                            {{ $p['note'] }}
                                        </p>
                                    @endif

                                    <div class="mt-6">
                                        <button @click="open = false"
                                                class="w-full bg-[#8F161C] hover:bg-[#5E0F14] text-white py-2.5 rounded-xl font-medium">
                                            Понятно
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- + Стать партнёром --}}
                <div class="mt-10 flex justify-center">
                    <div x-data="{ open: false, sent: false }" class="relative w-full max-w-xl">
                        <button @click="open = true"
                                class="w-full border-2 border-[#8F161C] text-[#8F161C] hover:bg-[#8F161C] hover:text-white
                                   px-6 py-2.5 rounded-xl font-medium transition">
                            + Стать партнёром
                        </button>

                        <div x-show="open" x-cloak
                             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
                            <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-xl relative">
                                <button @click="open = false"
                                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">✕</button>

                                <div x-show="!sent">
                                    <h3 class="text-[#5E0F14] font-bold text-xl mb-1">Предложите партнёрство</h3>
                                    <p class="text-sm text-gray-500 mb-4">
                                        Мы рассмотрим заявку и свяжемся с вами в течение 2 рабочих дней.
                                    </p>
                                    <form method="POST"
                                          action="{{ route('partner.apply') }}"
                                          @submit.prevent="sent = true; $el.submit()">
                                        @csrf
                                        <input name="name" placeholder="Ваше имя"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-[#8F161C] mb-3"
                                               required>
                                        <input name="company" placeholder="Название компании"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-[#8F161C] mb-3"
                                               required>
                                        <input name="contact" placeholder="Телефон или e-mail"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-[#8F161C] mb-4"
                                               required>
                                        <button class="w-full bg-[#8F161C] hover:bg-[#5E0F14] text-white py-2.5 rounded-xl font-medium">
                                            Отправить заявку
                                        </button>
                                    </form>
                                </div>

                                <div x-show="sent" class="text-center py-6">
                                    <span class="text-4xl">✅</span>
                                    <p class="text-[#5E0F14] font-bold text-lg mt-3">Спасибо!</p>
                                    <p class="text-gray-500 text-sm mt-1">
                                        Мы рассмотрим заявку и свяжемся с вами в течение 2 рабочих дней.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 7. ЛИЦА КазГАСА --}}
        <section id="faces" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-2 font-semibold">Гордость университета</p>
                <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl">
                    Лица КазГАСА
                </h2>
                <p class="text-sm text-gray-500 mt-2 max-w-3xl">
                    Министры, депутаты, предприниматели, архитекторы — они начинали здесь, в этих стенах.
                </p>

                @php
                    $faces = [
                        ['name' => 'Белович Александр Якубович', 'role' => 'Председатель Совета директоров ТОО «Холдинговая компания BAZIS»', 'img' => 'belovich.jpg', 'pos' => 'top'],
                        ['name' => 'Ким Владимир Сергеевич', 'role' => 'Президент, неисполнительный директор и акционер KAZ Minerals Ltd', 'img' => 'kimv.jpg', 'pos' => 'top'],
                        ['name' => 'Баталов Раимбек Анварович', 'role' => 'Казахстанский предприниматель, основатель холдинга Raimbek Group', 'img' => 'batalov.jpg', 'pos' => 'top'],
                        ['name' => 'Татыгулов Айдар Абдысагитович', 'role' => 'Член совета · Президент «KAZGOR»', 'img' => 'tat.jpg', 'pos' => 'top'],
                        ['name' => 'Абдуллин Нурлан Муханович', 'role' => 'Заслуженный деятель Казахстана. Почётный строитель РК', 'img' => 'abdullin.jpg', 'pos' => 'top'],
                        ['name' => 'Рустембеков Акмурза Исаевич', 'role' => 'Автор монумента Астана-Байтерек', 'img' => 'rustembekov.jpg', 'pos' => 'top', 'bw' => true],
                    ];
                @endphp


                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($faces as $f)
                        <div class="bg-white rounded-2xl shadow-sm p-5 text-center
                                hover:shadow-md transition border border-transparent hover:border-[#E5C68D]">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden mx-auto mb-4 ring-2 ring-[#8F161C]">
                                <img
                                        src="{{ $f['img'] ? asset('images/faces/'.$f['img']) : asset('images/hero-photo.jpg') }}"
                                        onerror="this.src='{{ asset('images/hero-photo.jpg') }}'"
                                        class="w-full h-full object-cover {{ !empty($f['bw']) ? 'grayscale' : '' }}"
                                        style="object-position: {{ $f['pos'] ?? '50% 20%' }}">
                            </div>
                            <p class="font-bold text-[#2B2B2B] text-sm leading-tight">
                                {{ $f['name'] }}
                            </p>
                            <p class="text-[#8F161C] text-xs mt-1">
                                {{ $f['role'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="{{ route('faces.index') }}"
                       class="inline-flex items-center justify-center px-8 py-3 rounded-xl font-semibold text-sm transition shadow-sm"
                       style="background-color: #8F161C; color: #FFFFFF;">
                        Подробнее
                    </a>
                </div>
            </div>
        </section>

        {{-- 7.1. ПРОЕКТЫ --}}
        @php
            $projects = \App\Models\Project::active()->get();
            $prefProjectId = (int) request()->query('project', (int) old('project_id', 0));
        @endphp
        <section id="projects" class="py-16 px-4 sm:px-6 lg:px-8 bg-[#FAF7F2]"
                 x-data="{
                    openId: null,
                    selectedProjectId: @js($prefProjectId),
                    toggle(id){ this.openId = this.openId === id ? null : id },
                    choose(id){
                        this.selectedProjectId = id;
                        const el = document.getElementById('projects-form');
                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        const url = new URL(window.location.href);
                        url.searchParams.set('project', String(id));
                        history.replaceState({}, '', url.toString());
                    }
                 }">
            <div class="max-w-7xl mx-auto">
                <p class="text-[#8F161C] text-xs uppercase tracking-widest font-semibold">Участие выпускников</p>
                <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl mt-2">Проекты, в которых вы нужны</h2>
                <p class="text-sm text-gray-500 mt-3 max-w-3xl">
                    Мы не просим просто «помочь». Мы предлагаем конкретные форматы — под ваш ритм, ваши возможности и ваши цели.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                    @foreach($projects as $p)
                        <div class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                            <button type="button" class="w-full text-left"
                                    @click="toggle({{ $p->id }})"
                                    :aria-expanded="openId === {{ $p->id }} ? 'true' : 'false'">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl leading-none">{{ $p->icon }}</span>
                                            <p class="font-bold text-[#2B2B2B] leading-snug">
                                                {{ $p->title }}
                                            </p>
                                        </div>
                                        @if($p->tags)
                                            <p class="text-sm text-gray-500 mt-2">
                                                {{ $p->tags }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="shrink-0 text-sm font-semibold text-[#8F161C]">
                                        Подробнее <span x-text="openId === {{ $p->id }} ? '▲' : '▼'"></span>
                                    </span>
                                </div>
                            </button>

                            <div x-show="openId === {{ $p->id }}" x-transition x-cloak class="mt-5 pt-5 border-t border-[#D9D9D9] space-y-4">
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-[#8F161C] font-semibold">Коротко</p>
                                    <p class="text-[#2B2B2B] mt-1">{{ $p->short }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-[#8F161C] font-semibold">Как это работает</p>
                                    <p class="text-[#2B2B2B] mt-1">{{ $p->how_it_works }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-[#8F161C] font-semibold">Что это даёт вам</p>
                                    <p class="text-[#2B2B2B] mt-1">{{ $p->what_you_get }}</p>
                                </div>

                                <div class="pt-1">
                                    <button type="button"
                                            class="w-full sm:w-auto bg-[#8F161C] hover:bg-[#5E0F14] text-white px-6 py-3 rounded-xl font-semibold transition text-sm"
                                            @click="choose({{ $p->id }})">
                                        {{ $p->button_text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 bg-white rounded-2xl shadow-sm p-6 sm:p-8 border border-[#D9D9D9]">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest font-semibold mb-2">Путь партнёрства</p>
                    <h3 class="text-[#2B2B2B] font-bold text-xl sm:text-2xl">5 шагов — и вы в проекте</h3>

                    <div class="mt-6 space-y-5">
                        @php
                            $steps = [
                                ['when' => 'Сегодня', 'title' => '1. Выберите проект', 'desc' => 'Заполните форму — укажите, какой проект вам ближе'],
                                ['when' => '1-я неделя', 'title' => '2. Фиксируем интерес', 'desc' => 'Мы связываемся, отвечаем на вопросы и согласуем детали'],
                                ['when' => '2-й месяц', 'title' => '3. Меморандум', 'desc' => 'Подписываем меморандум о партнёрстве без финансовых обязательств'],
                                ['when' => '2–3-й месяц', 'title' => '4. Первые шаги', 'desc' => 'Определяем роль и запускаем пилотные активности'],
                                ['when' => '5-й месяц', 'title' => '5. Результаты', 'desc' => 'Публикации о вас, студенты в ваших проектах, первые итоги'],
                                ['when' => 'Через год', 'title' => 'Масштаб', 'desc' => 'Ваше имя в истории Ассоциации', 'highlight' => true],
                            ];
                        @endphp
                        <div class="relative">
                            <div class="absolute left-4 top-2 bottom-2 w-px bg-[#E5C68D]"></div>
                            <div class="space-y-6">
                                @foreach($steps as $s)
                                    <div class="relative pl-12">
                                        <div class="absolute left-0 top-1.5 w-8 h-8 rounded-full flex items-center justify-center border-2"
                                             style="border-color:#E5C68D;background-color:#FFFFFF;">
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#8F161C]"></span>
                                        </div>
                                        <p class="text-xs uppercase tracking-widest {{ !empty($s['highlight']) ? 'text-[#8F161C] font-semibold' : 'text-gray-500' }}">
                                            {{ $s['when'] }}
                                        </p>
                                        <p class="font-bold {{ !empty($s['highlight']) ? 'text-[#8F161C]' : 'text-[#2B2B2B]' }}">
                                            {{ $s['title'] }}
                                        </p>
                                        <p class="text-sm {{ !empty($s['highlight']) ? 'text-[#8F161C]' : 'text-gray-600' }}">
                                            {{ $s['desc'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div id="projects-form" class="mt-10 scroll-mt-24">
                        <p class="text-[#8F161C] text-xs uppercase tracking-widest font-semibold mb-2">Заявка</p>
                        <h3 class="text-[#2B2B2B] font-bold text-xl sm:text-2xl">Участвую</h3>
                        @if(session('success'))
                            <div class="mt-4 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('project-applications.store') }}" class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">Имя</label>
                                <input name="name" value="{{ old('name') }}" required
                                       class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]" />
                                @error('name')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">Компания</label>
                                <input name="company" value="{{ old('company') }}"
                                       class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]" />
                                @error('company')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">Интересует проект</label>
                                <select name="project_id" required
                                        class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]"
                                        x-model.number="selectedProjectId">
                                    <option value="">Выберите проект</option>
                                    @foreach($projects as $p)
                                        <option value="{{ $p->id }}">{{ $p->title }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">Контакт (телефон или e-mail)</label>
                                <input name="contact" value="{{ old('contact') }}" required
                                       class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]" />
                                @error('contact')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <button class="w-full sm:w-auto bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl font-semibold transition">
                                    Участвую
                                </button>
                            </div>
                        </form>
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
                                <li><a href="{{ url('/') }}#alumni-card" class="text-sm text-white/80 hover:text-white">Карта выпускника</a></li>
                                <li><a href="{{ route('login') }}" class="text-sm text-white/80 hover:text-white">Вход</a></li>
                                <li><a href="{{ route('register') }}" class="text-sm text-white/80 hover:text-white">Регистрация</a></li>
                            </ul>
                        </div>
                        <div class="sm:col-span-2">
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">Контакты</h3>
                            <p class="mt-3 text-sm text-white/80">E-mail: l.lau@kazgasa.kz</p>
                            <p class="mt-3 text-sm text-white/80">Телефон: +7(778)403 1983</p>
                            <p class="mt-3 text-sm text-white/80">Адрес: Ул. Рыскулбекова, 28. Каб 301</p>
                            <p class="mt-3 text-sm text-white/80">Сайт КазГАСА: <a href="https://kazgasa.kz/" target ="_blank">kazgasa.kz</a></p>
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
