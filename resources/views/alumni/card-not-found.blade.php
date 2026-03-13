@extends('layouts.card')

@section('title')
    Карта выпускника не найдена | KazGASA Alumni
@endsection

@section('content')
<div class="min-h-screen bg-[#F6F2EA] flex flex-col items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-sm p-10 max-w-sm w-full text-center">
        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-[#8F161C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-semibold text-[#2B2B2B] mb-2">
            Карта не найдена
        </h1>
        <p class="text-sm text-gray-600 mb-4">
            Возможно, ссылка устарела или карта выпускника ещё не создана.
        </p>
        @isset($cardNumber)
            <p class="text-xs text-gray-500 mb-6">
                Номер карты: <span class="font-mono text-[#8F161C]">{{ $cardNumber }}</span>
            </p>
        @endisset
        <a href="https://alumni.kazgasa.kz"
           class="block w-full bg-[#8F161C] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#5E0F14] transition-colors">
            Перейти на сайт
        </a>
    </div>
</div>
@endsection

