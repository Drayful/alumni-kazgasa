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

    {{-- 3. HERO --}}
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

            <div class="flex-1 flex flex-col justify-center lg:pl-12">
                <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/80 text-sm font-medium mb-4" style="color: #8F161C;">Приветствие</div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight max-w-2xl">
                    Дорогие выпускники КазГАСА / ААСИ / КазПТИ
                </h1>
                <p class="mt-4 text-base sm:text-lg text-white/95 max-w-lg">
                    Сообщество выпускников Казахской национальной академии искусств имени Т. Жургенова — это связь поколений, профессиональная поддержка и общие ценности. Присоединяйтесь к нам.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="https://kazgasa.kz" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white rounded transition-colors hover:opacity-90" style="background-color: #8F161C;">
                        Сайт КазГАСА
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium rounded transition-colors hover:opacity-90" style="background-color: #E5C68D; color: #2B2B2B;">
                        Присоединиться к сообществу
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
                    <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">5000+</div>
                    <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">Выпускников</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">30+</div>
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

    {{-- 5. КАРТА ВЫПУСКНИКА --}}
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
                        <p class="mt-3 text-sm text-white/80">Казахская национальная академия искусств имени Т. Жургенова</p>
                        <p class="mt-1 text-sm text-white/80">г. Алматы, Казахстан</p>
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
