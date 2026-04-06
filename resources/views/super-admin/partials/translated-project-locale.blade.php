@php
    /** @var string $loc */
    /** @var string $label */
    /** @var \App\Models\Project $project */
    $val = fn (string $f) => old('translations.'.$loc.'.'.$f, (string) data_get($project->translations, $loc.'.'.$f, ''));
@endphp
<div class="rounded-xl border border-[#D9D9D9] p-4 space-y-4 bg-[#FAFAFA]">
    <p class="text-sm font-semibold text-[#8F161C]">{{ $label }}</p>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Название @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <input name="translations[{{ $loc }}][title]" value="{{ $val('title') }}" @if($loc === 'ru') required @endif
               class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
        @error('translations.'.$loc.'.title')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Теги</label>
        <input name="translations[{{ $loc }}][tags]" value="{{ $val('tags') }}"
               class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
        @error('translations.'.$loc.'.tags')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Текст кнопки @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <input name="translations[{{ $loc }}][button_text]" value="{{ $val('button_text') }}" @if($loc === 'ru') required @endif
               class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
        @error('translations.'.$loc.'.button_text')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Коротко @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <textarea name="translations[{{ $loc }}][short]" rows="3" @if($loc === 'ru') required @endif
                  class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ $val('short') }}</textarea>
        @error('translations.'.$loc.'.short')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Как это работает @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <textarea name="translations[{{ $loc }}][how_it_works]" rows="5" @if($loc === 'ru') required @endif
                  class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ $val('how_it_works') }}</textarea>
        @error('translations.'.$loc.'.how_it_works')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="text-sm font-medium text-[#2B2B2B]">Что это даёт вам @if($loc === 'ru')<span class="text-[#8F161C]">*</span>@endif</label>
        <textarea name="translations[{{ $loc }}][what_you_get]" rows="3" @if($loc === 'ru') required @endif
                  class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ $val('what_you_get') }}</textarea>
        @error('translations.'.$loc.'.what_you_get')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
    </div>
</div>
