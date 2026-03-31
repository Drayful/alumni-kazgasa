@php
    /** @var \App\Models\AlumniProfile $alumniProfile */
    $isVerified = ($alumniProfile->verification_status ?? null) === 'verified';
@endphp

@extends('layouts.card')

@section('title')
    Карта выпускника — {{ $alumniProfile->full_name }} | KazGASA Alumni
@endsection

@section('content')
<div class="min-h-screen bg-[#F6F2EA] relative">
    <div class="absolute inset-0 opacity-10 pointer-events-none"
         style="background-image: linear-gradient(to right, rgba(0,0,0,0.08) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,0,0,0.08) 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    {{-- TOP LOGO BAR --}}
    <div class="relative bg-[#8F161C] py-4 text-center">
        @if(file_exists(public_path('images/AV-logotip-2.svg')))
            <img src="{{ asset('images/AV-logotip-2.svg') }}" alt="KazGASA" class="h-10 mx-auto">
        @endif
        <p class="text-white font-bold text-lg mt-1">KazGASA Alumni</p>
    </div>

    <div class="relative max-w-sm mx-auto px-4 pb-8">
        {{-- PHOTO --}}
        <div class="flex justify-center mt-6 mb-3">
            <div class="w-24 h-24 rounded-full overflow-hidden ring-4 ring-[#8F161C] ring-offset-2 ring-offset-[#F6F2EA] shadow-lg bg-white">
                <img src="{{ $avatarUrl ?? asset('images/user.png') }}"
                     alt="{{ $alumniProfile->full_name }}"
                     class="w-full h-full object-cover"
                     onerror="this.src='{{ asset('images/user.png') }}'">
            </div>
        </div>

        {{-- VERIFIED BADGE --}}
        @if($isVerified)
            <div class="flex justify-center mb-4">
                <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Карта подтверждена
                </div>
            </div>
        @else
            <div class="flex justify-center mb-4">
                <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-full text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                    </svg>
                    Статус выпускника не подтверждён
                </div>
            </div>
        @endif

        {{-- PHYSICAL CARD REPLICA --}}
        <div class="rounded-2xl overflow-hidden shadow-xl w-full mt-2" style="aspect-ratio: 85.6/53.98;">
            {{-- Top header --}}
            <div class="relative bg-[#8F161C] px-5 py-4"
                 style="background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.03) 0, rgba(255,255,255,0.03) 1px, transparent 0, transparent 50%); background-size: 15px 15px;">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#E5C68D] font-black tracking-wider"
                           style="font-size: 18px; letter-spacing: 2px;">
                            ALUMNI CARD
                        </p>
                        <p class="text-[#E5C68D]/80 font-bold tracking-widest"
                           style="font-size: 13px; letter-spacing: 3px;">
                            KAZGASA
                        </p>
                    </div>
                    @if(file_exists(public_path('images/AV-logotip-2.svg')))
                        <img src="{{ asset('images/AV-logotip-2.svg') }}"
                             class="h-12 w-12 opacity-90"
                             style="filter: brightness(0) invert(1) sepia(1) saturate(2) hue-rotate(5deg) brightness(1.3);">
                    @endif
                </div>
            </div>

            {{-- Middle section --}}
            <div class="bg-[#F6F2EA] relative flex items-center px-5 py-4 overflow-hidden"
                 style="min-height: 100px;">
                <div class="absolute inset-0 opacity-[0.06] flex items-center justify-center pointer-events-none">
                    @if(file_exists(public_path('images/AV-logotip-2.svg')))
                        <img src="{{ asset('images/AV-logotip-2.svg') }}" class="w-32" alt="">
                    @endif
                </div>

                <div class="flex-1 min-w-0 pr-3 relative z-10">
                    <p class="font-black text-[#8F161C] leading-tight break-words"
                       style="font-size: 13px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $alumniProfile->last_name }}<br>
                        {{ $alumniProfile->first_name }}<br>
                        {{ $alumniProfile->middle_name }}
                    </p>
                    <p class="text-[#2B2B2B] mt-1" style="font-size: 10px;">
                        ID number: {{ $alumniProfile->public_id ?? $alumniProfile->id }}
                    </p>
                </div>

                <div class="flex-shrink-0 relative z-10">
                    @if($alumniProfile->public_id)
                        @php
                            $cardUrl = route('alumni.card.show', ['publicId' => $alumniProfile->public_id]);
                            try {
                                $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                                    ->size(100)
                                    ->margin(0)
                                    ->color(107, 33, 31)
                                    ->backgroundColor(255, 255, 255)
                                    ->generate($cardUrl);
                            } catch (\Throwable $e) {
                                $qrSvg = null;
                            }
                        @endphp
                        @if(!empty($qrSvg))
                            <div class="w-16 h-16">
                                {!! preg_replace(
                                    '/<rect\b[^>]*\bfill\s*=\s*["\']?\s*(?:#fff(?:fff)?|white)["\']?[^>]*>/i',
                                    '',
                                    preg_replace('/<svg/', '<svg width="100%" height="100%"', $qrSvg, 1)
                                ) !!}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Bottom footer --}}
            <div class="bg-[#8F161C] px-5 py-2 text-center">
                <p class="text-[#E5C68D] font-bold tracking-widest uppercase"
                   style="font-size: 9px; letter-spacing: 2px;">
                    BUILD THE FUTURE WITH US!
                </p>
            </div>
        </div>

        {{-- INFO SECTION --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mt-6">
            <h2 class="font-bold text-[#2B2B2B] text-lg border-l-4 border-[#8F161C] pl-3 mb-4">
                Информация о выпускнике
            </h2>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between gap-4 py-2 border-b border-[#D9D9D9]">
                    <span class="text-xs text-gray-400 uppercase tracking-wide">ФИО</span>
                    <span class="text-sm font-semibold text-[#2B2B2B] text-right">
                        {{ $alumniProfile->full_name }}
                    </span>
                </div>

                @if($alumniProfile->graduation_year)
                    <div class="flex justify-between gap-4 py-2 border-b border-[#D9D9D9]">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Год выпуска</span>
                        <span class="text-sm font-semibold text-[#2B2B2B]">
                            {{ $alumniProfile->graduation_year }}
                        </span>
                    </div>
                @endif

                @if($alumniProfile->school || $alumniProfile->faculty_name)
                    <div class="flex justify-between gap-4 py-2 border-b border-[#D9D9D9]">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Школа / Факультет</span>
                        <span class="text-sm font-semibold text-[#2B2B2B] text-right">
                            {{ $alumniProfile->school }} {{ $alumniProfile->faculty_name }}
                        </span>
                    </div>
                @endif

                @if($alumniProfile->edu_op_name || $alumniProfile->edu_program_name)
                    <div class="flex justify-between gap-4 py-2 border-b border-[#D9D9D9]">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Специальность</span>
                        <span class="text-sm font-semibold text-[#2B2B2B] text-right">
                            {{ $alumniProfile->edu_op_name ?? $alumniProfile->specialty }}
                            @if($alumniProfile->edu_program_name)
                                <br>{{ $alumniProfile->edu_program_name }}
                            @endif
                        </span>
                    </div>
                @endif

                @if($alumniProfile->study_level_name || $alumniProfile->degree)
                    <div class="flex justify-between gap-4 py-2 border-b border-[#D9D9D9]">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Степень</span>
                        <span class="text-sm font-semibold text-[#2B2B2B] text-right">
                            {{ $alumniProfile->study_level_name ?? $alumniProfile->degree }}
                        </span>
                    </div>
                @endif

                <div class="flex justify-between gap-4 py-2">
                    <span class="text-xs text-gray-400 uppercase tracking-wide">Статус карты</span>
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
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $pillClass }}">
                        {{ $status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- VALIDITY SECTION --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mt-4">
            @if($alumniProfile->membership_expiry_date)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Действительна до</span>
                    <span class="font-semibold text-[#2B2B2B] text-sm">
                        {{ $alumniProfile->membership_expiry_date->format('d.m.Y') }}
                    </span>
                </div>
            @else
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Бессрочная карта выпускника
                </div>
            @endif
        </div>

        {{-- FOOTER NOTE --}}
        <p class="text-xs text-gray-400 text-center mt-8">
            Эта страница подтверждает подлинность карты выпускника KazGASA.<br>
            <a href="https://alumni.kazgasa.kz" class="text-[#8F161C] hover:underline">
                alumni.kazgasa.kz
            </a>
        </p>
    </div>
</div>
@endsection

