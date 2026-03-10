<x-app-layout>
    <x-slot name="breadcrumb">
        <nav class="flex text-sm">
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-[#8F161C] transition-colors">Главная</a>
            <span class="mx-2 text-[#C56A6E]">→</span>
            <span class="text-[#8F161C] font-medium">Личный кабинет</span>
        </nav>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <nav class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-[#D9D9D9] p-4 space-y-1">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-[#F6F2EA] text-[#8F161C]' : 'text-[#2B2B2B] hover:bg-[#F6F2EA] hover:text-[#8F161C]' }}">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-[#E5C68D]/30 text-[#5E0F14] text-sm font-semibold">LK</span>
                            <span>Главная</span>
                        </a>
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('profile.*') ? 'bg-[#F6F2EA] text-[#8F161C]' : 'text-[#2B2B2B] hover:bg-[#F6F2EA] hover:text-[#8F161C]' }}">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-[#8F161C]/20 text-[#8F161C] text-sm font-semibold">PR</span>
                            <span>Профиль</span>
                        </a>
                    </nav>
                </aside>

                <section class="flex-1">
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-[#D9D9D9] p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-[#2B2B2B]">
                            Добро пожаловать, {{ auth()->user()->name }}!
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Это ваш личный кабинет выпускника KazGASA.
                        </p>
                        <div class="mt-6 rounded-xl bg-[#F6F2EA] border border-[#D9D9D9] px-4 py-3 text-sm text-[#2B2B2B]">
                            Цифровая карта выпускника доступна в разделе
                            <a href="{{ route('profile.edit') }}" class="font-semibold text-[#8F161C] hover:text-[#5E0F14] underline hover:no-underline">
                                «Профиль»
                            </a>.
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
