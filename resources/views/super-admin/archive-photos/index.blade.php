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
            <form id="bulk-upload-form" method="POST" action="{{ route('super-admin.archive-photos.bulk-store') }}"
                  enctype="multipart/form-data"
                  class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end">
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

            <div id="bulk-upload-status" class="hidden mt-4 p-3 rounded-xl border text-sm"></div>
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
            const form = document.getElementById('bulk-upload-form');
            const input = document.getElementById('bulk-photos');
            const decadeSelect = document.getElementById('bulk-decade');
            const statusBox = document.getElementById('bulk-upload-status');
            if (!form || !input || !decadeSelect || !statusBox) return;

            const routeUrl = form.getAttribute('action');
            const token = form.querySelector('input[name="_token"]')?.value;
            const submitBtn = form.querySelector('button[type="submit"]');
            const indexBaseUrl = "{{ route('super-admin.archive-photos.index') }}";

            if (!routeUrl || !token) return;

            // Сервер может иметь низкий `upload_max_filesize`/`post_max_size`.
            // Чтобы обойти это, уменьшаем/пересохраняем картинки в браузере.
            const TARGET_MAX_BYTES = 1024 * 1024; // ~1MB
            const MAX_DIMENSION = 1600; // ограничим длинную сторону

            async function compressFileToJpeg(file) {
                const imgUrl = URL.createObjectURL(file);
                try {
                    const img = await new Promise((resolve, reject) => {
                        const el = new Image();
                        el.onload = () => resolve(el);
                        el.onerror = reject;
                        el.src = imgUrl;
                    });

                    let w = img.naturalWidth || img.width;
                    let h = img.naturalHeight || img.height;
                    if (!w || !h) return { blob: file, filename: file.name };

                    const scale = Math.min(1, MAX_DIMENSION / Math.max(w, h));
                    w = Math.round(w * scale);
                    h = Math.round(h * scale);

                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d', { willReadFrequently: false });
                    if (!ctx) return { blob: file, filename: file.name };

                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.drawImage(img, 0, 0, w, h);

                    const nameWithoutExt = file.name.replace(/\.[^/.]+$/, '');
                    const candidates = [0.92, 0.82, 0.72, 0.62, 0.52, 0.42, 0.32, 0.22, 0.15];
                    let lastBlob = null;

                    for (const q of candidates) {
                        const blob = await new Promise((resolve) => {
                            canvas.toBlob((b) => resolve(b), 'image/jpeg', q);
                        });
                        if (!blob) continue;
                        lastBlob = blob;
                        if (blob.size <= TARGET_MAX_BYTES) {
                            return { blob, filename: nameWithoutExt + '.jpg' };
                        }
                    }

                    return lastBlob
                        ? { blob: lastBlob, filename: nameWithoutExt + '.jpg' }
                        : { blob: file, filename: file.name };
                } finally {
                    URL.revokeObjectURL(imgUrl);
                }
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const files = Array.from(input.files || []);
                if (!files.length) return;

                const decade = decadeSelect.value;
                if (!decade) return;

                statusBox.classList.remove('hidden');
                statusBox.classList.remove('bg-red-50', 'border-red-200', 'text-[#8F161C]');
                statusBox.classList.add('bg-[#F6F2EA]', 'border-[#D9D9D9]', 'text-gray-800');
                statusBox.textContent = 'Загрузка... (0/' + files.length + ')';

                if (submitBtn) submitBtn.disabled = true;

                let okCount = 0;
                try {
                    for (let i = 0; i < files.length; i++) {
                        let uploadFile = files[i];
                        let uploadName = files[i].name;
                        if (files[i].size > TARGET_MAX_BYTES) {
                            const compressed = await compressFileToJpeg(files[i]);
                            uploadFile = compressed.blob;
                            uploadName = compressed.filename;
                        }

                        const fd = new FormData();
                        fd.append('_token', token);
                        fd.append('decade', decade);
                        fd.append('photos[]', uploadFile, uploadName);

                        const res = await fetch(routeUrl, {
                            method: 'POST',
                            body: fd,
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        if (res.status < 200 || res.status >= 400) {
                            let details = '';
                            try {
                                const data = await res.json();
                                if (data?.errors) {
                                    const firstKey = Object.keys(data.errors)[0];
                                    const firstVal = data.errors[firstKey];
                                    details = Array.isArray(firstVal) ? firstVal.join(', ') : String(firstVal);
                                } else if (data?.message) {
                                    details = data.message;
                                } else {
                                    details = JSON.stringify(data);
                                }
                            } catch (jsonErr) {
                                try {
                                    const text = await res.text();
                                    details = text.slice(0, 500);
                                } catch (textErr) {
                                    details = '';
                                }
                            }
                            throw new Error('Server returned HTTP ' + res.status + ' for file #' + (i + 1) + (details ? (': ' + details) : ''));
                        }

                        okCount++;
                        statusBox.textContent = 'Загрузка... (' + okCount + '/' + files.length + ')';
                    }

                    window.location.href = indexBaseUrl + '?decade=' + encodeURIComponent(decade) + '#bulk-upload';
                } catch (err) {
                    statusBox.classList.remove('bg-[#F6F2EA]', 'border-[#D9D9D9]', 'text-gray-800');
                    statusBox.classList.add('bg-red-50', 'border-red-200', 'text-[#8F161C]');
                    statusBox.textContent = 'Ошибка загрузки: ' + (err?.message || 'неизвестная ошибка');
                    if (submitBtn) submitBtn.disabled = false;
                }
            });
        })();
    </script>

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
