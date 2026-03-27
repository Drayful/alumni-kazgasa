@extends('layouts.super-admin')

@section('title', 'Проекты')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">Управление проектами секции «Проекты» на главной странице</p>
                <p class="text-xs text-gray-400 mt-1">Порядок, активность и содержимое карточек</p>
            </div>
            <a href="{{ route('super-admin.projects.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition">
                + Добавить проект
            </a>
        </div>

        <div class="mt-6 -mx-6 overflow-x-auto">
            <table class="w-full min-w-[1200px] text-sm table-fixed">
                <colgroup>
                    <col class="w-[70px]" />
                    <col class="w-[100px]" />
                    <col class="w-[90px]" />
                    <col class="w-[360px]" />
                    <col class="w-[360px]" />
                    <col class="w-[120px]" />
                    <col class="w-[240px]" />
                </colgroup>
                <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 pr-4">Порядок</th>
                    <th class="py-3 pr-4">Иконка</th>
                    <th class="py-3 pr-4">Название</th>
                    <th class="py-3 pr-4">Теги</th>
                    <th class="py-3 pr-4">Активен</th>
                    <th class="py-3 pr-6">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($projects as $p)
                    <tr class="border-b last:border-b-0">
                        <td class="py-3 px-6 text-gray-500">{{ $p->id }}</td>
                        <td class="py-3 pr-4">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-700 font-semibold">{{ $p->sort_order }}</span>
                                <div class="flex flex-col leading-none">
                                    <form method="POST" action="{{ route('super-admin.projects.move', $p) }}?direction=up">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-xs text-gray-500 hover:text-[#8F161C]" title="Вверх">▲</button>
                                    </form>
                                    <form method="POST" action="{{ route('super-admin.projects.move', $p) }}?direction=down">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-xs text-gray-500 hover:text-[#8F161C]" title="Вниз">▼</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 pr-4 text-2xl">{{ $p->icon }}</td>
                        <td class="py-3 pr-4 font-medium text-[#2B2B2B] break-words">{{ $p->title }}</td>
                        <td class="py-3 pr-4 text-[#2B2B2B] break-words">{{ $p->tags }}</td>
                        <td class="py-3 pr-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border
                                {{ $p->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                {{ $p->is_active ? 'Активен' : 'Скрыт' }}
                            </span>
                        </td>
                        <td class="py-3 pr-6">
                            <div class="flex flex-wrap gap-2 justify-end">
                                <a href="{{ route('super-admin.projects.edit', $p) }}"
                                   class="px-3 py-2 rounded-lg text-xs font-semibold border border-[#D9D9D9] hover:border-[#8F161C] transition">
                                    Редактировать
                                </a>
                                <form method="POST" action="{{ route('super-admin.projects.toggle', $p) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-2 rounded-lg text-xs font-semibold {{ $p->is_active ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-yellow-50 text-yellow-800 border border-yellow-200' }}">
                                        {{ $p->is_active ? 'Скрыть' : 'Включить' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.projects.destroy', $p) }}"
                                      onsubmit="return confirm('Удалить проект?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 rounded-lg text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-500">Проектов пока нет.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

