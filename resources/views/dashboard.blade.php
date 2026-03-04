<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Личный кабинет') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Левое меню -->
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <nav class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 space-y-1">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700 text-sm font-semibold">
                                LK
                            </span>
                            <span>Главная</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-sky-100 text-sky-700 text-sm font-semibold">
                                PR
                            </span>
                            <span>Профиль</span>
                        </a>

                        {{-- Здесь можно добавить другие пункты меню, если появятся разделы --}}
                    </nav>
                </aside>

                <!-- Контент -->
                <section class="flex-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Добро пожаловать, {{ auth()->user()->name }}!
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Это ваш личный кабинет выпускника KazGASA.
                        </p>

                        <div class="mt-6 rounded-xl bg-indigo-50 px-4 py-3 text-sm text-indigo-900">
                            Цифровая карта выпускника доступна в разделе
                            <a href="{{ route('profile.edit') }}" class="font-semibold underline hover:no-underline">
                                «Профиль»
                            </a>.
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
