@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-1 pt-1 pb-2 border-b-2 border-[#8F161C] text-sm font-medium leading-5 text-[#2B2B2B] focus:outline-none transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 pb-2 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-[#8F161C] hover:border-gray-300 focus:outline-none focus:text-[#8F161C] focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
