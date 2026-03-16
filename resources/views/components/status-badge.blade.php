
@props(['status'])

@php
  $classes = match($status) {
    'pending'   => 'bg-yellow-100 text-yellow-800',
    'verified'  => 'bg-green-100 text-green-800',
    'rejected'  => 'bg-red-100 text-[#8F161C]',
    'inactive'  => 'bg-gray-100 text-gray-600',
    'expired'   => 'bg-orange-100 text-orange-800',
    'suspended' => 'bg-[#5E0F14] text-white',
    default     => 'bg-gray-100 text-gray-500',
  };
  $labels = match($status) {
    'pending'   => 'На рассмотрении',
    'verified'  => 'Подтверждён',
    'rejected'  => 'Отклонён',
    'inactive'  => 'Неактивен',
    'expired'   => 'Истёк',
    'suspended' => 'Заблокирован',
    default     => $status,
  };
@endphp

<span class="px-2 py-1 rounded-full text-xs font-semibold {{ $classes }}">
  {{ $labels }}
</span>