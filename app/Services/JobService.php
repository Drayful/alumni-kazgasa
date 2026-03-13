<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class JobService
{
    public function getActiveJobs(int $limit = null): Collection
    {
        $query = DB::connection('iportal')
            ->table('portal_mok_jobs as pmj')
            ->leftJoin(
                'portal_sp_mok_job_employment_type as empt',
                'empt.id',
                '=',
                'pmj.employment_type',
            )
            ->leftJoin(
                'portal_mok_job_responses as pmr',
                'pmr.job_id',
                '=',
                'pmj.id',
            )
            ->where('pmj.is_active', 1)
            ->where(function ($q) {
                $q->whereNull('pmj.end_date')
                    ->orWhereRaw('pmj.end_date > CURRENT_DATE');
            })
            ->where(function ($q) {
                $q->where('empt.is_practice', 0)
                    ->orWhereNull('empt.id');
            })
            ->where('pmj.user_status', 2)
            ->select([
                'pmj.*',
                'empt.name_ru as employment_type_name',
                DB::raw('COUNT(pmr.id) AS responses_count'),
            ])
            ->groupBy(
                'pmj.id',
                'pmj.created_at',
                'pmj.position_name',
                'pmj.company_name',
                'pmj.company_description',
                'pmj.company_logo_path',
                'pmj.contacts',
                'pmj.responsibilities',
                'pmj.requirements',
                'pmj.address',
                'pmj.conditions',
                'pmj.employment_type',
                'pmj.employment_form',
                'pmj.user_status',
                'pmj.salary',
                'pmj.end_date',
                'pmj.is_approved',
                'pmj.is_active',
                'pmj.min_gpa',
                'pmj.max_responses',
                'empt.name_ru',
            )
            ->orderByDesc('pmj.created_at');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function getJobById(int $id): ?object
    {
        return DB::connection('iportal')
            ->table('portal_mok_jobs as pmj')
            ->leftJoin(
                'portal_sp_mok_job_employment_type as empt',
                'empt.id',
                '=',
                'pmj.employment_type',
            )
            ->leftJoin(
                'portal_mok_job_responses as pmr',
                'pmr.job_id',
                '=',
                'pmj.id',
            )
            ->where('pmj.id', $id)
            ->where('pmj.is_active', 1)
            ->select([
                'pmj.*',
                'empt.name_ru as employment_type_name',
                DB::raw('COUNT(pmr.id) AS responses_count'),
            ])
            ->groupBy(
                'pmj.id',
                'pmj.created_at',
                'pmj.position_name',
                'pmj.company_name',
                'pmj.company_description',
                'pmj.company_logo_path',
                'pmj.contacts',
                'pmj.responsibilities',
                'pmj.requirements',
                'pmj.address',
                'pmj.conditions',
                'pmj.employment_type',
                'pmj.employment_form',
                'pmj.user_status',
                'pmj.salary',
                'pmj.end_date',
                'pmj.is_approved',
                'pmj.is_active',
                'pmj.min_gpa',
                'pmj.max_responses',
                'empt.name_ru',
            )
            ->first();
    }

    public function clearCache(): void
    {
        // Кеш отключён, метод оставлен для совместимости.
    }
}

