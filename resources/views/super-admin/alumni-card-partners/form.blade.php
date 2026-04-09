@extends('layouts.super-admin')

@section('title', $mode === 'create' ? 'Добавить партнёра' : 'Редактировать партнёра')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full max-w-4xl">
        <p class="text-sm text-gray-600 mb-4">Тексты на трёх языках. На сайте — по выбранному языку; пустые переводы заменяются русским.</p>
        <form method="POST"
              action="{{ $mode === 'create' ? route('super-admin.alumni-card-partners.store') : route('super-admin.alumni-card-partners.update', $partner) }}"
              class="space-y-5">
            @csrf
            @if($mode === 'edit')
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium text-[#2B2B2B]">Буква в квадрате</label>
                    <input name="logo_letter" value="{{ old('logo_letter', $partner->logo_letter) }}" required maxlength="8"
                           class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                    @error('logo_letter')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-[#2B2B2B]">Порядок</label>
                    <input name="sort_order" type="number" value="{{ old('sort_order', $partner->sort_order) }}" required
                           class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                    @error('sort_order')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-[#2B2B2B]">Ссылка (сайт партнёра)</label>
                    <input name="url" type="url" value="{{ old('url', $partner->url) }}"
                           placeholder="https://example.com"
                           class="mt-1 w-full border border-[#D9D9D9] rounded-xl px-4 py-2.5 text-sm focus:border-[#8F161C]" />
                    @error('url')<p class="text-xs text-[#8F161C] mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-4">
                @include('super-admin.partials.translated-partner-locale', ['loc' => 'kk', 'label' => 'Қазақша', 'partner' => $partner])
                @include('super-admin.partials.translated-partner-locale', ['loc' => 'ru', 'label' => 'Русский (обязательные поля)', 'partner' => $partner])
                @include('super-admin.partials.translated-partner-locale', ['loc' => 'en', 'label' => 'English', 'partner' => $partner])
            </div>

            <div class="flex items-center gap-2">
                <input id="is_active" name="is_active" type="checkbox" value="1"
                       class="rounded border-[#D9D9D9] text-[#8F161C] focus:ring-[#8F161C] accent-[#8F161C]"
                       {{ old('is_active', $partner->is_active) ? 'checked' : '' }} />
                <label for="is_active" class="text-sm text-[#2B2B2B]">Показывать на главной</label>
            </div>

            <div class="flex flex-wrap gap-2 pt-2">
                <button type="submit" class="bg-[#8F161C] hover:bg-[#5E0F14] text-white px-6 py-3 rounded-xl font-semibold transition text-sm">
                    Сохранить
                </button>
                <a href="{{ route('super-admin.alumni-card-partners.index') }}"
                   class="inline-flex items-center px-6 py-3 rounded-xl border border-[#D9D9D9] text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection
