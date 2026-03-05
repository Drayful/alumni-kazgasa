@props(['alumniProfile' => null, 'variant' => 'profile'])

@php
    /** @var \App\Models\AlumniProfile|null $alumniProfile */
    $name = $alumniProfile?->full_name ?? auth()->user()->name;
    $idDisplay = $alumniProfile?->public_id
        ?? str_pad((string) ($alumniProfile?->id ?? auth()->id()), 6, '0', STR_PAD_LEFT);
    $isDashboard = $variant === 'dashboard';

    $cardUrl = null;
    $qrSvg = null;
    if ($alumniProfile?->public_id) {
        $cardUrl = route('alumni.card.show', ['publicId' => $alumniProfile->public_id]);
        try {
            $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(100)
                ->margin(0)
                ->color(0, 0, 0)
                ->backgroundColor(0, 0, 0,100)
                ->generate($cardUrl);
        } catch (\Throwable $e) {
            $qrSvg = null;
        }
    }
@endphp

{{-- Фон берём из фоновой картинки, текст и ID рисуем поверх, QR справа на карте --}}
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

    {{-- QR справа по центру вертикально, чуть больше, без фона --}}
    @if ($qrSvg)
        <div class="absolute left-auto right-3 top-1/2 -translate-y-1/2 w-20 h-20 flex items-center justify-center opacity-95">
            {!! preg_replace('/<svg/', '<svg width="100%" height="100%" style="display:block"', $qrSvg, 1) !!}
        </div>
    @endif
</div>
