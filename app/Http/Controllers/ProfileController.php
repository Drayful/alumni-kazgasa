<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumniProfileUpdateRequest;
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

        // Синхронизируем человекочитаемые названия с выбранными ID из iPortal.
        $names = $this->resolvePortalNames(
            $data['study_group'] ?? null,
            $data['edu_op'] ?? null,
            $data['edu_program'] ?? null
        );

        $request->user()->alumniProfile->update(array_merge($data, $names));

        return Redirect::route('profile.edit')->with('status', 'alumni-profile-updated');
    }

    private function loadPortalOptions(): array
    {
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
            ];
        } catch (\Throwable $e) {
            report($e);

            return [
                'groups' => collect(),
                'ops' => collect(),
                'gops' => collect(),
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
