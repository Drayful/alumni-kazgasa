@extends('layouts.super-admin')

@section('title', 'Заявки на проекты')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">Заявки выпускников на участие в проектах</p>
                <p class="text-xs text-gray-400 mt-1">Фильтр по проекту и смена статуса</p>
            </div>

            <form method="GET" action="{{ route('super-admin.project-applications.index') }}" class="flex flex-col sm:flex-row gap-2">
                <select name="project_id"
                        class="border border-[#D9D9D9] rounded-xl px-4 py-2 text-sm bg-white focus:border-[#8F161C]">
                    <option value="">Все проекты</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ (string) $projectId === (string) $p->id ? 'selected' : '' }}>
                            {{ $p->localized('title', 'ru') }}
                        </option>
                    @endforeach
                </select>
                <button class="px-4 py-2 rounded-xl text-xs font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition">
                    Фильтр
                </button>
                @if((string) $projectId !== '')
                    <a href="{{ route('super-admin.project-applications.index') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold border border-[#D9D9D9] hover:border-[#8F161C] transition">
                        Сбросить
                    </a>
                @endif
            </form>
        </div>

        <div class="mt-6 -mx-6 overflow-x-auto">
            <table class="w-full min-w-[1200px] text-sm table-fixed">
                <colgroup>
                    <col class="w-[70px]" />
                    <col class="w-[220px]" />
                    <col class="w-[220px]" />
                    <col class="w-[320px]" />
                    <col class="w-[220px]" />
                    <col class="w-[160px]" />
                    <col class="w-[180px]" />
                    <col class="w-[220px]" />
                </colgroup>
                <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 pr-4">Имя</th>
                    <th class="py-3 pr-4">Компания</th>
                    <th class="py-3 pr-4">Проект</th>
                    <th class="py-3 pr-4">Контакт</th>
                    <th class="py-3 pr-4">Статус</th>
                    <th class="py-3 pr-4">Дата</th>
                    <th class="py-3 pr-6">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($applications as $a)
                    <tr class="border-b last:border-b-0">
                        <td class="py-3 px-6 text-gray-500">
                            {{ $a->id }}
                        </td>
                        <td class="py-3 pr-4 font-medium text-[#2B2B2B]">
                            {{ $a->name }}
                        </td>
                        <td class="py-3 pr-4 text-[#2B2B2B] break-words">
                            {{ $a->company }}
                        </td>
                        <td class="py-3 pr-4 text-[#2B2B2B] break-words">
                            {{ $a->project ? $a->project->localized('title', 'ru') : '—' }}
                        </td>
                        <td class="py-3 pr-4 text-[#2B2B2B] break-words">
                            {{ $a->contact }}
                        </td>
                        <td class="py-3 pr-4">
                            @php
                                $badge = match($a->status) {
                                    'new' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
                                    'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'done' => 'bg-green-50 text-green-700 border-green-200',
                                    default => 'bg-gray-50 text-gray-700 border-gray-200',
                                };
                                $label = match($a->status) {
                                    'new' => 'Новая',
                                    'in_progress' => 'В работе',
                                    'done' => 'Готово',
                                    default => $a->status,
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 text-gray-500 whitespace-nowrap">
                            {{ $a->created_at?->format('d.m.Y H:i') }}
                        </td>
                        <td class="py-3 pr-6">
                            <form method="POST" action="{{ route('super-admin.project-applications.status', $a) }}" class="flex items-center gap-2 justify-end">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border border-[#D9D9D9] rounded-lg px-3 py-2 text-xs bg-white focus:border-[#8F161C]">
                                    <option value="new" {{ $a->status === 'new' ? 'selected' : '' }}>new</option>
                                    <option value="in_progress" {{ $a->status === 'in_progress' ? 'selected' : '' }}>in_progress</option>
                                    <option value="done" {{ $a->status === 'done' ? 'selected' : '' }}>done</option>
                                </select>
                                <button class="px-3 py-2 rounded-lg text-xs font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition">
                                    Сохранить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-10 text-center text-gray-500">
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

