@extends('layouts.super-admin')

@section('title', 'Профиль пользователя')

@section('content')
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2">
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="text-[#5E0F14] font-bold text-xl mb-4 border-l-4 border-[#8F161C] pl-3">
                    {{ $user->name }}
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Email</span>
                        <span class="font-medium text-[#2B2B2B]">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">ID</span>
                        <span class="font-medium text-[#2B2B2B]">{{ $user->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Статус карты</span>
                        <span class="font-medium">
                            <x-status-badge :status="$user->alumniProfile?->verification_status ?? 'pending'" />
                        </span>
                    </div>
                </div>

                @if($user->alumniProfile)
                    <h3 class="mt-6 mb-3 text-[#5E0F14] font-bold">
                        Профиль выпускника
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">ФИО</span>
                            <span class="font-medium text-[#2B2B2B] text-right">
                                {{ $user->alumniProfile->full_name }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">Год выпуска</span>
                            <span class="font-medium text-[#2B2B2B]">
                                {{ $user->alumniProfile->graduation_year ?? '—' }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">Школа / факультет</span>
                            <span class="font-medium text-[#2B2B2B] text-right">
                                {{ $user->alumniProfile->school }} {{ $user->alumniProfile->faculty_name }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">Специальность</span>
                            <span class="font-medium text-[#2B2B2B] text-right">
                                {{ $user->alumniProfile->edu_op_name ?? $user->alumniProfile->specialty ?? '—' }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">IIN</span>
                            <span class="font-medium text-[#2B2B2B]">
                                {{ $user->alumniProfile->iin ?? '—' }}
                            </span>
                        </div>
                    </div>
                @else
                    <p class="mt-6 text-sm text-gray-500">
                        У пользователя ещё нет профиля выпускника (alumni_profile). Вы можете создать его вручную
                        через редактирование пользователя.
                    </p>
                @endif
            </div>
        </div>

        <div>
            <!-- <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                <h3 class="text-[#5E0F14] font-bold mb-4">Фото</h3>
                @if($user->alumniProfile)
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden ring-4 ring-[#8F161C] ring-offset-2 ring-offset-[#F6F2EA] bg-white">
                        <img src="{{ $user->alumniProfile->avatar_url }}"
                             alt="{{ $user->alumniProfile->full_name }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('images/user.png') }}'">
                    </div>
                @else
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden ring-4 ring-[#8F161C] ring-offset-2 ring-offset-[#F6F2EA] bg-white flex items-center justify-center text-[#8F161C]">
                        Нет фото
                    </div>
                @endif -->

                <a href="{{ route('super-admin.users.index') }}"
                   class="mt-6 inline-block border border-[#8F161C] text-[#8F161C] hover:bg-[#8F161C] hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    ← К списку пользователей
                </a>
            </div>
        </div>
    </div>
@endsection

