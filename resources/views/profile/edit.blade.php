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
                    @if ($alumniProfile)
                        {{-- PHOTO BLOCK --}}
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-[#8F161C] ring-offset-2 ring-offset-white bg-[#F6F2EA]">
                                    <img src="{{ $alumniProfile->avatar_url }}"
                                         alt="{{ $alumniProfile->full_name }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='{{ asset('images/user.png') }}'">
                                </div>

                                <div class="mt-3 text-[#2B2B2B] font-bold text-lg">{{ $alumniProfile->full_name }}</div>

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
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium {{ $pillClass }}">{{ $status }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <p class="text-xs uppercase tracking-widest text-[#8F161C] mb-4 text-center">Фотография профиля</p>

                                <form action="{{ route('profile.photo.update') }}"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      x-data="photoUpload()"
                                      class="w-full">
                                    @csrf

                                    <input type="file"
                                           x-ref="fileInput"
                                           id="photo_input"
                                           name="photo"
                                           accept="image/jpeg,image/png,image/webp"
                                           class="hidden"
                                           @change="previewPhoto($event)">

                                    <div x-show="preview" x-cloak class="mb-4 flex justify-center">
                                        <img :src="preview"
                                             class="w-24 h-24 rounded-full object-cover ring-2 ring-[#E5C68D]"
                                             alt="Предпросмотр">
                                    </div>

                                    <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                        <button type="button"
                                                class="border-2 border-[#8F161C] text-[#8F161C] px-4 py-2 rounded-lg text-sm hover:bg-[#8F161C] hover:text-white transition"
                                                @click="$refs.fileInput.click()">
                                            Выбрать фото
                                        </button>
                                        <button type="submit"
                                                x-show="preview"
                                                x-cloak
                                                class="bg-[#8F161C] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#5E0F14] transition">
                                            Сохранить
                                        </button>
                                    </div>

                                    <p class="text-xs text-gray-400 mt-2 text-center">JPEG, PNG или WebP. Максимум 2MB.</p>
                                </form>

                                @if($alumniProfile->photo_path)
                                    <form action="{{ route('profile.photo.destroy') }}" method="POST" class="mt-3 text-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Удалить свою фотографию?')"
                                                class="text-xs text-[#C56A6E] hover:text-[#8F161C] hover:underline transition">
                                            Удалить фото и вернуть из системы
                                        </button>
                                    </form>
                                @endif

                                @if(session('photo_success'))
                                    <div class="mt-3 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-3 py-2 text-center">
                                        ✓ {{ session('photo_success') }}
                                    </div>
                                @endif

                                @error('photo')
                                    <div class="mt-3 text-sm text-[#C56A6E] text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- A) Digital Card Block --}}
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                            <p class="text-[#8F161C] text-xs font-medium tracking-widest uppercase mb-4">ЦИФРОВАЯ КАРТА ВЫПУСКНИКА</p>
                            <x-alumni-card :alumni-profile="$alumniProfile" />
                            <p class="mt-4 text-sm text-gray-500 italic">Покажите эту карту на экране телефона — она привязана к вашему профилю выпускника.</p>
                        </div>

                        {{-- B) Status Block --}}
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                            <h3 class="text-[#2B2B2B] font-semibold mb-4">Статус карты</h3>
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

    <script>
        function photoUpload() {
            return {
                preview: null,
                previewPhoto(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    if (file.size > 2 * 1024 * 1024) {
                        alert('Файл слишком большой. Максимум 2MB.');
                        event.target.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => { this.preview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</x-app-layout>
