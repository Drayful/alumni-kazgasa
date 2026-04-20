<?php

namespace App\Exports\SuperAdmin;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query(): Builder
    {
        return User::query()
            ->with('alumniProfile')
            ->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Имя',
            'Email',
            'Телефон',
            'ИИН',
            'Год выпуска',
            'Школа',
            'Факультет',
            'Статус',
            'Создан',
        ];
    }

    public function map($row): array
    {
        /** @var User $row */
        $profile = $row->alumniProfile;

        $status = $profile?->verification_status ?? 'pending';

        return [
            $row->id,
            $row->name,
            $row->email,
            $row->phone,
            $profile?->iin,
            $profile?->graduation_year,
            $profile?->school,
            $profile?->faculty_name,
            $status,
            optional($row->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}

