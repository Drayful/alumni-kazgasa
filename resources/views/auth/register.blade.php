<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Регистрация выпускника KazGASA</h2>
            <p class="text-sm text-gray-600 mt-2">Создайте аккаунт для получения цифровой карты</p>
        </div>

        <!-- ИИН -->
        <div class="mt-4">
            <x-input-label for="iin" value="ИИН *" />
            <x-text-input id="iin" class="block mt-1 w-full" type="text" name="iin"
                          :value="old('iin')" required maxlength="12" placeholder="000000000000" />
            <x-input-error :messages="$errors->get('iin')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">12 цифр вашего ИИН</p>
        </div>

        <!-- Фамилия -->
        <div class="mt-4">
            <x-input-label for="last_name" value="Фамилия *" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                          :value="old('last_name')" required />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Имя -->
        <div class="mt-4">
            <x-input-label for="first_name" value="Имя *" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                          :value="old('first_name')" required />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Отчество -->
        <div class="mt-4">
            <x-input-label for="middle_name" value="Отчество" />
            <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name"
                          :value="old('middle_name')" />
            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email *" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Телефон -->
        <div class="mt-4">
            <x-input-label for="phone" value="Телефон" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                          :value="old('phone')" placeholder="+7 (7XX) XXX-XX-XX" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Год выпуска -->
        <div class="mt-4">
            <x-input-label for="graduation_year" value="Год выпуска *" />
            <select id="graduation_year" name="graduation_year"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                <option value="">Выберите год</option>
                @for($year = date('Y'); $year >= 1990; $year--)
                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>
            <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
        </div>

        <!-- Школа -->
        <div class="mt-4">
            <x-input-label for="school" value="Школа/Факультет *" />
            <select id="school" name="school"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                <option value="">Выберите школу</option>
                <option value="ШИ" {{ old('school') == 'ШИ' ? 'selected' : '' }}>Школа Инженерии (ШИ)</option>
                <option value="ША" {{ old('school') == 'ША' ? 'selected' : '' }}>Школа Архитектуры (ША)</option>
                <option value="ШС" {{ old('school') == 'ШС' ? 'selected' : '' }}>Школа Строительства (ШС)</option>
                <option value="ШД" {{ old('school') == 'ШД' ? 'selected' : '' }}>Школа Дизайна (ШД)</option>
                <option value="КАУ" {{ old('school') == 'КАУ' ? 'selected' : '' }}>Казахско-Американский университет (КАУ)</option>
            </select>
            <x-input-error :messages="$errors->get('school')" class="mt-2" />
        </div>

        <!-- Пароль -->
        <div class="mt-4">
            <x-input-label for="password" value="Пароль *" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Подтверждение пароля -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Подтвердите пароль *" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}">
                Уже зарегистрированы?
            </a>

            <x-primary-button class="ms-4">
                Зарегистрироваться
            </x-primary-button>
        </div>

        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-xs text-blue-800">
                По году выпуска и ИИН мы проверяем данные в iPortal. При совпадении подтянутся группа, форма обучения, факультет, ОП и ГОП. Если данных нет — поля можно заполнить или изменить в профиле после регистрации.
            </p>
        </div>
    </form>
</x-guest-layout>
