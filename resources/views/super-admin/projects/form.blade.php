@extends('layouts.super-admin')

@section('title', $mode === 'create' ? 'Добавить проект' : 'Редактировать проект')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full max-w-4xl">
        <p class="text-sm text-gray-600 mb-4">Тексты на трёх языках (на сайте показывается выбранный язык; если перевода нет — подставляется русский).</p>
        <form method="POST"
              action="{{ $mode === 'create' ? route('super-admin.projects.store') : route('super-admin.projects.update', $project) }}"
              class="space-y-5">
            @csrf
            @if($mode === 'edit')
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-[#2B2B2B]">Иконка</label>
                    <input name="icon" value="{{ old('icon', $project->icon) }}" required
                           class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                    @error('icon')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-[#2B2B2B]">Порядок</label>
                    <input name="sort_order" type="number" value="{{ old('sort_order', $project->sort_order) }}" required
                           class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                    @error('sort_order')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-4">
                @include('super-admin.partials.translated-project-locale', ['loc' => 'kk', 'label' => 'Қазақша', 'project' => $project])
                @include('super-admin.partials.translated-project-locale', ['loc' => 'ru', 'label' => 'Русский (обязательные поля)', 'project' => $project])
                @include('super-admin.partials.translated-project-locale', ['loc' => 'en', 'label' => 'English', 'project' => $project])
            </div>

            <div class="flex items-center gap-2">
                <input id="is_active" name="is_active" type="checkbox" value="1"
                       class="rounded border-[#D9D9D9] text-[#8F161C] focus:ring-[#8F161C] accent-[#8F161C]"
                       {{ old('is_active', $project->is_active) ? 'checked' : '' }} />
                <label for="is_active" class="text-sm text-[#2B2B2B]">Активен (показывать на сайте)</label>
            </div>

            <div class="flex flex-wrap gap-2 pt-2">
                <button class="bg-[#8F161C] hover:bg-[#5E0F14] text-white px-6 py-3 rounded-xl font-semibold transition text-sm">
                    {{ $mode === 'create' ? 'Создать' : 'Сохранить' }}
                </button>
                <a href="{{ route('super-admin.projects.index') }}"
                   class="px-6 py-3 rounded-xl font-semibold text-sm border border-[#D9D9D9] hover:border-[#8F161C] transition">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection
