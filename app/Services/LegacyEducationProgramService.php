<?php

namespace App\Services;

use App\Models\LegacyEducationProgram;
use Illuminate\Validation\ValidationException;

class LegacyEducationProgramService
{
    public const PGS = 'Промышленное и гражданское строительство';

    private const FIRST_HISTORICAL_YEAR = 1957;
    private const LAST_HISTORICAL_YEAR = 1991;

    /**
     * Returns only values that may be trusted when storing the profile.
     * ГОП is always derived on the server: it must never be accepted from a form.
     */
    public function resolve(int $graduationYear, ?int $programId): array
    {
        $program = null;
        $hasProgramsForYear = LegacyEducationProgram::query()
            ->where('graduation_year', $graduationYear)
            ->exists();

        if ($programId !== null) {
            $program = LegacyEducationProgram::query()
                ->whereKey($programId)
                ->where('graduation_year', $graduationYear)
                ->first();

            if (! $program) {
                throw ValidationException::withMessages([
                    'legacy_education_program_id' => 'Выберите ОП из списка для указанного года выпуска.',
                ]);
            }
        } elseif ($hasProgramsForYear) {
            throw ValidationException::withMessages([
                'legacy_education_program_id' => 'Выберите ОП из списка.',
            ]);
        }

        $groupOfPrograms = null;

        if ($this->usesLockedHistoricalGroup($graduationYear) && $graduationYear <= 1979) {
            $groupOfPrograms = self::PGS;
        } elseif ($program) {
            $groupOfPrograms = $program->group_of_programs;
        }

        return [
            'legacy_education_program_id' => $program?->id,
            'legacy_group_of_programs' => $groupOfPrograms,
        ];
    }

    public function usesLockedHistoricalGroup(int $graduationYear): bool
    {
        return $graduationYear >= self::FIRST_HISTORICAL_YEAR
            && $graduationYear <= self::LAST_HISTORICAL_YEAR;
    }
}
