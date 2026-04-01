@extends('layouts.super-admin')

@section('title', 'Партнёры карты выпускника')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">Блок на главной: «Партнёры, где работает карта выпускника»</p>
                <p class="text-xs text-gray-400 mt-1">Порядок, активность, редактирование и удаление</p>
            </div>
            <a href="{{ route('super-admin.alumni-card-partners.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition">
                + Добавить партнёра
            </a>
        </div>

        <div class="mt-6 -mx-6 overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 px-6 w-24">Порядок</th>
                    <th class="py-3 pr-4 w-16">Лого</th>
                    <th class="py-3 pr-4">Название</th>
                    <th class="py-3 pr-4 w-24">Скидка</th>
                    <th class="py-3 pr-4 w-24">Активен</th>
                    <th class="py-3 pr-6">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($partners as $p)
                    <tr class="border-b last:border-b-0 align-middle">
                        <td class="py-3 px-6">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-700 font-semibold">{{ $p->sort_order }}</span>
                                <div class="flex flex-col leading-none">
                                    <form method="POST" action="{{ route('super-admin.alumni-card-partners.move', $p) }}?direction=up">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-gray-500 hover:text-[#8F161C]" title="Вверх">▲</button>
                                    </form>
                                    <form method="POST" action="{{ route('super-admin.alumni-card-partners.move', $p) }}?direction=down">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-gray-500 hover:text-[#8F161C]" title="Вниз">▼</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 pr-4">
                            <span class="inline-flex w-10 h-10 rounded-xl bg-[#F6F2EA] border border-[#D9D9D9] items-center justify-center text-[#8F161C] font-bold text-sm">
                                {{ $p->logo_letter }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 font-medium text-gray-800">{{ $p->name }}</td>
                        <td class="py-3 pr-4 text-gray-700">{{ $p->discount }}</td>
                        <td class="py-3 pr-4">
                            <form method="POST" action="{{ route('super-admin.alumni-card-partners.toggle', $p) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold {{ $p->is_active ? 'text-green-700' : 'text-gray-400' }}">
                                    {{ $p->is_active ? 'Да' : 'Нет' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3 pr-6">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('super-admin.alumni-card-partners.edit', $p) }}"
                                   class="text-xs font-semibold text-[#8F161C] hover:underline">Изменить</a>
                                <form method="POST" action="{{ route('super-admin.alumni-card-partners.destroy', $p) }}"
                                      class="inline"
                                      onsubmit="return confirm('Удалить партнёра «{{ addslashes($p->name) }}»?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                            Партнёров пока нет.
                            <a href="{{ route('super-admin.alumni-card-partners.create') }}" class="text-[#8F161C] font-semibold ml-1">Добавить</a>
                            или выполните
                            <code class="text-xs bg-gray-100 px-1 rounded">php artisan db:seed --class=AlumniCardPartnersSeeder</code>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
