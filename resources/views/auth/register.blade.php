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
                    <span>Подтверждение через базу iPortal</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-[#E5C68D]">✦</span>
                    <span>Автоматическая цифровая карта</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-[#E5C68D]">✦</span>
                    <span>Доступ к партнёрским льготам</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-[#E5C68D]">✦</span>
                    <span>Заказ официальных документов</span>
                </li>
            </ul>
        </div>

        <a href="{{ route('login') }}" class="absolute bottom-8 left-0 right-0 text-center text-[#E5C68D] hover:text-[#E5C68D]/90 text-sm transition-colors">Уже зарегистрированы? Войти →</a>
    </div>

    {{-- RIGHT PANEL (form) --}}
    <div class="w-full lg:w-1/2 min-h-screen bg-[#F6F2EA] flex flex-col items-center justify-center p-4 sm:p-6 lg:p-10">
        <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 max-w-lg w-full mx-auto">
            <p class="text-xs tracking-widest text-[#8F161C] uppercase mb-2">РЕГИСТРАЦИЯ</p>
            <h2 class="text-2xl font-bold text-[#2B2B2B]">Создайте аккаунт выпускника</h2>
            <p class="text-sm text-gray-500 mb-6">Заполните данные для верификации в системе КазГАСА</p>

            {{-- Global errors --}}
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

            {{-- Info banner --}}
            <div class="bg-[#F6F2EA] border border-[#E5C68D] rounded-lg p-4 mb-6 flex gap-3">
                <span class="text-[#8F161C] font-bold text-lg leading-none shrink-0" aria-hidden="true">ⓘ</span>
                <p class="text-sm text-[#2B2B2B]">Для выпускников с 2023 года данные проверяются автоматически через iPortal. Для более ранних выпусков — ручная проверка 2-3 дня.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                {{-- SECTION 1: Персональные данные --}}
                <div class="border-b border-[#D9D9D9] pb-4">
                    <h3 class="text-xs uppercase tracking-wider text-[#8F161C] border-b border-[#D9D9D9] pb-2 mb-4">Персональные данные</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-[#2B2B2B] mb-1">Фамилия</label>
                            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                                   class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                            @error('last_name')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-[#2B2B2B] mb-1">Имя</label>
                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required
                                   class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                            @error('first_name')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="middle_name" class="block text-sm font-medium text-[#2B2B2B] mb-1">Отчество</label>
                        <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="необязательно"
                               class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] placeholder-gray-400 focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                        @error('middle_name')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- SECTION 2: Данные об обучении --}}
                <div class="border-b border-[#D9D9D9] pb-4">
                    <h3 class="text-xs uppercase tracking-wider text-[#8F161C] border-b border-[#D9D9D9] pb-2 mb-4">Данные об обучении</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="school" class="block text-sm font-medium text-[#2B2B2B] mb-1">Школа/Факультет</label>
                            <select id="school" name="school" required
                                    class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150 appearance-none bg-no-repeat bg-[length:1rem] bg-[right_0.5rem_center]"
                                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%232B2B2B%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27M6 8l4 4 4-4%27/%3E%3C/svg%3E');">
                                <option value="">Выберите школу</option>
                                <option value="ШИ" {{ old('school') == 'ШИ' ? 'selected' : '' }}>Школа Инженерии (ШИ)</option>
                                <option value="ША" {{ old('school') == 'ША' ? 'selected' : '' }}>Школа Архитектуры (ША)</option>
                                <option value="ШС" {{ old('school') == 'ШС' ? 'selected' : '' }}>Школа Строительства (ШС)</option>
                                <option value="ШД" {{ old('school') == 'ШД' ? 'selected' : '' }}>Школа Дизайна (ШД)</option>
                                <option value="КАУ" {{ old('school') == 'КАУ' ? 'selected' : '' }}>Казахско-Американский университет (КАУ)</option>
                            </select>
                            @error('school')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="graduation_year" class="block text-sm font-medium text-[#2B2B2B] mb-1">Год выпуска</label>
                            <select id="graduation_year" name="graduation_year" required
                                    class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150 appearance-none bg-no-repeat bg-[length:1rem] bg-[right_0.5rem_center]"
                                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%232B2B2B%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27M6 8l4 4 4-4%27/%3E%3C/svg%3E');">
                                <option value="">Выберите год</option>
                                @for($year = date('Y'); $year >= 1990; $year--)
                                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                            @error('graduation_year')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center gap-2 mb-1">
                            <label for="iin" class="block text-sm font-medium text-[#2B2B2B]">ИИН</label>
                            <span class="bg-[#8F161C] text-white text-xs px-2 py-0.5 rounded">Обязательно</span>
                        </div>
                        <input id="iin" type="text" name="iin" value="{{ old('iin') }}" required maxlength="12" pattern="[0-9]{12}" inputmode="numeric" placeholder="000000000000"
                               class="block w-full rounded-lg border-2 border-[#8F161C] px-4 py-3 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                        <p class="text-xs text-gray-400 mt-1">12 цифр вашего ИИН — используется для верификации</p>
                        @error('iin')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- SECTION 3: Данные для входа --}}
                <div>
                    <h3 class="text-xs uppercase tracking-wider text-[#8F161C] border-b border-[#D9D9D9] pb-2 mb-4">Данные для входа</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-[#2B2B2B] mb-1">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                   class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                            @error('email')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div x-data="registerPhoneMask(@js(old('phone')))">
                            <div class="flex items-center gap-2 mb-1">
                                <label for="phone_display" class="block text-sm font-medium text-[#2B2B2B]">Телефон</label>
                                <span class="bg-[#8F161C] text-white text-xs px-2 py-0.5 rounded">Обязательно</span>
                            </div>
                            <input id="phone_display" type="tel" inputmode="numeric" autocomplete="tel"
                                   :value="display"
                                   @input="onInput($event)"
                                   placeholder="+7 (___) ___-__-__"
                                   class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] placeholder-gray-400 focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                            <input type="hidden" name="phone" :value="phoneCanon" />
                            <p class="text-xs text-gray-400 mt-1">+7 фиксирован; введите 10 цифр номера (как на телефоне после +7).</p>
                            @error('phone')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4" x-data="{ show: false }">
                        <div>
                            <label for="password" class="block text-sm font-medium text-[#2B2B2B] mb-1">Пароль</label>
                            <div class="relative">
                                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                       class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 pr-12 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                                <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-500 hover:text-[#8F161C] focus:outline-none rounded" tabindex="-1" aria-label="Показать пароль">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878a4.5 4.5 0 106.262 6.262M3 3l3 3m15 15l-3-3" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-[#2B2B2B] mb-1">Подтвердите пароль</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="block w-full rounded-lg border border-[#D9D9D9] px-4 py-3 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] transition duration-150" />
                            @error('password_confirmation')<p class="text-[#C56A6E] text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#8F161C] text-white py-3.5 rounded-lg font-semibold uppercase tracking-wider text-sm hover:bg-[#5E0F14] transition-colors duration-200 active:scale-95">
                    ЗАРЕГИСТРИРОВАТЬСЯ
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Уже есть аккаунт?
                <a href="{{ route('login') }}" class="font-semibold text-[#8F161C] hover:text-[#5E0F14] hover:underline transition-colors">Войти</a>
            </p>
        </div>
    </div>
</x-guest-layout>
