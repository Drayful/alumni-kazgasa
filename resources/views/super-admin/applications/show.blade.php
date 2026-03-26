@extends('layouts.super-admin')

@section('title', 'Заявка')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9]">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-widest">Заявка партнёрства</p>
                    <h2 class="text-[#2B2B2B] font-bold text-xl mt-2">
                        {{ $application->company }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        От: <span class="font-semibold text-[#2B2B2B]">{{ $application->name }}</span>
                    </p>
                </div>

                <a href="{{ route('super-admin.applications.index') }}"
                   class="px-4 py-2 rounded-xl text-xs font-semibold border border-[#D9D9D9] hover:border-[#8F161C] transition">
                    ← К списку
                </a>
            </div>

            <div class="mt-6 grid sm:grid-cols-2 gap-4">
                <div class="rounded-xl border border-[#D9D9D9] p-4">
                    <p class="text-xs text-gray-500">Контакт</p>
                    <p class="mt-1 text-sm font-semibold text-[#2B2B2B] break-words">{{ $application->contact }}</p>
                </div>
                <div class="rounded-xl border border-[#D9D9D9] p-4">
                    <p class="text-xs text-gray-500">Дата</p>
                    <p class="mt-1 text-sm font-semibold text-[#2B2B2B]">
                        {{ $application->created_at?->format('d.m.Y H:i') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9]">
            <p class="text-xs text-gray-500 uppercase tracking-widest">Статус</p>
            <p class="mt-2 text-sm font-semibold text-[#2B2B2B]">
                {{ $application->status ?? 'new' }}
            </p>
            @if($application->processed_at)
                <p class="text-xs text-gray-500 mt-1">
                    Обработано: {{ $application->processed_at->format('d.m.Y H:i') }}
                </p>
            @endif

            <div class="mt-5 space-y-2">
                <form method="POST" action="{{ route('super-admin.applications.approve', $application) }}">
                    @csrf
                    @method('PATCH')
                    <button class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition">
                        Одобрить
                    </button>
                </form>
                <form method="POST" action="{{ route('super-admin.applications.reject', $application) }}">
                    @csrf
                    @method('PATCH')
                    <button class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold border border-[#D9D9D9] hover:border-[#8F161C] transition">
                        Отклонить
                    </button>
                </form>
                <form method="POST" action="{{ route('super-admin.applications.suspend', $application) }}">
                    @csrf
                    @method('PATCH')
                    <button class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold border border-[#D9D9D9] hover:border-[#8F161C] transition">
                        Пауза
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

