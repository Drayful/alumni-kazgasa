@php
    /** @var \App\Models\AlumniProfile $alumniProfile */
    $isVerified = ($alumniProfile->verification_status ?? null) === 'verified';
    $fullName = $alumniProfile->full_name ?? trim($alumniProfile->last_name . ' ' . $alumniProfile->first_name);
@endphp

@extends('layouts.card-screen')

@section('content')
<div class="min-h-screen bg-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 text-center mb-2">
            Цифровая карта выпускника
        </h1>
        <p class="text-center text-gray-600 mb-6">
            {{ $fullName }}
        </p>

        {{-- Является ли выпускником КазГаса --}}
        <div class="mb-6 text-center px-4 py-3 rounded-xl">
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

        {{-- Карта с QR на ней: сканирование открывает эту же страницу --}}
        <div class="flex justify-center">
            <div class="w-full max-w-xl">
                <x-alumni-card :alumni-profile="$alumniProfile" />
            </div>
        </div>
        <p class="mt-4 text-center text-sm text-gray-500">
            Отсканируйте QR на карте, чтобы открыть эту страницу на другом устройстве.
        </p>
    </div>
</div>
@endsection

