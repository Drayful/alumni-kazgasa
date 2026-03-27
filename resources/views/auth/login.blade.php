<x-guest-layout>
    @include('auth.partials.phone-mask-alpine')

    {{-- LEFT PANEL (desktop only) --}}
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#8F161C] min-h-screen flex-col items-center justify-center px-8 overflow-hidden">
        <div class="absolute inset-0 opacity-10" aria-hidden="true"
             style="background-image: linear-gradient(to right, rgba(255,255,255,0.2) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative z-10 flex flex-col items-center text-center">
            <img src="{{ asset('images/AV-logotip-2.svg') }}" alt="KazGASA" class="w-24 h-24 mb-6 brightness-0 invert" />
            <h1 class="text-4xl font-bold text-white">KazGASA Alumni</h1>
            <p class="text-[#E5C68D] text-lg mt-2">Платформа выпускников КазГАСА / ААСИ / КазПТИ</p>
            <div class="w-16 h-1 bg-[#E5C68D] my-8" aria-hidden="true"></div>

            <ul class="space-y-4 text-white text-left">
                <li class="flex items-center gap-3">
                    <span class="text-[#E5C68D]">✦</span>
                    <span>Цифровая карта выпускника</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-[#E5C68D]">✦</span>
                    <span>Заказ документов онлайн</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-[#E5C68D]">✦</span>
                    <span>Партнёрские льготы</span>
                </li>
            </ul>
        </div>

        <p class="absolute bottom-8 left-0 right-0 text-center text-[#E5C68D]/70 text-sm">Построй будущее вместе с нами</p>
    </div>

    {{-- RIGHT PANEL (form) --}}
    <div class="w-full lg:w-1/2 min-h-screen bg-[#F6F2EA] flex flex-col items-center justify-center p-4 sm:p-6 lg:p-10">
        <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 max-w-md w-full mx-auto">
            <p class="text-xs tracking-widest text-[#8F161C] uppercase mb-2">ВХОД В СИСТЕМУ</p>
            <h2 class="text-2xl font-bold text-[#2B2B2B]">С возвращением!</h2>
            <p class="text-sm text-gray-500 mb-8">Войдите в свой аккаунт выпускника</p>

            {{-- Session / validation errors --}}
            @if ($errors->any())
                <div class="bg-[#F6F2EA] border-l-4 border-[#8F161C] text-[#5E0F14] rounded p-3 text-sm mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <x-auth-session-status class="mb-6 bg-[#F6F2EA] border-l-4 border-[#8F161C] text-[#5E0F14] rounded p-3 text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div x-data="loginEmailOrPhone(@js(old('login')))">
                    <label for="login_display" class="block text-sm font-medium text-[#2B2B2B] mb-1">Email или телефон</label>
                    <input id="login_display" type="text" inputmode="text"
                           :value="display"
                           @input="onInput($event)"
                           placeholder="your@email.com или +7 (___) ___-__-__" autofocus autocomplete="username"
                           class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] placeholder-gray-400 focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                    <input type="hidden" name="login" :value="loginValue" />
                    <p class="text-xs text-gray-400 mt-1">Телефон: маска +7, как при регистрации. Email — введите адрес с буквами или @.</p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-[#2B2B2B]">Пароль</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-[#8F161C] hover:text-[#5E0F14] transition-colors">Забыли пароль?</a>
                        @endif
                    </div>
                    <div class="relative" x-data="{ show: false }">
                        <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                               class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 pr-12 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-500 hover:text-[#8F161C] focus:outline-none focus:ring-2 focus:ring-[#8F161C] rounded" tabindex="-1" aria-label="Показать пароль">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878a4.5 4.5 0 106.262 6.262M3 3l3 3m15 15l-3-3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-[#D9D9D9] text-[#8F161C] focus:ring-[#8F161C] accent-[#8F161C]" />
                    <label for="remember_me" class="ms-2 text-sm text-[#2B2B2B]">Запомнить меня</label>
                </div>

                <button type="submit" class="w-full bg-[#8F161C] text-white py-3 rounded-lg font-semibold uppercase tracking-wider text-sm hover:bg-[#5E0F14] transition-colors duration-200 active:scale-95">
                    ВОЙТИ
                </button>
            </form>

            <div class="flex items-center gap-4 mt-8">
                <span class="flex-1 h-px bg-[#D9D9D9]" aria-hidden="true"></span>
                <span class="text-sm text-gray-400">или</span>
                <span class="flex-1 h-px bg-[#D9D9D9]" aria-hidden="true"></span>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                Ещё нет аккаунта?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="font-semibold text-[#8F161C] hover:text-[#5E0F14] hover:underline transition-colors">Зарегистрироваться</a>
                @endif
            </p>
        </div>
    </div>
</x-guest-layout>
