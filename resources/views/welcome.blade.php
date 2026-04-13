@extends('layouts.home')

@section('title', __('site.meta.home_title'))

@section('content')
    <div x-data="{ mobileMenuOpen: false, eventMapOpen: false }"
         @keydown.escape.window="eventMapOpen = false"
         class="min-h-screen flex flex-col">
        {{-- 1. TOP BAR --}}
        <div class="w-full h-9 flex items-center justify-end px-4 sm:px-6 lg:px-8" style="background-color: #8F161C;">
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-xs font-medium uppercase tracking-wider text-white border border-white px-4 py-1.5 rounded hover:bg-white hover:text-[#8F161C] transition-colors">
                        {{ __('site.nav.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-medium uppercase tracking-wider text-white border border-white px-4 py-1.5 rounded hover:bg-white hover:text-[#8F161C] transition-colors">
                        {{ __('site.nav.login') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-medium uppercase tracking-wider text-white border border-white px-4 py-1.5 rounded hover:bg-white hover:text-[#8F161C] transition-colors">
                        {{ __('site.nav.register') }}
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

                    <div class="hidden lg:flex items-center gap-6">
                        <a href="{{ url('/') }}#hero" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">{{ __('site.nav.home') }}</a>
                        <a href="{{ url('/') }}#alumni-card" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">{{ __('site.nav.alumni_card') }}</a>
                        <a href="{{ route('contributions.index') }}" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">{{ __('site.nav.contributions') }}</a>
                        <a href="#" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">{{ __('site.nav.meetup') }}</a>
                        <a href="https://museum.kazgasa.kz/" target="_blank" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">{{ __('site.nav.archive') }}</a>
                        @auth
                            <a href="{{ route('profile.edit') }}" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">{{ __('site.nav.dashboard') }}</a>
                        @endauth
                        <x-language-switch />
                        <button type="button" class="p-2 rounded-full hover:bg-[#F6F2EA] transition-colors" aria-label="{{ __('site.nav.search_aria') }}">
                            <svg class="w-5 h-5" style="color: #2B2B2B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>

                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden p-2 rounded-md hover:bg-[#F6F2EA]" aria-label="{{ __('site.nav.menu_aria') }}">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div x-show="mobileMenuOpen" x-transition class="lg:hidden border-t border-[#D9D9D9]">
                    <div class="py-4 flex flex-col gap-2">
                        <a href="{{ url('/') }}#hero" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">{{ __('site.nav.home') }}</a>
                        <a href="{{ url('/') }}#alumni-card" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">{{ __('site.nav.alumni_card') }}</a>
                        <a href="{{ route('contributions.index') }}" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">{{ __('site.nav.contributions') }}</a>
                        <a href="#" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">{{ __('site.nav.meetup') }}</a>
                        <a href="https://museum.kazgasa.kz/" target="_blank" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">{{ __('site.nav.archive') }}</a>
                        @auth
                            <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-sm font-medium" style="color: #2B2B2B;">{{ __('site.nav.dashboard') }}</a>
                        @endauth
                        <div class="px-4 pt-2">
                            <x-language-switch />
                        </div>
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
                    <div class="w-full h-full" style="background: linear-gradient(135deg, #F3F2EC 0%, #FFFFFF 55%, #F3F2EC 100%);"></div>
                @endif
                <div class="absolute inset-0" style="background: radial-gradient(1200px 600px at 15% 20%, rgba(229,198,141,0.25) 0%, rgba(243,242,236,0.0) 55%), linear-gradient(180deg, rgba(243,242,236,0.90) 0%, rgba(243,242,236,0.65) 60%, rgba(243,242,236,0.85) 100%);"></div>
            </div>

            <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 lg:pb-12 flex flex-col gap-8">
                <div class="flex flex-col justify-center space-y-6">

                    {{-- HERO TEXT --}}
                    <div>
{{--                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight max-w-none">--}}
{{--                            Слёт выпускников KazGASA--}}
{{--                        </h1>--}}
                        <p class="mt-3 text-base sm:text-lg text-black max-w-none">
                            {{ __('site.hero.line1') }}
                        </p>
                        <p class="mt-4 text-base sm:text-lg text-black max-w-none">
                            {{ __('site.hero.line2') }}
                        </p>
                    </div>

                    {{-- ФОТО + ЦИТАТА ПРЕДСЕДАТЕЛЯ --}}
                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        {{-- СЛЕВА: Фото --}}
                        <div class="relative flex-shrink-0">
                            <div class="absolute -inset-2 rounded-2xl bg-[#8F161C]/20"></div>
                            <img src="{{ asset('images/kusainov.jpg') }}"
                                 onerror="this.src='{{ asset('images/hero-photo.jpg') }}'"
                                 alt="{{ __('site.hero.chair_alt') }}"
                                 class="relative w-72 h-80 object-cover object-top rounded-2xl shadow-2xl">
                            <div class="absolute -bottom-1 -left-1 -right-1 h-1 bg-[#E5C68D] rounded-b-2xl"></div>
                        </div>

                        {{-- СПРАВА: Цитата --}}
                        <div class="w-full flex flex-col justify-center items-center text-center md:items-start md:text-left">
                            <div class="w-full rounded-2xl border border-[#E5C68D66] bg-white/70 backdrop-blur-sm shadow-sm p-5 md:p-6">
                                {{-- Kicker + line (как в примере) --}}
                                <div class="flex items-center gap-4">
                                    <p class="text-[#B78B3C] italic font-medium text-sm md:text-base">
                                        {{ __('site.hero.chair_kicker') }}
                                    </p>
                                    <div class="h-px flex-1 bg-[#E5C68D]"></div>
                                </div>

                                {{-- Текст цитаты --}}
                                <blockquote class="mt-4 text-black text-lg md:text-xl leading-relaxed font-normal">
                                    {!! nl2br(e(__('site.hero.chair_quote'))) !!}
                                </blockquote>

                                {{-- Имя и должность --}}
                                <div class="mt-6">
                                    <p class="text-[#B78B3C] font-semibold text-base">
                                        {{ __('site.hero.chair_name') }}
                                    </p>
                                    <p class="text-black text-sm mt-2 leading-snug">
                                        {{ __('site.hero.chair_role_1') }}<br>
                                        {{ __('site.hero.chair_role_2') }}
                                        @if(trim((string) __('site.hero.chair_role_3')) !== '')
                                            <br>{{ __('site.hero.chair_role_3') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ДАТА + ТАЙМЕР (обратный отсчёт до 15 апреля) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-[#8F161C]">
                            <p class="text-xs text-[#8F161C] uppercase tracking-wide font-medium">{{ __('site.hero.date_label') }}</p>
                            <p class="text-[#2B2B2B] font-bold text-sm mt-1">{{ __('site.hero.date_value') }}</p>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-[#8F161C] sm:col-span-2">
                            <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-3" style="color: #8F161C;">
                                {{ __('site.hero.countdown_title') }}
                            </p>
                            <div class="grid grid-cols-4 gap-2 sm:gap-3" data-countdown-root>
                                @foreach([
                                    __('site.countdown.days'),
                                    __('site.countdown.hours'),
                                    __('site.countdown.minutes'),
                                    __('site.countdown.seconds'),
                                ] as $label)
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
                            {{ __('site.hero.cta_program') }}
                        </a>
                        <a href="#alumni-card"
                           class="w-full md:w-auto border-2 border-[#8F161C]/30 text-[#2B2B2B] hover:border-[#8F161C]/60 hover:bg-white/40 px-8 py-3 rounded-xl font-semibold transition text-sm sm:text-base text-center">
                            {{ __('site.hero.cta_card') }}
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
                        <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">{{ __('site.stats.graduates') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">45+</div>
                        <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">{{ __('site.stats.years') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">50+</div>
                        <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">{{ __('site.stats.partners') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-bold" style="color: #8F161C;">100+</div>
                        <div class="mt-1 text-sm sm:text-base font-medium" style="color: #2B2B2B;">{{ __('site.stats.events') }}</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. ПРОГРАММА 15 АПРЕЛЯ — СЛЁТ ВЫПУСКНИКОВ --}}
        <section id="program" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-5xl mx-auto">
                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                    {{ __('site.program.date_line') }}
                </p>
                <h2 class="text-2xl sm:text-3xl font-bold mb-2" style="color: #2B2B2B;">
                    {{ __('site.program.title') }}
                </h2>
                <p class="text-sm text-gray-500 mb-8">
                    {{ __('site.program.subtitle') }}
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

                <div class="mt-8 flex flex-col sm:flex-row flex-wrap gap-3 justify-center">
                    <a href="{{ asset('files/program.pdf') }}"
                       download
                       class="inline-flex items-center justify-center bg-[#8F161C] hover:bg-[#5E0F14] text-white px-6 py-2.5 rounded-xl text-sm font-medium transition">
                        {{ __('site.program.download_pdf') }}
                    </a>
                    <a href="https://vrmir3d.com/KazGASA_VR/"
                       class="inline-flex items-center justify-center border border-[#8F161C] text-[#8F161C] hover:bg-[#8F161C] hover:text-white px-6 py-2.5 rounded-xl text-sm font-medium transition">
                        {{ __('site.program.campus_map') }}
                    </a>
                    <button type="button"
                            @click="eventMapOpen = true"
                            class="inline-flex items-center justify-center border border-[#8F161C] text-[#8F161C] hover:bg-[#8F161C] hover:text-white px-6 py-2.5 rounded-xl text-sm font-medium transition">
                        {{ __('site.program.event_map') }}
                    </button>
                </div>
            </div>
        </section>

        {{-- 6. КАРТА ВЫПУСКНИКА --}}
        <section id="alumni-card" class="py-16 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #F6F2EA 0%, #FFFFFF 40%, #F6F2EA 100%);">
            @php
                $alumniProfile = auth()->check() ? auth()->user()->alumniProfile : null;
                $publicId = $alumniProfile?->public_id;
            @endphp

            <div class="max-w-7xl mx-auto">
                <div class="rounded-3xl p-[1px]" style="background: linear-gradient(135deg, rgba(143,22,28,0.25) 0%, rgba(229,198,141,0.35) 40%, rgba(143,22,28,0.18) 100%);">
                    <div class="bg-white/85 backdrop-blur-sm rounded-3xl border border-white/60 shadow-lg shadow-[#8F161C]/10 p-6 sm:p-8">
                    <div class="grid lg:grid-cols-2 gap-10 items-center">
                        {{-- Текст + кнопки (слева) --}}
                        <div class="order-1">
                        <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-3">{{ __('site.alumni_card.eyebrow') }}</p>
                        <h2 class="text-2xl sm:text-3xl font-bold" style="color: #2B2B2B;">{{ __('site.alumni_card.title') }}</h2>
                        <p class="mt-4 text-base leading-relaxed" style="color: #2B2B2B;">
                            {{ __('site.alumni_card.body') }}
                        </p>

                        <div class="mt-6">
                            @auth
                                @if($publicId)
                                    <div class="grid sm:grid-cols-2 gap-3">
                                        <a href="{{ route('wallet.apple', $publicId) }}"
                                           class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-xl font-medium hover:bg-gray-900 transition">
                                            {{ __('site.alumni_card.apple') }}
                                        </a>
                                        <a href="{{ route('wallet.google', $publicId) }}"
                                           class="flex items-center justify-center gap-2 bg-[#4285F4] text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-600 transition">
                                            {{ __('site.alumni_card.google') }}
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('profile.edit') }}"
                                       class="bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl font-semibold transition inline-flex items-center justify-center w-full">
                                        {{ __('site.alumni_card.fill_profile') }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl font-semibold transition inline-flex items-center justify-center w-full">
                                    {{ __('site.alumni_card.login_for_card') }}
                                </a>
                            @endauth
                        </div>
                        </div>

                        {{-- Визуальная карточка (справа) --}}
                        <div class="flex justify-center lg:justify-end order-2">
                            <div class="w-full max-w-sm">
                                <x-alumni-card :alumni-profile="$alumniProfile" />
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. ПАРТНЁРЫ Alumni --}}
        <section id="partners" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: #F6F2EA;">
            <div class="max-w-7xl mx-auto">
                <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-2 font-semibold">{{ __('site.partners.eyebrow') }}</p>
                <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl">
                    {{ __('site.partners.title') }}
                </h2>

                @if($cardPartners->isEmpty())
                    <p class="mt-8 text-sm text-gray-500">{{ __('site.partners.empty') }}</p>
                @endif

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($cardPartners as $p)
                        <div x-data="{ open: false }"
                             class="bg-white rounded-2xl shadow-sm p-5 cursor-pointer
                                border border-transparent hover:border-[#8F161C] transition">
                            <div @click="open = true">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-[#F6F2EA] border border-[#D9D9D9]
                                            flex items-center justify-center text-[#8F161C] font-bold">
                                        {{ $p->logo_letter }}
                                    </div>
                                    <span class="bg-[#8F161C] text-white text-sm px-2 py-0.5 rounded-full">
                                    {{ $p->localized('discount') }}
                                </span>
                                </div>
                                <div class="mt-4">
                                    <p class="font-bold text-[#2B2B2B] text-sm">{{ $p->localized('name') }}</p>
                                    <p class="text-sm text-gray-500 mt-2">{{ $p->localized('description') }}</p>
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
                                                {{ $p->localized('name') }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ __('site.partners.discount_label') }} <span class="font-semibold text-[#8F161C]">{{ $p->localized('discount') }}</span>
                                            </p>
                                        </div>
                                        <button @click="open = false"
                                                class="text-gray-400 hover:text-gray-600 text-xl">
                                            ✕
                                        </button>
                                    </div>

                                    <p class="text-sm text-[#2B2B2B] mt-4 whitespace-pre-line">
                                        {{ $p->localized('popup') }}
                                    </p>
                                    @if(filled($p->localized('note')))
                                        <p class="text-xs text-gray-400 mt-3">
                                            {{ $p->localized('note') }}
                                        </p>
                                    @endif

                                    <div class="mt-6">
                                        <a href="{{ $p->url ?: url('/#partners') }}"
                                           target="{{ $p->url ? '_blank' : '_self' }}"
                                           @click="open = false"
                                           class="w-full inline-flex items-center justify-center bg-[#8F161C] hover:bg-[#5E0F14] text-white py-2.5 rounded-xl font-medium">
                                            {{ __('site.partners.go_to_partner') }}
                                        </a>
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
                            {{ __('site.partners.become') }}
                        </button>

                        <div x-show="open" x-cloak
                             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
                            <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-xl relative">
                                <button @click="open = false"
                                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">✕</button>

                                <div x-show="!sent">
                                    <h3 class="text-[#5E0F14] font-bold text-xl mb-1">{{ __('site.partners.modal_title') }}</h3>
                                    <p class="text-sm text-gray-500 mb-4">
                                        {{ __('site.partners.modal_text') }}
                                    </p>
                                    <form method="POST"
                                          action="{{ route('partner.apply') }}"
                                          @submit.prevent="sent = true; $el.submit()">
                                        @csrf
                                        <input name="name" placeholder="{{ __('site.partners.name_ph') }}"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-[#8F161C] mb-3"
                                               required>
                                        <input name="company" placeholder="{{ __('site.partners.company_ph') }}"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-[#8F161C] mb-3"
                                               required>
                                        <input name="contact" placeholder="{{ __('site.partners.contact_ph') }}"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-[#8F161C] mb-4"
                                               required>
                                        <button class="w-full bg-[#8F161C] hover:bg-[#5E0F14] text-white py-2.5 rounded-xl font-medium">
                                            {{ __('site.partners.submit') }}
                                        </button>
                                    </form>
                                </div>

                                <div x-show="sent" class="text-center py-6">
                                    <span class="text-4xl">✅</span>
                                    <p class="text-[#5E0F14] font-bold text-lg mt-3">{{ __('site.partners.thanks') }}</p>
                                    <p class="text-gray-500 text-sm mt-1">
                                        {{ __('site.partners.thanks_repeat') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 7. ЛИЦА KazGASA --}}
        <section id="faces" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-2 font-semibold">{{ __('site.faces.eyebrow') }}</p>
                <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl">
                    {{ __('site.faces.title') }}
                </h2>
                <p class="text-sm text-gray-500 mt-2 max-w-3xl">
                    {{ __('site.faces.subtitle') }}
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
                        {{ __('site.faces.more') }}
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
                <p class="text-[#8F161C] text-xs uppercase tracking-widest font-semibold">{{ __('site.projects.eyebrow') }}</p>
                <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl mt-2">{{ __('site.projects.title') }}</h2>
                <p class="text-sm text-gray-500 mt-3 max-w-3xl">
                    {{ __('site.projects.intro') }}
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
                                                {{ $p->localized('title') }}
                                            </p>
                                        </div>
                                        @if($p->localized('tags'))
                                            <p class="text-sm text-gray-500 mt-2">
                                                {{ $p->localized('tags') }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="shrink-0 text-sm font-semibold text-[#8F161C]">
                                        {{ __('site.projects.details') }} <span x-text="openId === {{ $p->id }} ? '▲' : '▼'"></span>
                                    </span>
                                </div>
                            </button>

                            <div x-show="openId === {{ $p->id }}" x-transition x-cloak class="mt-5 pt-5 border-t border-[#D9D9D9] space-y-4">
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-[#8F161C] font-semibold">{{ __('site.projects.short') }}</p>
                                    <p class="text-[#2B2B2B] mt-1">{{ $p->localized('short') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-[#8F161C] font-semibold">{{ __('site.projects.how') }}</p>
                                    <p class="text-[#2B2B2B] mt-1">{{ $p->localized('how_it_works') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-[#8F161C] font-semibold">{{ __('site.projects.benefit') }}</p>
                                    <p class="text-[#2B2B2B] mt-1">{{ $p->localized('what_you_get') }}</p>
                                </div>

                                <div class="pt-1">
                                    <button type="button"
                                            class="w-full sm:w-auto bg-[#8F161C] hover:bg-[#5E0F14] text-white px-6 py-3 rounded-xl font-semibold transition text-sm"
                                            @click="choose({{ $p->id }})">
                                        {{ $p->localized('button_text') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 bg-white rounded-2xl shadow-sm p-6 sm:p-8 border border-[#D9D9D9]">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest font-semibold mb-2">{{ __('site.projects.path_eyebrow') }}</p>
                    <h3 class="text-[#2B2B2B] font-bold text-xl sm:text-2xl">{{ __('site.projects.path_title') }}</h3>

                    <div class="mt-6 space-y-5">
                        @php
                            $steps = __('site.project_steps');
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
                        <p class="text-[#8F161C] text-xs uppercase tracking-widest font-semibold mb-2">{{ __('site.projects.form_eyebrow') }}</p>
                        <h3 class="text-[#2B2B2B] font-bold text-xl sm:text-2xl">{{ __('site.projects.form_title') }}</h3>
                        @if(session('success'))
                            <div class="mt-4 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('project-applications.store') }}" class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">{{ __('site.projects.form_name') }}</label>
                                <input name="name" value="{{ old('name') }}" required
                                       class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]" />
                                @error('name')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">{{ __('site.projects.form_company') }}</label>
                                <input name="company" value="{{ old('company') }}"
                                       class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]" />
                                @error('company')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">{{ __('site.projects.form_project') }}</label>
                                <select name="project_id" required
                                        class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]"
                                        x-model.number="selectedProjectId">
                                    <option value="">{{ __('site.projects.form_project_placeholder') }}</option>
                                    @foreach($projects as $p)
                                        <option value="{{ $p->id }}">{{ $p->localized('title') }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-[#2B2B2B]">{{ __('site.projects.form_contact') }}</label>
                                <input name="contact" value="{{ old('contact') }}" required
                                       class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-[#8F161C] focus:ring-[#8F161C]" />
                                @error('contact')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <button class="w-full sm:w-auto bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl font-semibold transition">
                                    {{ __('site.projects.submit') }}
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
                            {{ __('site.jobs.eyebrow') }}
                        </p>
                        <h2 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl">
                            {{ __('site.jobs.title') }}
                        </h2>
                    </div>
                    @auth
                        <a href="{{ route('jobs.index') }}"
                           class="hidden sm:block text-[#8F161C] text-sm font-semibold hover:text-[#5E0F14] hover:underline transition">
                            {{ __('site.jobs.all') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden sm:block text-[#8F161C] text-sm font-semibold hover:text-[#5E0F14] hover:underline transition">
                            {{ __('site.jobs.all') }}
                        </a>
                    @endauth
                </div>

                @if($latestJobs->isEmpty())
                    <div class="border border-dashed border-[#D9D9D9] rounded-2xl p-8 text-center text-sm text-gray-500">
                        {{ __('site.jobs.empty') }}
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
                                    {{ __('site.jobs.details') }}
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="sm:hidden text-center mt-6">
                        @auth
                            <a href="{{ route('jobs.index') }}"
                               class="inline-block border-2 border-[#8F161C] text-[#8F161C] px-8 py-3 rounded-xl font-semibold text-sm hover:bg-[#8F161C] hover:text-white transition-colors">
                                {{ __('site.jobs.all_mobile') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-block border-2 border-[#8F161C] text-[#8F161C] px-8 py-3 rounded-xl font-semibold text-sm hover:bg-[#8F161C] hover:text-white transition-colors">
                                {{ __('site.jobs.all_mobile') }}
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
                    {{ __('site.science.date') }}
                </p>
                <h2 class="text-2xl sm:text-3xl font-bold mb-4" style="color: #2B2B2B;">
                    {{ __('site.science.title') }}
                </h2>
                <p class="text-sm sm:text-base leading-relaxed mb-6" style="color: #2B2B2B;">
                    {{ __('site.science.intro') }}
                </p>

                <div class="space-y-3">
                    @foreach(__('site.science_topics') as $topic)
                    <div class="flex items-start gap-3 rounded-2xl border bg-white px-4 py-3 sm:py-4"
                         style="border-color: #D9D9D9;">
                        <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-lg"
                             style="background-color: #F6F2EA; color: #8F161C;">
                            📄
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold" style="color: #2B2B2B;">
                                {{ $topic['title'] }}
                            </p>
                            <p class="text-xs mt-0.5" style="color: #2B2B2B99;">
                                {{ $topic['subtitle'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="{{ asset('Ғылым декадасының бағдарламасы 2026.pdf') }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center justify-center bg-[#8F161C] hover:bg-[#5E0F14] text-white px-8 py-3 rounded-xl text-sm font-semibold transition shadow-md shadow-[#8F161C]/20">
                        {{ __('site.science.program_button') }}
                    </a>
                </div>
            </div>
        </section>

        {{-- 7. АРХИВ KAZGASA --}}
        @php
            $archiveUploadVerified = auth()->check()
                && auth()->user()->alumniProfile?->verification_status === 'verified';
        @endphp
        <section id="archive" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-5xl mx-auto" x-data="{ decade: '90s' }">
                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase mb-2" style="color: #8F161C;">
                    {{ __('site.archive.eyebrow') }}
                </p>
                <h2 class="text-2xl sm:text-3xl font-bold mb-4" style="color: #2B2B2B;">
                    {{ __('site.archive.title') }}
                </h2>
                <p class="text-sm sm:text-base leading-relaxed mb-5" style="color: #2B2B2B;">
                    {{ __('site.archive.intro') }}
                </p>

                @if(session('archive_success'))
                    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('archive_success') }}
                    </div>
                @endif
                @if($errors->has('photo') || $errors->has('decade'))
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-[#8F161C]">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->only(['photo', 'decade']) as $fieldErrors)
                                @foreach((array) $fieldErrors as $err)
                                    <li>
                                        {{ is_array($err) ? implode(', ', $err) : $err }}
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-2 -mx-1 px-1 snap-x snap-mandatory">
                    @foreach($archiveDecades as $key => $label)
                        <button type="button"
                                @click="decade = '{{ $key }}'"
                                :class="decade === '{{ $key }}'
                                    ? 'bg-[#8F161C] text-white border-[#8F161C]'
                                    : 'bg-white text-[#2B2B2B] border-[#D9D9D9]'"
                                class="snap-start shrink-0 px-4 py-3 sm:py-2 rounded-full text-xs sm:text-sm font-semibold border whitespace-nowrap min-h-[44px] sm:min-h-0 inline-flex items-center justify-center transition">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                @foreach($archiveDecades as $key => $label)
                    @php
                        $decadePhotos = $archivePhotosPreview[$key] ?? collect();
                        $decadeTotal = (int) ($archivePhotoTotals[$key] ?? 0);
                        $showViewAll = $decadeTotal > \App\Models\ArchivePhoto::HOME_PREVIEW_LIMIT;
                    @endphp
                    <div x-show="decade === '{{ $key }}'" x-cloak class="mt-4">
                        @if($decadePhotos->isEmpty())
                            <div class="grid grid-cols-3 gap-2 sm:gap-3">
                                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                                     style="background: linear-gradient(135deg, #1F2A44, #5E0F14);">🏛️</div>
                                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                                     style="background: linear-gradient(135deg, #8F161C, #E5C68D);">🎓</div>
                                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                                     style="background: linear-gradient(135deg, #2B2B2B, #8F161C);">📐</div>
                                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                                     style="background: linear-gradient(135deg, #E5C68D, #5E0F14);">🏗️</div>
                                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                                     style="background: linear-gradient(135deg, #1F2A44, #E5C68D);">🎨</div>
                                <div class="aspect-square rounded-lg flex items-center justify-center text-2xl sm:text-3xl"
                                     style="background: linear-gradient(135deg, #5E0F14, #2B2B2B);">🏙️</div>
                            </div>
                            <p class="mt-3 text-sm text-center" style="color: #2B2B2B99;">
                                {{ __('site.archive.empty_decade') }}
                            </p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-3">
                                @foreach($decadePhotos as $photo)
                                    <a href="{{ Storage::url($photo->path) }}"
                                       target="_blank" rel="noopener"
                                       class="group aspect-square rounded-lg overflow-hidden border bg-[#F6F2EA] border-[#D9D9D9] focus:outline-none focus:ring-2 focus:ring-[#8F161C] focus:ring-offset-2">
                                        <img src="{{ Storage::url($photo->path) }}"
                                             alt="{{ __('site.archive.photo_alt', ['decade' => $label]) }}"
                                             class="w-full h-full object-cover group-hover:opacity-95 transition"
                                             loading="lazy"
                                             decoding="async">
                                    </a>
                                @endforeach
                            </div>
                            @if($showViewAll)
                                <div class="mt-4 flex justify-center sm:justify-start">
                                    <a href="{{ route('archive.index', ['decade' => $key]) }}"
                                       class="inline-flex min-h-[48px] items-center justify-center px-6 py-3 rounded-xl text-sm font-semibold text-white transition hover:opacity-95"
                                       style="background-color: #8F161C;">
                                        {{ __('site.archive.view_all', ['count' => $decadeTotal - \App\Models\ArchivePhoto::HOME_PREVIEW_LIMIT]) }}
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach

                <div class="mt-6">
                    @if($archiveUploadVerified)
                        <details @if($errors->has('photo') || $errors->has('decade')) open @endif class="group rounded-2xl border overflow-hidden" style="border-color: #D9D9D9; background-color: #F6F2EA;">
                            <summary class="cursor-pointer list-none flex items-center justify-between gap-3 px-4 py-4 sm:px-5 sm:py-4 min-h-[52px] font-semibold text-sm sm:text-base select-none"
                                     style="color: #2B2B2B;">
                                <span class="inline-flex items-center gap-2">
                                    <span class="text-xl" aria-hidden="true">📷</span>
                                    <span>{{ __('site.archive.add_toggle') }}</span>
                                </span>
                                <span class="text-[#8F161C] text-lg group-open:rotate-180 transition-transform">▼</span>
                            </summary>
                            <div class="px-4 pb-5 sm:px-5 border-t bg-white" style="border-color: #D9D9D9;">
                                <form id="archive-photo-upload-form" action="{{ route('archive.photos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-4">
                                    @csrf

                                    <div>
                                        <label for="archive-decade" class="block text-sm font-semibold mb-2" style="color: #2B2B2B;">{{ __('site.archive.decade') }}</label>
                                        <select name="decade" id="archive-decade" required
                                                class="w-full min-h-[48px] rounded-xl border px-4 text-base sm:text-sm bg-white"
                                                style="border-color: #D9D9D9; color: #2B2B2B;">
                                            @foreach($archiveDecades as $k => $lab)
                                                <option value="{{ $k }}" @selected(old('decade', '90s') === $k)>{{ $lab }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="archive-photo" class="block text-sm font-semibold mb-2" style="color: #2B2B2B;">{{ __('site.archive.photo_label') }}</label>
                                        <p class="text-xs mb-2" style="color: #2B2B2B99;">{{ __('site.archive.photo_hint') }}</p>
                                        <input type="file" name="photo" id="archive-photo" required accept="image/jpeg,image/png,image/webp"
                                               class="block w-full min-h-[48px] text-base file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#8F161C] file:text-white cursor-pointer rounded-xl border bg-white px-2 py-2"
                                               style="border-color: #D9D9D9;">
                                    </div>

                                    <button type="submit"
                                            class="w-full sm:w-auto min-h-[52px] inline-flex items-center justify-center px-6 py-3 rounded-xl text-sm font-semibold text-white transition hover:opacity-95"
                                            style="background-color: #8F161C;">
                                        {{ __('site.archive.submit') }}
                                    </button>
                                </form>
                            </div>
                        </details>
                    @elseif(auth()->check())
                        <p class="text-sm rounded-xl border px-4 py-3" style="border-color: #D9D9D9; color: #2B2B2B99; background: #FAFAFA;">
                            {{ __('site.archive.verified_line_before') }}<strong class="text-[#2B2B2B]">{{ __('site.archive.verified_emphasis') }}</strong>{{ __('site.archive.verified_line_after') }}
                        </p>
                    @else
                        <p class="text-sm rounded-xl border px-4 py-3" style="border-color: #D9D9D9; color: #2B2B2B99; background: #FAFAFA;">
                            <a href="{{ route('login') }}" class="font-semibold text-[#8F161C] underline underline-offset-2">{{ __('site.archive.guest_login') }}</a>{{ __('site.archive.guest_after_login') }}
                        </p>
                    @endif
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
                            <p class="mt-2 text-sm text-white/80">{{ __('site.footer.tagline') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">{{ __('site.footer.nav') }}</h3>
                            <ul class="mt-3 space-y-2">
                                <li><a href="{{ url('/') }}#hero" class="text-sm text-white/80 hover:text-white">{{ __('site.nav.home') }}</a></li>
                                <li><a href="{{ url('/') }}#alumni-card" class="text-sm text-white/80 hover:text-white">{{ __('site.nav.alumni_card') }}</a></li>
                                <li><a href="{{ route('login') }}" class="text-sm text-white/80 hover:text-white">{{ __('site.nav.login') }}</a></li>
                                <li><a href="{{ route('register') }}" class="text-sm text-white/80 hover:text-white">{{ __('site.nav.register') }}</a></li>
                            </ul>
                        </div>
                        <div class="sm:col-span-2">
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">{{ __('site.footer.contacts') }}</h3>
                            <p class="mt-3 text-sm text-white/80">{{ __('site.footer.email') }}</p>
                            <p class="mt-3 text-sm text-white/80">{{ __('site.footer.phone') }}</p>
                            <p class="mt-3 text-sm text-white/80">{{ __('site.footer.address') }}</p>
                            <p class="mt-3 text-sm text-white/80">{{ __('site.footer.site') }} <a href="https://kazgasa.kz/" target ="_blank">kazgasa.kz</a></p>
                            <p class="mt-3 text-sm text-white/80">{{ __('site.footer.corp') }}</p>
                            <p class="mt-1 text-sm text-white/80">{{ __('site.footer.city') }}</p>
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
                © {{ date('Y') }} KazGASA Alumni. {{ __('site.footer.rights') }}
            </div>
        </footer>

        <div x-cloak x-show="eventMapOpen" class="fixed inset-0 z-[100]" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-black/70" @click="eventMapOpen = false"></div>
            <div class="absolute inset-0 p-4 sm:p-8 flex items-center justify-center pointer-events-none">
                <div class="w-full max-w-6xl pointer-events-auto">
                    <div class="flex items-center justify-end mb-3">
                        <button type="button"
                                class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-white text-[#2B2B2B] font-bold hover:bg-[#F6F2EA] transition shadow"
                                @click="eventMapOpen = false"
                                aria-label="{{ __('site.program.event_map_close') }}">
                            ✕
                        </button>
                    </div>
                    <div class="bg-white rounded-2xl overflow-hidden border border-[#D9D9D9] shadow-lg max-h-[85vh] overflow-y-auto">
                        <img src="{{ asset('images/event-map.png') }}"
                             alt="{{ __('site.program.event_map_alt') }}"
                             class="w-full h-auto object-contain bg-[#F6F2EA]">
                    </div>
                </div>
            </div>
        </div>
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

            // Массовые проблемы с загрузкой фото из-за ограничений POST на сервере.
            // Перед отправкой уменьшаем выбранное фото в браузере, чтобы избежать PostTooLargeException.
            const archiveForm = document.getElementById('archive-photo-upload-form');
            const archiveFileInput = document.getElementById('archive-photo');
            if (archiveForm && archiveFileInput) {
                const TARGET_MAX_BYTES = 700 * 1024; // ~700KB, обычно проходит при низких лимитах
                const MAX_DIMENSION = 1600;

                async function compressFileToJpeg(file) {
                    const imgUrl = URL.createObjectURL(file);
                    try {
                        const img = await new Promise((resolve, reject) => {
                            const el = new Image();
                            el.onload = () => resolve(el);
                            el.onerror = reject;
                            el.src = imgUrl;
                        });

                        let w = img.naturalWidth || img.width;
                        let h = img.naturalHeight || img.height;
                        if (!w || !h) return { blob: file, filename: file.name };

                        const scale = Math.min(1, MAX_DIMENSION / Math.max(w, h));
                        w = Math.round(w * scale);
                        h = Math.round(h * scale);

                        const canvas = document.createElement('canvas');
                        canvas.width = w;
                        canvas.height = h;
                        const ctx = canvas.getContext('2d', { willReadFrequently: false });
                        if (!ctx) return { blob: file, filename: file.name };
                        ctx.imageSmoothingEnabled = true;
                        ctx.imageSmoothingQuality = 'high';
                        ctx.drawImage(img, 0, 0, w, h);

                        const nameWithoutExt = file.name.replace(/\.[^/.]+$/, '');
                        const candidates = [0.92, 0.82, 0.72, 0.62, 0.52, 0.42, 0.32, 0.22, 0.15];
                        let lastBlob = null;

                        for (const q of candidates) {
                            const blob = await new Promise((resolve) => {
                                canvas.toBlob((b) => resolve(b), 'image/jpeg', q);
                            });
                            if (!blob) continue;
                            lastBlob = blob;
                            if (blob.size <= TARGET_MAX_BYTES) {
                                return { blob, filename: nameWithoutExt + '.jpg' };
                            }
                        }

                        return lastBlob ? { blob: lastBlob, filename: nameWithoutExt + '.jpg' } : { blob: file, filename: file.name };
                    } finally {
                        URL.revokeObjectURL(imgUrl);
                    }
                }

                archiveForm.addEventListener('submit', async (e) => {
                    try {
                        const file = archiveFileInput.files && archiveFileInput.files[0];
                        if (!file) return;
                        if (file.size <= TARGET_MAX_BYTES) return;

                        const compressed = await compressFileToJpeg(file);
                        const dt = new DataTransfer();
                        dt.items.add(new File([compressed.blob], compressed.filename, { type: 'image/jpeg' }));
                        archiveFileInput.files = dt.files;
                    } catch (err) {
                        // Если ресайз не удался — всё равно отправим исходный файл.
                        console.warn('archive-photo compress failed', err);
                    }
                });
            }
        })();
    </script>
@endpush
