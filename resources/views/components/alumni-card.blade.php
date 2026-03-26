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
                ->size(140)
                ->margin(0)
                ->color(0, 0, 0)
                ->backgroundColor(255, 255, 255)
                ->generate($cardUrl);
        } catch (\Throwable $e) {
            $qrSvg = null;
        }
    }

    $avatarUrl = $alumniProfile?->avatar_url ?? asset('images/user.png');
    $schoolFaculty = trim(($alumniProfile?->school ?? '') . ' ' . ($alumniProfile?->faculty_name ?? ''));
    $eduOp = $alumniProfile?->edu_op_name ?? ($alumniProfile?->specialty ?? '');
    $eduProgram = $alumniProfile?->edu_program_name ?? '';
    $degree = $alumniProfile?->study_level_name ?? ($alumniProfile?->degree ?? '');

    $year = $alumniProfile?->graduation_year;
    $status = (string) (($alumniProfile?->status) ?: 'Connect');

    $labelColor = '#E5C68D';
    $bg = '#8F161C';
@endphp

{{-- Превью в стиле Google Wallet (Alumni) --}}
<div class="relative w-full max-w-full overflow-hidden rounded-2xl shadow-xl ring-1 ring-black/5"
     style="aspect-ratio: 1.6; background-color: {{ $bg }};">
    {{-- subtle pattern + vignette --}}
    <div class="absolute inset-0 opacity-90"
         style="background:
            radial-gradient(900px 340px at 20% 25%, rgba(229,198,141,0.20), rgba(229,198,141,0) 55%),
            radial-gradient(700px 300px at 95% 10%, rgba(255,255,255,0.10), rgba(255,255,255,0) 45%),
            linear-gradient(135deg, rgba(255,255,255,0.08), rgba(0,0,0,0.12));
         "></div>

    {{-- top bar --}}
    <div class="absolute inset-x-0 top-0 px-5 pt-4 flex items-start justify-between gap-4">
        <div class="min-w-0">
            <div class="text-[11px] font-semibold tracking-[0.18em] uppercase"
                 style="color: {{ $labelColor }};">
                KazGASA Alumni
            </div>
            <div class="mt-1 text-white font-bold leading-tight truncate"
                 style="font-size: {{ $isDashboard ? '14px' : '15px' }};">
                {{ $name }}
            </div>
        </div>

        {{-- avatar --}}
        <div class="flex-shrink-0">
            <div class="w-12 h-12 rounded-2xl overflow-hidden"
                 style="background: rgba(255,255,255,0.08); border: 1px solid rgba(229,198,141,0.45);">
                <img src="{{ $avatarUrl }}"
                     onerror="this.src='{{ asset('images/user.png') }}'"
                     alt="{{ $name }}"
                     class="w-full h-full object-cover" />
            </div>
        </div>
    </div>

    {{-- content --}}
    <div class="absolute inset-x-0 bottom-0 px-5 pb-4">
        <div class="grid grid-cols-12 gap-4 items-end">
            <div class="col-span-7 min-w-0">
                <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                    <div class="min-w-0">
                        <div class="text-[10px] uppercase tracking-widest font-semibold"
                             style="color: {{ $labelColor }};">ID</div>
                        <div class="text-white text-[13px] font-semibold break-all leading-snug">
                            {{ $idDisplay }}
                        </div>
                    </div>

                    <div class="min-w-0">
                        <div class="text-[10px] uppercase tracking-widest font-semibold"
                             style="color: {{ $labelColor }};">Статус</div>
                        <div class="text-white text-[13px] font-semibold leading-snug truncate">
                            {{ $status }}
                        </div>
                    </div>

                    @if($year)
                        <div class="min-w-0">
                            <div class="text-[10px] uppercase tracking-widest font-semibold"
                                 style="color: {{ $labelColor }};">Год выпуска</div>
                            <div class="text-white text-[13px] font-semibold leading-snug">
                                {{ $year }}
                            </div>
                        </div>
                    @endif

                    @if($schoolFaculty !== '')
                        <div class="min-w-0">
                            <div class="text-[10px] uppercase tracking-widest font-semibold"
                                 style="color: {{ $labelColor }};">Школа/Факультет</div>
                            <div class="text-white text-[13px] leading-snug truncate">
                                {{ $schoolFaculty }}
                            </div>
                        </div>
                    @endif

                    @if($eduOp !== '')
                        <div class="col-span-2 min-w-0">
                            <div class="text-[10px] uppercase tracking-widest font-semibold"
                                 style="color: {{ $labelColor }};">Специальность</div>
                            <div class="text-white text-[13px] leading-snug"
                                 style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $eduOp }}@if($eduProgram !== '') · {{ $eduProgram }}@endif
                            </div>
                        </div>
                    @endif

                    @if($degree !== '')
                        <div class="col-span-2 min-w-0">
                            <div class="text-[10px] uppercase tracking-widest font-semibold"
                                 style="color: {{ $labelColor }};">Уровень</div>
                            <div class="text-white text-[13px] leading-snug truncate">
                                {{ $degree }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- QR --}}
            <div class="col-span-5 flex justify-end">
                @if ($qrSvg)
                    <div class="w-[92px] h-[92px] rounded-2xl p-2"
                         style="background: rgba(255,255,255,0.96); border: 1px solid rgba(229,198,141,0.55);">
                        {!! preg_replace('/<svg/', '<svg width="100%" height="100%" style="display:block"', $qrSvg) !!}
                    </div>
                @else
                    <div class="w-[92px] h-[92px] rounded-2xl flex items-center justify-center text-center px-2"
                         style="background: rgba(255,255,255,0.10); border: 1px dashed rgba(229,198,141,0.55); color: rgba(255,255,255,0.85);">
                        <div class="text-[10px] leading-snug">
                            QR появится<br>после входа
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
