<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumniProfileUpdateRequest;
use App\Models\LegacyEducationProgram;
use App\Services\LegacyEducationProgramService;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('alumniProfile');
        $portalOptions = $this->loadPortalOptions();

        return view('profile.edit', [
            'user' => $user,
            'alumniProfile' => $user->alumniProfile,
            'portalOptions' => $portalOptions,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the alumni profile (first_name, last_name, group, study form, etc.).
     */
    public function updateAlumni(AlumniProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $legacyEducationData = app(LegacyEducationProgramService::class)->resolve(
            (int) $data['graduation_year'],
            isset($data['legacy_education_program_id']) ? (int) $data['legacy_education_program_id'] : null,
        );

        // Синхронизируем человекочитаемые названия с выбранными ID из iPortal.
        $names = $this->resolvePortalNames(
            $data['study_group'] ?? null,
            $data['edu_op'] ?? null,
            $data['edu_program'] ?? null
        );

        // If iPortal did not provide a linked value, preserve a manually entered name.
        foreach ([
            'study_group_name' => 'study_group',
            'edu_op_name' => 'edu_op',
            'edu_program_name' => 'edu_program',
        ] as $nameField => $idField) {
            if (empty($data[$idField]) && ! empty($data[$nameField])) {
                $names[$nameField] = $data[$nameField];
            } elseif (empty($data[$idField]) && ! empty($request->user()->alumniProfile->{$nameField})) {
                // A manual value is not rendered while a select has choices; retain it on unrelated updates.
                $names[$nameField] = $request->user()->alumniProfile->{$nameField};
            }
        }

        $request->user()->alumniProfile->update(array_merge($data, $names, $legacyEducationData));

        return Redirect::route('profile.edit')->with('status', 'alumni-profile-updated');
    }

    private function loadPortalOptions(): array
    {
        $legacyPrograms = LegacyEducationProgram::query()
            ->orderBy('graduation_year')
            ->orderBy('sort_order')
            ->get(['id', 'graduation_year', 'name', 'group_of_programs']);

        try {
            $iportal = DB::connection('iportal');

            return [
                'groups' => $iportal->table('portal_agroups')
                    ->select('id', 'name', 'edu_op')
                    ->orderBy('name')
                    ->get(),
                'ops' => $iportal->table('portal_sp_edu_op')
                    ->select('id', 'name_ru', 'group_op_id')
                    ->orderBy('name_ru')
                    ->get(),
                'gops' => $iportal->table('portal_sp_group_edu_op')
                    ->select('id', 'name_ru')
                    ->orderBy('name_ru')
                    ->get(),
                'legacy_programs' => $legacyPrograms,
            ];
        } catch (\Throwable $e) {
            report($e);

            return [
                'groups' => collect(),
                'ops' => collect(),
                'gops' => collect(),
                'legacy_programs' => $legacyPrograms,
            ];
        }
    }

    private function resolvePortalNames(?int $studyGroupId, ?int $eduOpId, ?int $eduProgramId): array
    {
        try {
            $iportal = DB::connection('iportal');

            $studyGroupName = null;
            $eduOpName = null;
            $eduProgramName = null;

            if ($studyGroupId) {
                $studyGroupName = $iportal->table('portal_agroups')
                    ->where('id', $studyGroupId)
                    ->value('name');
            }

            if ($eduOpId) {
                $eduOpName = $iportal->table('portal_sp_edu_op')
                    ->where('id', $eduOpId)
                    ->value('name_ru');
            }

            if ($eduProgramId) {
                $eduProgramName = $iportal->table('portal_sp_group_edu_op')
                    ->where('id', $eduProgramId)
                    ->value('name_ru');
            }

            return [
                'study_group_name' => $studyGroupName,
                'edu_op_name' => $eduOpName,
                'edu_program_name' => $eduProgramName,
            ];
        } catch (\Throwable $e) {
            report($e);

            return [
                'study_group_name' => null,
                'edu_op_name' => null,
                'edu_program_name' => null,
            ];
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
