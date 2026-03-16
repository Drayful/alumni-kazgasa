@extends('layouts.super-admin')

@section('title', 'Пользователи')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <h2 class="text-[#5E0F14] font-bold text-xl mb-2">Пользователи</h2>
        <p class="text-sm text-gray-600">
            Здесь вы можете просматривать пользователей и вручную подтверждать статус выпускника,
            даже если профиль не пришёл из iPortal или GRADUATES.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-[#8F161C] text-white">
                    <th class="px-4 py-3 text-left font-semibold">ID</th>
                    <th class="px-4 py-3 text-left font-semibold">Имя</th>
                    <th class="px-4 py-3 text-left font-semibold">Email</th>
                    <th class="px-4 py-3 text-left font-semibold">Статус</th>
                    <th class="px-4 py-3 text-left font-semibold">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="odd:bg-white even:bg-[#F6F2EA] border-b border-gray-100">
                        <td class="px-4 py-3 text-gray-500">{{ $user->id }}</td>
                        <td class="px-4 py-3 font-medium text-[#2B2B2B]">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$user->alumniProfile?->verification_status ?? 'pending'" />
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <form method="POST"
                                  action="{{ route('super-admin.users.status', $user) }}"
                                  class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="verification_status"
                                       value="{{ $user->alumniProfile?->verification_status === 'verified' ? 'pending' : 'verified' }}">
                                <button class="border border-[#8F161C] text-[#8F161C] hover:bg-[#8F161C] hover:text-white px-3 py-1 rounded-lg text-xs font-medium transition">
                                    {{ $user->alumniProfile?->verification_status === 'verified'
                                        ? 'Снять подтверждение'
                                        : 'Одобрить вручную' }}
                                </button>
                            </form>
                            <a href="{{ route('super-admin.users.show', $user) }}"
                               class="inline-block bg-[#8F161C] hover:bg-[#5E0F14] text-white px-3 py-1 rounded-lg text-xs font-medium transition">
                                Профиль
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-400">
                            Пользователи не найдены.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
@endsection

