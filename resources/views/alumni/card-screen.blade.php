@php
    /** @var \App\Models\AlumniProfile $alumniProfile */
@endphp

<x-guest-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 text-center">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
                Цифровая карта выпускника
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                {{ $alumniProfile->full_name ?? ($alumniProfile->last_name . ' ' . $alumniProfile->first_name) }}
            </p>
        </div>

        <div class="bg-white shadow-xl rounded-2xl p-4 sm:p-6 flex flex-col lg:flex-row items-center lg:items-stretch gap-6">
            {{-- Сама карта --}}
            <div class="flex-1 flex justify-center">
                <div class="w-full max-w-2xl">
                    <x-alumni-card :alumni-profile="$alumniProfile" />
                </div>
            </div>

            {{-- QR-код к этой же карте --}}
            <div class="w-full lg:w-72 flex flex-col items-center justify-center">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                    <div class="text-xs text-gray-600 text-center mb-2">
                        Покажите этот QR, чтобы открыть вашу карту на другом устройстве.
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
</x-guest-layout>

