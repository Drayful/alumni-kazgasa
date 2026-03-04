@props(['alumniProfile' => null, 'variant' => 'profile'])

@php
    /** @var \App\Models\AlumniProfile|null $alumniProfile */
    $name = $alumniProfile?->full_name ?? auth()->user()->name;
    $idDisplay = $alumniProfile?->public_id
        ?? str_pad((string) ($alumniProfile?->id ?? auth()->id()), 6, '0', STR_PAD_LEFT);
    $isDashboard = $variant === 'dashboard';
@endphp

{{-- Фон берём из фоновой картинки, текст и ID рисуем поверх --}}
<div class="relative w-full max-w-xl overflow-hidden rounded-xl shadow-xl"
     style="
        aspect-ratio: 1.6;
        background-image: url('{{ asset('images/alumni-card-fon.png') }}');
        background-size: 100% 100%;
        background-position: center;
        background-repeat: no-repeat;
     ">
    {{-- Имя и ID в той же области, что на макете (левая часть светлой зоны) --}}
    <div class="absolute inset-0 flex items-center"
         style="font-family: 'Times New Roman', 'Georgia', serif;">
        @if ($isDashboard)
            {{-- Вариант для главной: шрифт адаптируется под ширину окна --}}
            <div class="pl-6 md:pl-12 pr-20 md:pr-40">
                <div class="font-semibold text-[#6B1E1D] leading-tight"
                     style="font-size: clamp(18px, 2.4vw, 30px);">
                    {{ $name }}
                </div>
                <div class="mt-1 font-medium text-[#6B1E1D]"
                     style="font-size: clamp(12px, 1.5vw, 20px);">
                    ID number: {{ $idDisplay }}
                </div>
            </div>
        @else
            {{-- Вариант для профиля: фиксированный, аккуратный размер --}}
            <div class="pl-8 md:pl-12 pr-24 md:pr-40">
                <div class="font-semibold text-[#6B1E1D] leading-tight text-[20px] sm:text-[22px] md:text-[26px]">
                    {{ $name }}
                </div>
                <div class="mt-1 font-medium text-[#6B1E1D] text-[14px] sm:text-[15px] md:text-[18px]">
                    ID number: {{ $idDisplay }}
                </div>
            </div>
        @endif
    </div>
</div>
