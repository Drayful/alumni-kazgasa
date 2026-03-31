<x-app-layout>
    {{-- PAGE HEADER --}}
    <div class="bg-[#8F161C] py-10 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5"
             style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[#E5C68D] text-xs tracking-widest uppercase mb-1">
                KazGASA Alumni
            </p>
            <h1 class="text-white font-bold text-3xl sm:text-4xl">
                Вакансии для выпускников
            </h1>
            <p class="text-white/70 mt-2 text-sm">
                Актуальные предложения от партнёров KazGASA
            </p>
        </div>
    </div>

    {{-- BREADCRUMB --}}
    <div class="bg-white border-b border-[#D9D9D9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm">
            <a href="{{ url('/') }}" class="text-[#8F161C] hover:underline">Главная</a>
            <span class="text-[#C56A6E] mx-2">→</span>
            <span class="text-[#2B2B2B]">Вакансии</span>
        </div>
    </div>

    {{-- JOBS GRID --}}
    <div class="bg-[#F6F2EA] min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-sm text-[#2B2B2B]/60 mb-6">
                Найдено вакансий:
                <span class="font-semibold text-[#8F161C]">{{ $jobs->count() }}</span>
            </p>

            @if($jobs->isEmpty())
                <div class="bg-white rounded-2xl p-12 text-center shadow-sm">
                    <p class="text-4xl mb-4">💼</p>
                    <p class="text-[#2B2B2B] font-semibold text-lg">Вакансий пока нет</p>
                    <p class="text-gray-400 text-sm mt-1">Загляните позже — мы обновляем список регулярно</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col group">
                            <div class="h-1.5 bg-gradient-to-r from-[#8F161C] to-[#E5C68D]"></div>

                            <div class="p-6 flex flex-col flex-1">
                                <div class="flex items-center gap-3 mb-4">
                                    @if($job->company_logo_path)
                                        <img src="{{ $job->company_logo_path }}"
                                             alt="{{ $job->company_name }}"
                                             class="w-12 h-12 rounded-lg object-contain border border-[#D9D9D9] p-1">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-[#F6F2EA] flex items-center justify-center border border-[#D9D9D9]">
                                            <span class="text-[#8F161C] font-bold text-lg">
                                                {{ mb_substr($job->company_name ?? 'K', 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[#2B2B2B] text-sm truncate">
                                            {{ $job->company_name ?? 'Компания' }}
                                        </p>
                                        @if($job->address)
                                            <p class="text-xs text-gray-400 truncate">
                                                📍 {{ $job->address }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <h3 class="font-bold text-[#2B2B2B] text-base leading-snug mb-3 group-hover:text-[#8F161C] transition-colors line-clamp-2">
                                    {{ $job->position_name }}
                                </h3>

                                @if($job->salary)
                                    <p class="text-[#8F161C] font-semibold text-sm mb-3">
                                        💰 {{ $job->salary }}
                                    </p>
                                @endif

                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($job->employment_type_name)
                                        <span class="px-2 py-1 bg-[#F6F2EA] text-[#5E0F14] text-xs rounded-full border border-[#E5C68D]">
                                            {{ $job->employment_type_name }}
                                        </span>
                                    @endif
                                    @if($job->end_date)
                                        <span class="px-2 py-1 bg-[#F6F2EA] text-gray-500 text-xs rounded-full border border-[#D9D9D9]">
                                            до {{ \Carbon\Carbon::parse($job->end_date)->format('d.m.Y') }}
                                        </span>
                                    @endif
                                </div>

                                @if($job->company_description)
                                    <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">
                                        {{ strip_tags($job->company_description) }}
                                    </p>
                                @else
                                    <div class="flex-1"></div>
                                @endif

                                <div class="flex items-center justify-between pt-4 border-t border-[#D9D9D9] mt-auto">
                                    <span class="text-xs text-gray-400">
                                        👥 {{ $job->responses_count }} откликов
                                    </span>
                                    <a href="{{ route('jobs.show', $job->id) }}"
                                       class="bg-[#8F161C] text-white px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wide hover:bg-[#5E0F14] transition-colors active:scale-95">
                                        Подробнее →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

