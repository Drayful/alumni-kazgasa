@php
    /** @var string $loc */
    /** @var string $label */
    /** @var \App\Models\AlumniCardPartner $partner */
    $val = fn (string $f) => old('translations.'.$loc.'.'.$f, (string) data_get($partner->translations, $loc.'.'.$f, ''));
@endphp
<div class="rounded-xl border border-[#D9D9D9] p-4 space-y-4 bg-[#FAFAFA]">
    <p class="text-sm font-semibold text-[#8F161C]">{{ $label }}</p>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Название @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <input name="translations[{{ $loc }}][name]" value="{{ $val('name') }}" @if($loc === 'ru') required @endif
               class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
        @error('translations.'.$loc.'.name')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Скидка (текст) @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <input name="translations[{{ $loc }}][discount]" value="{{ $val('discount') }}" @if($loc === 'ru') required @endif
               class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]"
               placeholder="X%, 20%" />
        @error('translations.'.$loc.'.discount')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Краткое описание @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <textarea name="translations[{{ $loc }}][description]" rows="3" @if($loc === 'ru') required @endif
                  class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ $val('description') }}</textarea>
        @error('translations.'.$loc.'.description')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Текст во всплывающем окне @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <textarea name="translations[{{ $loc }}][popup]" rows="5" @if($loc === 'ru') required @endif
                  class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ $val('popup') }}</textarea>
        @error('translations.'.$loc.'.popup')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Примечание (внизу попапа)</label>
        <textarea name="translations[{{ $loc }}][note]" rows="2"
                  class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ $val('note') }}</textarea>
        @error('translations.'.$loc.'.note')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
</div>
