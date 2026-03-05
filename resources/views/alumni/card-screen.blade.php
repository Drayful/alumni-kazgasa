@php
    /** @var \App\Models\AlumniProfile $alumniProfile */
    $isVerified = ($alumniProfile->verification_status ?? null) === 'verified';
@endphp

@extends('layouts.card-screen')

@section('content')
<div class="min-h-screen bg-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 text-center">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
                Цифровая карта выпускника
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                {{ $alumniProfile->full_name ?? ($alumniProfile->last_name . ' ' . $alumniProfile->first_name) }}
            </p>
        </div>

        {{-- Статус верификации: зелёный если verified, красный если нет --}}
        <div class="mb-6 text-center">
            @if ($isVerified)
                <p class="text-base sm:text-lg font-semibold text-green-600">
                    Данный пользователь является выпускником КазГаса.
                </p>
            @else
                <p class="text-base sm:text-lg font-semibold text-red-600">
                    Данный пользователь не является выпускником КазГаса.
                </p>
            @endif
        </div>

        <div class="bg-white shadow-xl rounded-2xl p-4 sm:p-6 flex flex-col lg:flex-row items-center lg:items-stretch gap-6">
            {{-- Карта --}}
            <div class="flex-1 flex justify-center">
                <div class="w-full max-w-2xl">
                    <x-alumni-card :alumni-profile="$alumniProfile" />
                </div>
            </div>

            {{-- QR-код --}}
            <div class="w-full lg:w-72 flex flex-col items-center justify-center">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                    <div class="text-xs text-gray-600 text-center mb-2">
                        Отсканируйте QR, чтобы открыть карту.
                    </div>
                    <div class="bg-white p-2 rounded">
                        {!! $qrSvg !!}
                    </div>
                </div>
                <p class="mt-3 text-[11px] text-gray-500 text-center break-all">
                    {{ $cardUrl }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

