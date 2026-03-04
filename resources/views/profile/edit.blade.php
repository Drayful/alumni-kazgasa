<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($alumniProfile)
                <div class="p-4 sm:p-8 bg-gradient-to-br from-sky-50 via-indigo-50 to-violet-50 shadow-sm sm:rounded-2xl">
                    <div class="max-w-xl mx-auto">
                        <h3 class="text-sm font-semibold text-sky-900 uppercase tracking-wide mb-3">
                            Цифровая карта выпускника
                        </h3>
                        <x-alumni-card :alumni-profile="$alumniProfile" />
                        <p class="mt-3 text-xs text-sky-900/70">
                            Покажите эту карту на экране телефона — она привязана к вашему профилю выпускника.
                        </p>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if ($alumniProfile)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-alumni-profile-form')
                </div>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
