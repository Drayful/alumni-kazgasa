@extends('layouts.home')

@section('title', __('site.pages.contributions_title'))

@section('content')
    <div x-data="{
            mobileMenuOpen: false,
            lbOpen: false,
            lbSrc: '',
            lbAlt: '',
            openLB(src, alt) { this.lbSrc = src; this.lbAlt = alt || ''; this.lbOpen = true; },
            closeLB() { this.lbOpen = false; this.lbSrc = ''; this.lbAlt = ''; }
        }"
        @keydown.escape.window="closeLB()"
        class="min-h-screen flex flex-col bg-[#F6F2EA]">
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

        <main class="flex-1 py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto space-y-12">
                <section class="space-y-5">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">{{ __('site.contributions_page.eyebrow') }}</p>
                    <h1 class="font-bold text-3xl sm:text-4xl text-[#2B2B2B]">{{ __('site.contributions_page.h1') }}</h1>
                    <p class="text-[#2B2B2B]/80 text-sm sm:text-base">
                        {{ __('site.contributions_page.intro') }}
                    </p>
                </section>

                @php($a = $contributions['architecture_card'] ?? [])
                <section class="space-y-4">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">{{ __('site.contributions_page.school') }}</p>
                    <h2 class="font-bold text-2xl text-[#2B2B2B]">{{ __('site.contributions_page.arch_title') }}</h2>
                    <p class="text-[#2B2B2B]/80 text-sm">
                        {{ __('site.contributions_page.zoom_hint') }}
                    </p>

                    <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                        <p class="font-bold text-[#2B2B2B]">{{ $a['title'] ?? '' }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ implode(' · ', $a['roles'] ?? []) }}
                        </p>

                        <div class="mt-4 space-y-5 text-[#2B2B2B]">
                            @foreach(($a['items'] ?? []) as $item)
                                <div class="space-y-2">
                                    @if(!empty($item['title']))
                                        <p class="font-semibold">{{ $item['title'] }}</p>
                                    @endif
                                    @if(!empty($item['pre_initiators_bold']))
                                        <p class="font-semibold">{{ $item['pre_initiators_bold'] }}</p>
                                    @endif
                                    @if(!empty($item['initiators']))
                                        <p class="text-[#2B2B2B]/70">{{ $item['initiators'] }}</p>
                                    @endif
                                    @if(!empty($item['description']))
                                        <p>{{ $item['description'] }}</p>
                                    @endif
                                    @if(!empty($item['what_done']))
                                        <div>
                                            <p class="font-semibold">{{ ($contributions['labels']['what_done'] ?? 'Что сделано:') }}</p>
                                            <ul class="list-disc list-inside space-y-1 text-[#2B2B2B]/90">
                                                @foreach($item['what_done'] as $w)
                                                    <li>{{ $w }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(!empty($item['note']))
                                        <p class="text-sm text-[#2B2B2B]/80"><span class="font-semibold">{{ ($contributions['labels']['note'] ?? 'Примечание:') }}</span> {{ $item['note'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if(!empty($a['photos']))
                            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($a['photos'] as $src)
                                    <button type="button"
                                            class="rounded-xl overflow-hidden border border-[#D9D9D9] bg-[#F6F2EA] focus:outline-none focus:ring-2 focus:ring-[#8F161C] focus:ring-offset-2"
                                            @click="openLB('{{ $src }}', @js($a['title'] ?? ''))">
                                        <img src="{{ $src }}" alt="{{ $contributions['labels']['photo'] ?? 'Фото' }}" class="w-full h-36 sm:h-40 object-cover cursor-zoom-in">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </article>
                </section>

                @php($g = $contributions['geodesy'] ?? [])
                <section class="space-y-6">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">{{ __('site.contributions_page.dept') }}</p>
                    <h2 class="font-bold text-2xl text-[#2B2B2B]">{{ $g['heading'] ?? '' }}</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach(($g['cards'] ?? []) as $card)
                            <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                                <p class="font-bold text-[#2B2B2B]">{{ $card['name'] ?? '' }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $card['subtitle'] ?? __('site.contributions_page.graduate_of_dept') }}
                                </p>
                                <p class="text-[#2B2B2B] mt-3">
                                    {{ $card['body'] ?? '' }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>

                @php($d = $contributions['design'] ?? [])
                <section class="space-y-6">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">{{ __('site.contributions_page.school') }}</p>
                    <h2 class="font-bold text-2xl text-[#2B2B2B]">{{ __('site.contributions_page.design_title') }}</h2>
                    <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                        <p class="font-bold text-[#2B2B2B]">{{ $d['name'] ?? '' }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $d['subtitle'] ?? '' }}</p>
                        <p class="text-[#2B2B2B] mt-3">
                            {{ $d['body'] ?? '' }}
                        </p>
                        <div class="grid grid-cols-2 gap-3 mt-5">
                            @foreach(($d['gallery'] ?? []) as $img)
                                @php($src = asset('images/contributions/'.($img['file'] ?? '')))
                                <img src="{{ $src }}" alt="{{ $img['caption'] ?? '' }}"
                                     class="rounded-xl object-cover w-full h-48 cursor-zoom-in"
                                     @click="openLB('{{ $src }}', @js($img['caption'] ?? ''))">
                            @endforeach
                        </div>
                    </article>
                </section>

                @php($cons = $contributions['construction'] ?? [])
                <section class="space-y-6">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">{{ __('site.contributions_page.school') }}</p>
                    <h2 class="font-bold text-2xl text-[#2B2B2B]">{{ __('site.contributions_page.construction_title') }}</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach(($cons['cards'] ?? []) as $card)
                            <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition {{ !empty($card['wide']) ? 'lg:col-span-2' : '' }}">
                                <p class="font-bold text-[#2B2B2B]">{{ $card['name'] ?? '' }}</p>
                                <p class="text-sm text-gray-500 mt-1 whitespace-pre-line">{{ $card['subtitle'] ?? '' }}</p>
                                <div class="text-[#2B2B2B] mt-3 space-y-3 text-sm leading-relaxed">
                                    @foreach(($card['sections'] ?? []) as $sec)
                                        @if(($sec['type'] ?? '') === 'p')
                                            <p>{{ $sec['text'] ?? '' }}</p>
                                        @elseif(($sec['type'] ?? '') === 'ul')
                                            <ul class="list-disc pl-5 space-y-2">
                                                @foreach(($sec['items'] ?? []) as $li)
                                                    <li><span class="font-semibold">{{ $li['k'] ?? '' }}</span> {{ $li['v'] ?? '' }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </div>
                                @if(!empty($card['images']))
                                    <div class="grid grid-cols-2 gap-3 mt-5 {{ !empty($card['wide']) ? 'max-w-lg' : '' }}">
                                        @foreach($card['images'] as $img)
                                            @php($src = asset('images/contributions/'.($img['file'] ?? '')))
                                            <img src="{{ $src }}" alt="{{ $img['alt'] ?? '' }}"
                                                 class="rounded-xl object-cover w-full h-48 cursor-zoom-in"
                                                 @click="openLB('{{ $src }}', @js($img['alt'] ?? ''))">
                                        @endforeach
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </main>

        <div x-cloak x-show="lbOpen" class="fixed inset-0 z-[100]">
            <div class="absolute inset-0 bg-black/70" @click="closeLB()"></div>
            <div class="absolute inset-0 p-4 sm:p-8 flex items-center justify-center">
                <div class="w-full max-w-5xl">
                    <div class="flex items-center justify-end mb-3">
                        <button type="button"
                                class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-white text-[#2B2B2B] font-bold hover:bg-[#F6F2EA] transition"
                                @click="closeLB()"
                                aria-label="{{ __('site.contributions_page.close') }}">
                            ✕
                        </button>
                    </div>
                    <div class="bg-white rounded-2xl overflow-hidden border border-[#D9D9D9] shadow-lg">
                        <img :src="lbSrc" :alt="lbAlt" class="w-full max-h-[80vh] object-contain bg-[#F6F2EA]">
                        <div class="px-4 py-3 text-sm text-[#2B2B2B]/70" x-text="lbAlt"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

