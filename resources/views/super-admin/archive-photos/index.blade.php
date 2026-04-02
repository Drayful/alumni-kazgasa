@extends('layouts.super-admin')

@section('title', 'Архив фото')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-[#D9D9D9] w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">Фотографии блока «Архив KazGASA Alumni» на главной</p>
                <p class="text-xs text-gray-400 mt-1">Массовая загрузка по десятилетию; удаление одной или нескольких записей</p>
            </div>
            <form method="get" action="{{ route('super-admin.archive-photos.index') }}" class="flex flex-wrap items-center gap-2">
                <label class="text-xs text-gray-500">Десятилетие</label>
                <select name="decade" onchange="this.form.submit()"
                        class="rounded-lg border border-[#D9D9D9] px-3 py-2 text-sm text-gray-800 bg-white">
                    <option value="">Все</option>
                    @foreach($decades as $d)
                        <option value="{{ $d }}" @selected($decade === $d)>{{ \App\Models\ArchivePhoto::decadeLabel($d) }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div id="bulk-upload" class="mt-8 p-5 rounded-xl border border-dashed border-[#D9D9D9] bg-[#F6F2EA]/50 scroll-mt-24">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Массовая загрузка</h2>
            <p class="text-xs text-gray-500 mb-4">
                До 100 файлов за раз (JPEG, PNG, WebP, до 10 МБ каждый). Все снимки попадут в выбранное десятилетие.
                Автор записей в базе — ваш аккаунт супер-админа.
            </p>
            @error('bulk')
                <div class="mb-4 p-3 rounded-xl bg-red-50 text-[#8F161C] text-sm border border-red-200">
                    {{ $message }}
                </div>
            @enderror
            <form method="POST" action="{{ route('super-admin.archive-photos.bulk-store') }}"
                  enctype="multipart/form-data" class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end">
                @csrf
                <div class="flex flex-col gap-1.5">
                    <label for="bulk-decade" class="text-xs font-medium text-gray-600">Десятилетие</label>
                    <select name="decade" id="bulk-decade" required
                            class="rounded-lg border border-[#D9D9D9] px-3 py-2 text-sm text-gray-800 bg-white min-w-[140px]">
                        @foreach($decades as $d)
                            <option value="{{ $d }}" @selected($decade === $d)>{{ \App\Models\ArchivePhoto::decadeLabel($d) }}</option>
                        @endforeach
                    </select>
                    @error('decade')
                        <span class="text-xs text-[#8F161C]">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
                    <label for="bulk-photos" class="text-xs font-medium text-gray-600">Файлы</label>
                    <input type="file" name="photos[]" id="bulk-photos" required multiple
                           accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#8F161C] file:text-white hover:file:bg-[#5E0F14]">
                    @error('photos')
                        <span class="text-xs text-[#8F161C]">{{ $message }}</span>
                    @enderror
                    @foreach ($errors->getMessages() as $errKey => $errMessages)
                        @if (\Illuminate\Support\Str::startsWith($errKey, 'photos.'))
                            @foreach ($errMessages as $message)
                                <span class="text-xs text-[#8F161C] block">{{ $message }}</span>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition whitespace-nowrap">
                    Загрузить в архив
                </button>
            </form>
        </div>

        @foreach($photos as $photo)
            <form id="delete-form-{{ $photo->id }}" method="POST" action="{{ route('super-admin.archive-photos.destroy', $photo) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        <form id="bulk-archive-form" method="POST" action="{{ route('super-admin.archive-photos.bulk-delete') }}"
              class="mt-6"
              onsubmit="return confirm('Удалить выбранные фотографии? Это действие нельзя отменить.');">
            @csrf
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-[#8F161C] text-white hover:bg-[#5E0F14] transition disabled:opacity-50"
                        id="bulk-delete-btn" disabled>
                    Удалить выбранные
                </button>
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" id="select-all-archive" class="rounded border-gray-300 text-[#8F161C] focus:ring-[#8F161C]">
                    Выбрать все на странице
                </label>
            </div>

            <div class="overflow-x-auto -mx-6">
                <table class="w-full min-w-[640px] text-sm">
                    <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-3 px-6 w-10"></th>
                        <th class="py-3 pr-4">Превью</th>
                        <th class="py-3 pr-4">Десятилетие</th>
                        <th class="py-3 pr-4">Пользователь</th>
                        <th class="py-3 pr-4">Дата</th>
                        <th class="py-3 pr-6">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($photos as $photo)
                        <tr class="border-b last:border-b-0 align-middle">
                            <td class="py-3 px-6">
                                <input type="checkbox" name="ids[]" value="{{ $photo->id }}"
                                       class="archive-row-check rounded border-gray-300 text-[#8F161C] focus:ring-[#8F161C]">
                            </td>
                            <td class="py-3 pr-4">
                                <a href="{{ Storage::url($photo->path) }}" target="_blank" rel="noopener"
                                   class="block w-20 h-20 rounded-lg overflow-hidden bg-gray-100 border border-[#D9D9D9]">
                                    <img src="{{ Storage::url($photo->path) }}" alt="" class="w-full h-full object-cover">
                                </a>
                            </td>
                            <td class="py-3 pr-4 font-medium text-gray-800">{{ \App\Models\ArchivePhoto::decadeLabel($photo->decade) }}</td>
                            <td class="py-3 pr-4">
                                <div class="text-gray-800">{{ $photo->user?->name ?? '—' }}</div>
                                <div class="text-xs text-gray-500">{{ $photo->user?->email }}</div>
                            </td>
                            <td class="py-3 pr-4 text-gray-600">{{ $photo->created_at?->format('d.m.Y H:i') }}</td>
                            <td class="py-3 pr-6">
                                <button type="submit" form="delete-form-{{ $photo->id }}"
                                        class="text-xs font-semibold text-[#8F161C] hover:underline"
                                        onclick="return confirm('Удалить эту фотографию?');">
                                    Удалить
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-gray-500">Нет фотографий</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if($photos->hasPages())
            <div class="mt-6 px-2">{{ $photos->links() }}</div>
        @endif
    </div>

    <script>
        (function () {
            const form = document.getElementById('bulk-archive-form');
            if (!form) return;
            const checks = () => form.querySelectorAll('.archive-row-check');
            const bulkBtn = document.getElementById('bulk-delete-btn');
            const selectAll = document.getElementById('select-all-archive');

            function sync() {
                const n = [...checks()].filter(c => c.checked).length;
                if (bulkBtn) bulkBtn.disabled = n === 0;
            }

            checks().forEach(c => c.addEventListener('change', sync));
            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checks().forEach(c => { c.checked = selectAll.checked; });
                    sync();
                });
            }
            sync();
        })();
    </script>
@endsection
