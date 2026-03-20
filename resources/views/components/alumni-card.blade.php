@props(['alumniProfile' => null, 'variant' => 'profile'])

@php
    /** @var \App\Models\AlumniProfile|null $alumniProfile */
    $authUser = auth()->check() ? auth()->user() : null;

    // Для неавторизованных используем брендовый текст, чтобы компонент не падал.
    $name = $alumniProfile?->full_name ?? ($authUser?->name ?? 'KazGASA Alumni');

    $idDisplay = $alumniProfile?->public_id ?? ($alumniProfile?->id ? (string) $alumniProfile->id : '—');
    $isDashboard = $variant === 'dashboard';

    $cardUrl = null;
    $qrSvg = null;
    if ($alumniProfile?->public_id) {
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
    }
@endphp

{{-- Фон берём из фоновой картинки, текст и ID рисуем поверх, QR справа на карте --}}
<div class="relative w-full max-w-full overflow-hidden rounded-xl shadow-xl"
     style="
        aspect-ratio: 1.6;
        background-image: url('{{ asset('images/alumni-card-fon.png') }}');
        background-size: 100% 100%;
        background-position: center;
        background-repeat: no-repeat;
     ">
    {{-- Имя и ID в той же области, что на макете (левая часть светлой зоны) --}}
    <div class="absolute inset-0 flex items-center overflow-hidden"
         style="font-family: 'Times New Roman', 'Georgia', serif;">
        @if ($isDashboard)
            <div class="pl-6 md:pl-12 pr-20 md:pr-40 flex-1 min-w-0 overflow-hidden">
                <div class="text-[11px] sm:text-[13px] font-bold leading-tight break-words overflow-hidden max-w-full text-[#6B1E1D]"
                     style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                    {{ $name }}
                </div>
                <div class="mt-1 text-[9px] sm:text-[11px] font-medium break-all text-[#6B1E1D]">
                    ID number: {{ $idDisplay }}
                </div>
            </div>
        @else
            <div class="pl-8 md:pl-12 pr-24 md:pr-40 flex-1 min-w-0 overflow-hidden">
                <div class="text-[11px] sm:text-[13px] font-bold leading-tight break-words overflow-hidden max-w-full text-[#6B1E1D]"
                     style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                    {{ $name }}
                </div>
                <div class="mt-1 text-[9px] sm:text-[11px] font-medium break-all text-[#6B1E1D]">
                    ID number: {{ $idDisplay }}
                </div>
            </div>
        @endif
    </div>

    {{-- QR справа по центру вертикально, чуть больше, без фона --}}
@if ($qrSvg)
    <div class="absolute left-auto right-3 top-1/2 -translate-y-1/2 w-20 h-20 flex items-center justify-center opacity-95">
        {!! 
            preg_replace(
                [
                    '/<svg/',                          // 1. Добавляем размеры
                    '/<rect[^>]+fill=["\']#?(?:fff(?:fff)?|white)["\'][^>]*>/i',  // 2. Удаляем белый фон rect
                    '/<rect[^>]+width=["\']100%["\'][^>]*>/i',  // 3. Удаляем rect с width="100%"
                ],
                [
                    '<svg width="100%" height="100%" style="display:block; background:transparent"',
                    '',
                    '',
                ],
                $qrSvg,
            )
        !!}
    </div>
@endif

</div>
