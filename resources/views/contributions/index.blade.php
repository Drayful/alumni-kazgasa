@extends('layouts.home')

@section('title', 'Вклад выпускников')

@section('content')
    <div x-data="{ mobileMenuOpen: false }" class="min-h-screen flex flex-col bg-[#F6F2EA]">
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
                        <a href="#" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Архив KazGASA</a>
                        @auth
                            <a href="{{ route('profile.edit') }}" class="text-sm font-medium hover:opacity-80" style="color: #2B2B2B;">Личный кабинет</a>
                        @endauth
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

        <main class="flex-1 py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto space-y-12">
                <section class="space-y-5">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">Вклад выпускников</p>
                    <h1 class="font-bold text-3xl sm:text-4xl text-[#2B2B2B]">Истории поддержки и развития КазГАСА</h1>
                    <p class="text-[#2B2B2B]/80 text-sm sm:text-base">
                        Выпускники участвуют в развитии кафедр и школ: оснащают лаборатории, поддерживают образовательные проекты и помогают студентам с практикой.
                    </p>
                </section>

                <section class="space-y-6">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">Кафедра</p>
                    <h2 class="font-bold text-2xl text-[#2B2B2B]">«Геодезия и картография, кадастр»</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                            <p class="font-bold text-[#2B2B2B]">Жалилов Лутпулла Лепитович (выпуск 1993)</p>
                            <p class="text-sm text-gray-500 mt-1">Выпускник кафедры</p>
                            <p class="text-[#2B2B2B] mt-3">
                                Содействие в оформлении аудитории, передал GPS-оборудование кафедре, а также обеспечивает производственную практику студентов.
                            </p>
                        </article>
                        <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                            <p class="font-bold text-[#2B2B2B]">Цуриков Вадим (выпуск 2007)</p>
                            <p class="text-sm text-gray-500 mt-1">Директор по инновациям SDG Alliance</p>
                            <p class="text-[#2B2B2B] mt-3">
                                Организовал посадку деревьев на территории МОК совместно со студентами и преподавателями.
                            </p>
                        </article>
                    </div>
                </section>

                <section class="space-y-6">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">Школа</p>
                    <h2 class="font-bold text-2xl text-[#2B2B2B]">Школа дизайна</h2>
                    <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                        <p class="font-bold text-[#2B2B2B]">Цой Владислав Алексеевич (группа ПД-15)</p>
                        <p class="text-sm text-gray-500 mt-1">Промышленный дизайнер, учредитель ТОО «АВ1», бренд Hitone</p>
                        <p class="text-[#2B2B2B] mt-3">
                            Куратор проекта «Библиотека материалов».
                        </p>
                        <div class="grid grid-cols-2 gap-3 mt-5">
                            <img src="{{ asset('images/contributions/image3.png') }}" alt="Библиотека материалов 1" class="rounded-xl object-cover w-full h-48">
                            <img src="{{ asset('images/contributions/image4.png') }}" alt="Библиотека материалов 2" class="rounded-xl object-cover w-full h-48">
                            <img src="{{ asset('images/contributions/image1.png') }}" alt="Библиотека материалов 1" class="rounded-xl object-cover w-full h-48">
                            <img src="{{ asset('images/contributions/image2.png') }}" alt="Библиотека материалов 2" class="rounded-xl object-cover w-full h-48">
                            
                        </div>
                    </article>
                </section>

                <section class="space-y-6">
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest">Школа</p>
                    <h2 class="font-bold text-2xl text-[#2B2B2B]">Школа строительства (ШС)</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                            <p class="font-bold text-[#2B2B2B]">Оспанов Омар Рахманович</p>
                            <p class="text-sm text-gray-500 mt-1">ТОО «CLIMATE EXPERT PARTNERS»</p>
                            <p class="text-[#2B2B2B] mt-3">
                                Открытие лаборатории №18 «Оборудование по кондиционированию воздуха» при поддержке компании Daikin.
        
                            </p>
                            <div class="grid grid-cols-2 gap-3 mt-5">
                            <img src="{{ asset('images/contributions/image6.png') }}" alt="Оборудование по кондиционированию воздуха" class="rounded-xl object-cover w-full h-48">
                    
                        </div>
                        </article>
                        <article class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                            <p class="font-bold text-[#2B2B2B]">Баккулов Марат Сатыбалдиевич</p>
                            <p class="text-sm text-gray-500 mt-1">ТОО «АВЗ»</p>
                            <p class="text-[#2B2B2B] mt-3">
                                Открытие лаборатории №3 «Вентиляция воздуха», оснащение оборудованием на сумму 12 000 000 тенге.
                            </p>
                            <div class="grid grid-cols-2 gap-3 mt-5">
                            <img src="{{ asset('images/contributions/image5.png') }}" alt="Вентиляция воздуха" class="rounded-xl object-cover w-full h-48">
                    
                        </div>
                        </article>
                    </div>
                </section>
            </div>
        </main>
    </div>
@endsection

