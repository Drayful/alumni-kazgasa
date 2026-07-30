<?php

namespace App\Services;

use App\Models\LegacyEducationProgram;

class LegacyEducationProgramService
{
    public const PGS = 'Промышленное и гражданское строительство';
    public const PGS_ARCHITECTURE_SANITARY = 'Промышленное и гражданское строительство, Архитектура и Санитарно-технический';

    private const FIRST_HISTORICAL_YEAR = 1957;
    private const LAST_HISTORICAL_YEAR = 1991;

    /**
     * Returns only values that may be trusted when storing the profile.
     * ГОП is always derived on the server: it must never be accepted from a form.
     */
    public function resolve(int $graduationYear, ?int $programId): array
    {
        if (! $this->usesLockedHistoricalGroup($graduationYear)) {
            return [
                'legacy_education_program_id' => null,
                'legacy_group_of_programs' => null,
            ];
        }

        $program = null;
        if ($programId !== null) {
            $program = LegacyEducationProgram::query()
                ->whereKey($programId)
                ->where('graduation_year', $graduationYear)
                ->first();
        }

        $groupOfPrograms = null;

        $groupOfPrograms = $graduationYear <= 1979
            ? self::PGS
            : self::PGS_ARCHITECTURE_SANITARY;

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
