@extends('layouts.super-admin')

@section('title', 'Заявки')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">Заявки на “стать партнёром”</p>
                <p class="text-xs text-gray-400 mt-1">Фильтр по статусу и быстрые действия</p>
            </div>

            <div class="flex flex-wrap gap-2">
                @php
                    $statuses = [
                        ['key' => null, 'label' => 'Все'],
                        ['key' => 'new', 'label' => 'Новые'],
                        ['key' => 'approved', 'label' => 'Одобрено'],
                        ['key' => 'rejected', 'label' => 'Отклонено'],
                        ['key' => 'suspended', 'label' => 'Приостановлено'],
                    ];
                @endphp

                @foreach($statuses as $s)
                    <a href="{{ $s['key'] ? route('super-admin.applications.index', ['status' => $s['key']]) : route('super-admin.applications.index') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold border transition
                              {{ ($status ?? null) === $s['key'] ? 'bg-[#8F161C] text-white border-[#8F161C]' : 'bg-white text-[#2B2B2B] border-[#D9D9D9] hover:border-[#8F161C]' }}">
                        {{ $s['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-6 -mx-6 overflow-x-auto">
            <table class="w-full min-w-[1100px] text-sm table-fixed">
                <colgroup>
                    <col class="w-[160px]" />
                    <col class="w-[220px]" />
                    <col class="w-[260px]" />
                    <col class="w-[260px]" />
                    <col class="w-[150px]" />
                    <col class="w-[250px]" />
                </colgroup>
                <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 px-6">Дата</th>
                    <th class="py-3 pr-4">Имя</th>
                    <th class="py-3 pr-4">Компания</th>
                    <th class="py-3 pr-4">Контакт</th>
                    <th class="py-3 pr-4">Статус</th>
                    <th class="py-3 pr-6">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($applications as $a)
                    <tr class="border-b last:border-b-0">
                        <td class="py-3 px-6 text-gray-500 whitespace-nowrap">
                            {{ $a->created_at?->format('d.m.Y H:i') }}
                        </td>
                        <td class="py-3 pr-4 font-medium text-[#2B2B2B]">
                            <a href="{{ route('super-admin.applications.show', $a) }}" class="hover:underline">
                                {{ $a->name }}
                            </a>
                        </td>
                        <td class="py-3 pr-4 text-[#2B2B2B] break-words">
                            <span class="block leading-snug">
                                {{ $a->company }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 text-[#2B2B2B] break-words">
                            <span class="block leading-snug">
                                {{ $a->contact }}
                            </span>
                        </td>
                        <td class="py-3 pr-4">
                            @php
                                $badge = match($a->status) {
                                    'approved' => 'bg-green-50 text-green-700 border-green-200',
                                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                    'suspended' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
                                    default => 'bg-gray-50 text-gray-700 border-gray-200',
                                };
                                $label = match($a->status) {
                                    'approved' => 'Одобрено',
                                    'rejected' => 'Отклонено',
                                    'suspended' => 'Приостановлено',
                                    default => 'Новая',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="py-3 pr-6">
                            <div class="flex flex-wrap gap-2 justify-end">
                                <form method="POST" action="{{ route('super-admin.applications.approve', $a) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition">
                                        Одобрить
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.applications.reject', $a) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-[#D9D9D9] hover:border-[#8F161C] transition">
                                        Отклонить
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.applications.suspend', $a) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-[#D9D9D9] hover:border-[#8F161C] transition">
                                        Пауза
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">
                            Заявок пока нет.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    </div>
@endsection

