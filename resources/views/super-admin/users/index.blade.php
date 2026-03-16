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
                    <th class="px-4 py-3 text-left font-semibold">ИИН</th>
                    <th class="px-4 py-3 text-left font-semibold">Год выпуска</th>
                    <th class="px-4 py-3 text-left font-semibold">Школа / факультет</th>
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
                        <td class="px-4 py-3 text-gray-600">
                            {{ $user->alumniProfile?->iin ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $user->alumniProfile?->graduation_year ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $user->alumniProfile?->school }} {{ $user->alumniProfile?->faculty_name }}
                        </td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$user->alumniProfile?->verification_status ?? 'pending'" />
                        </td>
                        <td class="px-4 py-3 space-y-1">
                            <form method="POST"
                                  action="{{ route('super-admin.users.status', $user) }}"
                                  class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="verification_status"
                                        class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:border-[#8F161C] focus:ring-1 focus:ring-[#E5C68D]">
                                    @foreach(['pending','verified','rejected','inactive','expired','suspended'] as $status)
                                        <option value="{{ $status }}"
                                            @selected($user->alumniProfile?->verification_status === $status)>
                                            {{ match($status) {
                                                'pending'   => 'На рассмотрении',
                                                'verified'  => 'Подтверждён',
                                                'rejected'  => 'Отклонён',
                                                'inactive'  => 'Неактивен',
                                                'expired'   => 'Истёк',
                                                'suspended' => 'Заблокирован',
                                            } }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="border border-[#8F161C] text-[#8F161C] hover:bg-[#8F161C] hover:text-white px-3 py-1 rounded-lg text-xs font-medium transition">
                                    Обновить
                                </button>
                            </form>
                            <div>
                                <a href="{{ route('super-admin.users.show', $user) }}"
                                   class="inline-block bg-[#8F161C] hover:bg-[#5E0F14] text-white px-3 py-1 rounded-lg text-xs font-medium transition">
                                    Профиль
                                </a>
                            </div>
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

