<x-app-layout>
    {{-- HEADER --}}
    <div class="bg-[#8F161C] py-10 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5"
             style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;">
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[#E5C68D] text-xs tracking-widest uppercase mb-1">Вакансия</p>
            <h1 class="text-white font-bold text-2xl sm:text-3xl leading-snug">
                {{ $job->position_name }}
            </h1>
            <p class="text-white/70 mt-1 text-sm">{{ $job->company_name }}</p>
        </div>
    </div>

    {{-- BREADCRUMB --}}
    <div class="bg-white border-b border-[#D9D9D9]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm">
            <a href="{{ url('/') }}" class="text-[#8F161C] hover:underline">Главная</a>
            <span class="text-[#C56A6E] mx-2">→</span>
            <a href="{{ route('jobs.index') }}" class="text-[#8F161C] hover:underline">Вакансии</a>
            <span class="text-[#C56A6E] mx-2">→</span>
            <span class="text-[#2B2B2B] truncate">{{ \Illuminate\Support\Str::limit($job->position_name, 40) }}</span>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="bg-[#F6F2EA] min-h-screen py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- LEFT: Main info --}}
                <div class="lg:col-span-2 space-y-6">
                    @if($job->company_description)
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h2 class="font-bold text-[#2B2B2B] text-lg mb-4 border-l-4 border-[#8F161C] pl-3">
                                О компании
                            </h2>
                            <p class="text-[#2B2B2B] text-sm leading-relaxed whitespace-pre-line">
                                {{ $job->company_description }}
                            </p>
                        </div>
                    @endif

                    @if($job->responsibilities)
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h2 class="font-bold text-[#2B2B2B] text-lg mb-4 border-l-4 border-[#8F161C] pl-3">
                                Обязанности
                            </h2>
                            <div class="text-[#2B2B2B] text-sm leading-relaxed whitespace-pre-line">
                                {{ $job->responsibilities }}
                            </div>
                        </div>
                    @endif

                    @if($job->requirements)
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h2 class="font-bold text-[#2B2B2B] text-lg mb-4 border-l-4 border-[#8F161C] pl-3">
                                Требования
                            </h2>
                            <div class="text-[#2B2B2B] text-sm leading-relaxed whitespace-pre-line">
                                {{ $job->requirements }}
                            </div>
                        </div>
                    @endif

                    @if($job->conditions)
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h2 class="font-bold text-[#2B2B2B] text-lg mb-4 border-l-4 border-[#8F161C] pl-3">
                                Условия работы
                            </h2>
                            <div class="text-[#2B2B2B] text-sm leading-relaxed whitespace-pre-line">
                                {{ $job->conditions }}
                            </div>
                        </div>
                    @endif
                </div>

                {{-- RIGHT: Sidebar --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex justify-center mb-4">
                            @if($job->company_logo_path)
                                <img src="{{ $job->company_logo_path }}"
                                     alt="{{ $job->company_name }}"
                                     class="h-16 object-contain">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-[#F6F2EA] flex items-center justify-center border border-[#D9D9D9]">
                                    <span class="text-[#8F161C] font-bold text-2xl">
                                        {{ mb_substr($job->company_name ?? 'K', 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <h3 class="font-bold text-[#2B2B2B] text-center mb-4">
                            {{ $job->company_name }}
                        </h3>

                        <div class="space-y-3 text-sm">
                            @if($job->salary)
                                <div class="flex items-start gap-2">
                                    <span>💰</span>
                                    <div>
                                        <p class="text-gray-400 text-xs">Зарплата</p>
                                        <p class="font-semibold text-[#8F161C]">{{ $job->salary }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($job->employment_type_name)
                                <div class="flex items-start gap-2">
                                    <span>📋</span>
                                    <div>
                                        <p class="text-gray-400 text-xs">Тип занятости</p>
                                        <p class="font-medium text-[#2B2B2B]">{{ $job->employment_type_name }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($job->address)
                                <div class="flex items-start gap-2">
                                    <span>📍</span>
                                    <div>
                                        <p class="text-gray-400 text-xs">Адрес</p>
                                        <p class="font-medium text-[#2B2B2B]">{{ $job->address }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($job->end_date)
                                <div class="flex items-start gap-2">
                                    <span>📅</span>
                                    <div>
                                        <p class="text-gray-400 text-xs">Дедлайн</p>
                                        <p class="font-medium text-[#2B2B2B]">{{ \Carbon\Carbon::parse($job->end_date)->format('d.m.Y') }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-start gap-2">
                                <span>👥</span>
                                <div>
                                    <p class="text-gray-400 text-xs">Откликов</p>
                                    <p class="font-medium text-[#2B2B2B]">{{ $job->responses_count }}</p>
                                </div>
                            </div>
                        </div>

                        @if($job->contacts)
                            <div class="mt-4 pt-4 border-t border-[#D9D9D9]">
                                <p class="text-xs text-gray-400 mb-1">Контакты</p>
                                <p class="text-sm text-[#2B2B2B] break-words">{{ $job->contacts }}</p>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('jobs.index') }}"
                       class="block w-full text-center border-2 border-[#8F161C] text-[#8F161C] py-3 rounded-xl font-semibold text-sm hover:bg-[#8F161C] hover:text-white transition-colors">
                        ← Все вакансии
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

