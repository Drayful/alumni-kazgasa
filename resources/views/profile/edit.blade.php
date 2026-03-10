<x-app-layout>
    <x-slot name="breadcrumb">
        <nav class="flex text-sm">
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-[#8F161C] transition-colors">Главная</a>
            <span class="mx-2 text-[#C56A6E]">→</span>
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-[#8F161C] transition-colors">Личный кабинет</a>
            <span class="mx-2 text-[#C56A6E]">→</span>
            <span class="text-[#8F161C] font-medium">Профиль</span>
        </nav>
    </x-slot>

    {{-- Page Header Banner --}}
    <header class="relative bg-[#8F161C] py-8 overflow-hidden">
        <div class="absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute inset-0" style="background-image: linear-gradient(to right, rgba(255,255,255,0.15) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 24px 24px;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[#E5C68D] text-xs sm:text-sm tracking-wide mb-1">Личный кабинет / Профиль</p>
            <h1 class="text-2xl sm:text-3xl font-bold text-white">Профиль выпускника</h1>
        </div>
    </header>

    {{-- Page Body --}}
    <div class="min-h-screen bg-[#F6F2EA] py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status') === 'profile-updated' || session('status') === 'alumni-profile-updated' || session('status') === 'password-updated')
                <div class="mb-6 p-4 bg-[#F6F2EA] border border-[#8F161C] text-[#5E0F14] rounded-lg text-sm" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
                    {{ session('status') === 'password-updated' ? __('Saved.') : (session('status') === 'alumni-profile-updated' ? __('Профиль выпускника сохранён.') : __('Saved.')) }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- A) Digital Card Block --}}
                    @if ($alumniProfile)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                            <p class="text-[#8F161C] text-xs font-medium tracking-widest uppercase mb-4">ЦИФРОВАЯ КАРТА ВЫПУСКНИКА</p>
                            <x-alumni-card :alumni-profile="$alumniProfile" />
                            <p class="mt-4 text-sm text-gray-500 italic">Покажите эту карту на экране телефона — она привязана к вашему профилю выпускника.</p>
                        </div>

                        {{-- B) Status Block --}}
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                            <h3 class="text-[#2B2B2B] font-semibold mb-4">Статус карты</h3>
                            @php
                                $status = $alumniProfile->status ?? 'Connect';
                                $statusStyles = [
                                    'Connect' => 'bg-[#D9D9D9] text-[#2B2B2B]',
                                    'Start'   => 'bg-[#E5C68D] text-[#5E0F14]',
                                    'Core'    => 'bg-[#8F161C] text-white',
                                    'Elite'   => 'bg-[#1F2A44] text-[#E5C68D]',
                                ];
                                $pillClass = $statusStyles[$status] ?? $statusStyles['Connect'];
                            @endphp
                            <div class="mb-4">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium {{ $pillClass }}">{{ $status }}</span>
                            </div>
                            <div class="space-y-2 text-sm text-[#2B2B2B]">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#8F161C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>{{ ($alumniProfile->membership_type ?? 'free') === 'paid' ? 'Платный' : 'Бесплатный' }}</span>
                                </div>
                                @if ($alumniProfile->membership_expiry_date)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#8F161C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span>Действительна до {{ $alumniProfile->membership_expiry_date->format('d.m.Y') }}</span>
                                    </div>
                                @endif
                            </div>
                            <hr class="my-4 border-[#D9D9D9]" />
                            <p class="text-xs text-gray-500">Партнёры могут сканировать ваш QR-код для подтверждения скидки</p>
                        </div>
                    @endif
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- C) Profile (Alumni) Form --}}
                    @if ($alumniProfile)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 sm:p-8">
                            <div class="border-l-4 border-[#8F161C] pl-4">
                                <h2 class="text-xl font-bold text-[#2B2B2B]">Профиль выпускника</h2>
                                <p class="text-sm text-gray-500 mt-1 mb-6">Редактируйте данные выпускника: ФИО, школа, год выпуска, факультет, форма обучения, степень.</p>
                            </div>
                            @include('profile.partials.update-alumni-profile-form')
                        </div>
                    @endif

                    {{-- D) Contact Info Block --}}
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 sm:p-8">
                        <div class="border-l-4 border-[#8F161C] pl-4">
                            <h2 class="text-xl font-bold text-[#2B2B2B]">Контактная информация</h2>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- E) Security Block --}}
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 sm:p-8">
                        <div class="border-l-4 border-[#8F161C] pl-4">
                            <h2 class="text-xl font-bold text-[#2B2B2B]">Безопасность</h2>
                            <p class="text-sm text-gray-500 mt-1 mb-6">Измените пароль для защиты аккаунта.</p>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Delete Account --}}
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 sm:p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
