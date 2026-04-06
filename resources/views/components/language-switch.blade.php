@props(['variant' => 'default'])

@php
    $locales = config('localization.supported', []);
    $current = app()->getLocale();
@endphp
<div {{ $attributes->class([
    'inline-flex rounded-lg border overflow-hidden shrink-0',
    $variant === 'inverse' ? 'border-white/40' : 'border-[#D9D9D9]',
]) }}>
    @foreach($locales as $code => $meta)
        <a href="{{ route('locale.switch', ['locale' => $code]) }}"
           @class([
               'px-2 py-1 text-xs font-semibold transition-colors no-underline',
               $variant === 'inverse'
                   ? ($current === $code ? 'bg-white text-[#8F161C]' : 'text-white/90 hover:bg-white/10')
                   : ($current === $code ? 'bg-[#8F161C] text-white' : 'text-[#2B2B2B] hover:bg-[#F6F2EA]'),
           ])
           hreflang="{{ $code }}"
           lang="{{ $code }}">{{ $meta['short'] }}</a>
    @endforeach
</div>
