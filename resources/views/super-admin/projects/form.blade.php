@extends('layouts.super-admin')

@section('title', $mode === 'create' ? 'Добавить проект' : 'Редактировать проект')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full max-w-4xl">
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

            <div>
                <label class="text-sm font-medium text-[#2B2B2B]">Название</label>
                <input name="title" value="{{ old('title', $project->title) }}" required
                       class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                @error('title')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[#2B2B2B]">Теги</label>
                <input name="tags" value="{{ old('tags', $project->tags) }}"
                       class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                @error('tags')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[#2B2B2B]">Текст кнопки</label>
                <input name="button_text" value="{{ old('button_text', $project->button_text) }}" required
                       class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                @error('button_text')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[#2B2B2B]">Коротко</label>
                <textarea name="short" rows="3" required
                          class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ old('short', $project->short) }}</textarea>
                @error('short')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[#2B2B2B]">Как это работает</label>
                <textarea name="how_it_works" rows="5" required
                          class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ old('how_it_works', $project->how_it_works) }}</textarea>
                @error('how_it_works')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[#2B2B2B]">Что это даёт вам</label>
                <textarea name="what_you_get" rows="3" required
                          class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]">{{ old('what_you_get', $project->what_you_get) }}</textarea>
                @error('what_you_get')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
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

