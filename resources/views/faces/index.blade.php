@extends('layouts.home')

@section('title', 'Лица KazGASA')

@section('content')
    <div class="min-h-screen" style="background-color: #F6F2EA;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="text-[#8F161C] text-xs uppercase tracking-widest mb-2 font-semibold">Гордость университета</p>
                    <h1 class="text-[#2B2B2B] font-bold text-2xl sm:text-3xl">
                        Лица KazGASA
                    </h1>
                    <p class="text-sm text-gray-600 mt-2 max-w-3xl">
                        Министры, депутаты, предприниматели, архитекторы — выпускники и представители KazGASA.
                    </p>
                </div>

                <a href="{{ url('/') }}#faces"
                   class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold border-2 transition"
                   style="border-color: #8F161C; color: #8F161C; background-color: #FFFFFF;">
                    ← На главную
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($faces as $f)
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-transparent hover:border-[#E5C68D] hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-[#2B2B2B] font-bold text-base leading-snug break-words">
                                    {{ $f['name'] }}
                                </p>
                                <p class="text-[#8F161C] text-xs font-semibold mt-1 uppercase tracking-wide">
                                    {{ $f['subtitle'] }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                 style="background-color: #F6F2EA; color: #8F161C;">
                                🎓
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $f['role'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

