<?php

namespace App\Exports\SuperAdmin;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport extends DefaultValueBinder implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithCustomValueBinder,
    ShouldAutoSize
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
            $profile?->iin === null ? null : (string) $profile->iin,
            $profile?->graduation_year,
            $profile?->school,
            $profile?->faculty_name,
            $status,
            optional($row->created_at)->format('Y-m-d H:i:s'),
        ];
    }

    public function columnFormats(): array
    {
        // ИИН (12 цифр) нужно хранить как текст, иначе Excel может менять отображение числа.
        return [
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function bindValue(Cell $cell, $value): bool
    {
        // Колонка E = ИИН. Записываем явно как строку, чтобы Excel не применял научную нотацию.
        if ($cell->getColumn() === 'E' && $cell->getRow() > 1 && $value !== null) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}

