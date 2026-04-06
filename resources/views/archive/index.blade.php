@extends('layouts.home')

@section('title', __('site.pages.archive_title'))

@section('content')
    <div class="min-h-screen flex flex-col bg-white">
        <header class="border-b" style="border-color: #D9D9D9;">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('home') }}#archive"
                   class="text-sm font-semibold text-[#8F161C] hover:underline">
                    {{ __('site.pages.back_home') }}
                </a>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-lg sm:text-xl font-bold" style="color: #2B2B2B;">{{ __('site.archive.title') }}</h1>
                    <x-language-switch />
                </div>
            </div>
        </header>

        <main class="flex-1 max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
            <p class="text-sm mb-6" style="color: #2B2B2B99;">
                {{ __('site.pages.archive_intro', ['limit' => \App\Models\ArchivePhoto::HOME_PREVIEW_LIMIT]) }}
            </p>

            <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-2 -mx-1 px-1 snap-x snap-mandatory mb-6">
                @foreach($archiveDecades as $key => $label)
                    <a href="{{ route('archive.index', ['decade' => $key]) }}"
                       class="snap-start shrink-0 px-4 py-3 sm:py-2 rounded-full text-xs sm:text-sm font-semibold border whitespace-nowrap min-h-[44px] sm:min-h-0 inline-flex items-center justify-center transition
                              {{ $decade === $key ? 'bg-[#8F161C] text-white border-[#8F161C]' : 'bg-white text-[#2B2B2B] border-[#D9D9D9] hover:border-[#8F161C]' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if($photos->isEmpty())
                <p class="text-center text-sm py-12" style="color: #2B2B2B99;">{{ __('site.pages.archive_empty') }}</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-3">
                    @foreach($photos as $photo)
                        <a href="{{ Storage::url($photo->path) }}"
                           target="_blank" rel="noopener"
                           class="group aspect-square rounded-lg overflow-hidden border bg-[#F6F2EA] border-[#D9D9D9] focus:outline-none focus:ring-2 focus:ring-[#8F161C] focus:ring-offset-2">
                            <img src="{{ Storage::url($photo->path) }}"
                                 alt="{{ __('site.archive.photo_alt', ['decade' => $archiveDecades[$decade] ?? '']) }}"
                                 class="w-full h-full object-cover group-hover:opacity-95 transition"
                                 loading="lazy">
                        </a>
                    @endforeach
                </div>

                @if($photos->hasPages())
                    <div class="mt-8">{{ $photos->links() }}</div>
                @endif
            @endif
        </main>
    </div>
@endsection
