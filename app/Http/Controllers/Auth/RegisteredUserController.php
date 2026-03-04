<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AlumniProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'iin' => ['required', 'digits:12', 'unique:alumni_profiles,iin'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'graduation_year' => ['required', 'integer', 'min:1990', 'max:' . date('Y')],
            'school' => ['required', 'in:ШИ,ША,ШС,ШД,КАУ'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'iin.required' => 'ИИН обязателен для заполнения',
            'iin.digits' => 'ИИН должен содержать 12 цифр',
            'iin.unique' => 'Выпускник с таким ИИН уже зарегистрирован',
            'graduation_year.required' => 'Выберите год выпуска',
            'school.required' => 'Выберите школу',
        ]);

        DB::beginTransaction();

        try {
            // Ищем данные в iPortal по году выпуска и ИИН (не блокируем регистрацию при отсутствии)
            $portalData = $this->fetchFromIportal($request->iin, $request->graduation_year);
            $verificationStatus = $portalData ? 'verified' : 'pending';

            // Создаем пользователя
            $user = User::create([
                'name' => trim($request->last_name . ' ' . $request->first_name),
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Создаем профиль выпускника (подтягиваем группу, форму, факультет, ОП, ГОП из iPortal или оставляем пустыми)
            AlumniProfile::create([
                'user_id' => $user->id,
                'iin' => $request->iin,
                'portal_persons_id' => $portalData['portal_persons_id'] ?? null,
                'first_name' => $portalData['first_name'] ?? $request->first_name,
                'last_name' => $portalData['last_name'] ?? $request->last_name,
                'middle_name' => $portalData['middle_name'] ?? $request->middle_name,
                'school' => $portalData['school'] ?? $request->school,
                'graduation_year' => $request->graduation_year,
                'specialty' => $portalData['specialty'] ?? null,
                'study_group' => $portalData['study_group'] ?? null,
                'study_group_name' => $portalData['study_group_name'] ?? null,
                'study_form' => $portalData['study_form'] ?? null,
                'study_form_name' => $portalData['study_form_name'] ?? null,
                'institut_id' => $portalData['institut_id'] ?? null,
                'faculty_name' => $portalData['faculty_name'] ?? null,
                'edu_op' => $portalData['edu_op'] ?? null,
                'edu_op_name' => $portalData['edu_op_name'] ?? null,
                'edu_program' => $portalData['edu_program'] ?? null,
                'edu_program_name' => $portalData['edu_program_name'] ?? null,
                'study_level_name' => $portalData['study_level_name'] ?? null,
                'status' => 'Connect',
                'public_id' => AlumniProfile::generatePublicId(),
                'verification_status' => $verificationStatus,
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            if ($verificationStatus === 'verified') {
                return redirect(route('dashboard', absolute: false))->with('success',
                    'Регистрация успешна! Данные подтянуты из iPortal. Добро пожаловать в Alumni KazGASA!');
            }

            return redirect(route('dashboard', absolute: false))->with('success',
                'Регистрация успешна! Данные по iPortal не найдены — заполните или отредактируйте профиль в разделе «Профиль».');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Ошибка при регистрации: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Поиск данных в iPortal по ИИН и году выпуска.
     * 1) Сначала ищем в portal_persons + portal_persons_d + приказы (order_type_id = 34, год из po.date).
     * 2) Если не найдено — ищем в GRADUATES по iinPlt и году finishOrderDate.
     */
    private function fetchFromIportal(string $iin, int $graduationYear): ?array
    {
        try {
            $iportal = DB::connection('iportal');

            // 1) portal_persons + portal_persons_d + приказы выпуска (order_type_id = 34) + справочники (группа, ОП, ГОП)
            $row = $iportal->table('portal_persons as pp')
                ->leftJoin('portal_persons_d as ppd', 'ppd.student_id', '=', 'pp.id')
                ->leftJoin('portal_order_section_persons as pers', 'pers.person_id', '=', 'pp.id')
                ->leftJoin('portal_order_sections as sec', 'sec.id', '=', 'pers.section_id')
                ->leftJoin('portal_orders as po', 'po.id', '=', 'sec.order_id')
                ->leftJoin('portal_agroups as pa', 'pa.id', '=', 'pp.study_group')
                ->leftJoin('portal_sp_edu_op as op', 'op.id', '=', 'pp.edu_op')
                ->leftJoin('portal_sp_group_edu_op as gop', 'gop.id', '=', 'op.group_op_id')
                ->leftJoin('portal_sp_faculties as fac', 'fac.id', '=', 'op.faculty_id')
                ->leftJoin('portal_sp_edu_form as form', 'form.id', '=', 'pp.study_form')
                ->leftJoin('portal_sp_edu_level as level', 'level.id', '=', 'pp.study_level')
                ->where('po.order_type_id', 34)
                ->where('ppd.doc_iin', $iin)
                ->whereYear('po.date', $graduationYear)
                ->select(
                    'pp.id as pp_id',
                    'pp.lastname',
                    'pp.firstname',
                    'pp.middlename',
                    'pp.lastname_rus',
                    'pp.firstname_rus',
                    'pp.middlename_rus',
                    'pp.study_group as pp_study_group',
                    'pp.study_form as pp_study_form',
                    'pp.department_id',
                    'pp.docs_department',
                    'pp.edu_op as pp_edu_op',
                    'pers.edu_op as pers_edu_op',
                    'pers.edu_program',
                    'pers.study_group as pers_study_group',
                    'pers.study_form as pers_study_form',
                    'pa.name as study_group_name',
                    'op.name_ru as edu_op_name',
                    'gop.name_ru as edu_program_name',
                    'fac.name_ru as faculty_name',
                    'form.name_ru as study_form_name',
                    'level.name_ru as study_level_name'
                )
                ->first();

            if ($row && ! empty($row->pp_id)) {
                return [
                    'portal_persons_id' => (int) $row->pp_id,
                    'first_name' => $row->firstname ?? $row->firstname_rus ?? null,
                    'last_name' => $row->lastname ?? $row->lastname_rus ?? null,
                    'middle_name' => $row->middlename ?? $row->middlename_rus ?? null,
                    'school' => null,
                    'specialty' => null,
                    'study_group' => $row->pp_study_group ?? $row->pers_study_group ?? null,
                    'study_form' => $row->pp_study_form ?? $row->pers_study_form ?? null,
                    'institut_id' => $row->department_id ?? $row->docs_department ?? null,
                    'edu_op' => $row->pp_edu_op ?? $row->pers_edu_op ?? null,
                    'edu_program' => $row->edu_program ?? null,
                    'study_group_name' => $row->study_group_name ?? null,
                    'edu_op_name' => $row->edu_op_name ?? null,
                    'edu_program_name' => $row->edu_program_name ?? null,
                    'faculty_name' => $row->faculty_name ?? null,
                    'study_form_name' => $row->study_form_name ?? null,
                    'study_level_name' => $row->study_level_name ?? null,
                ];
            }

            // 2) Ищем в GRADUATES по ИИН и году выпуска
            $graduate = $iportal->table('GRADUATES')
                ->where('iinPlt', $iin)
                ->whereYear('finishOrderDate', $graduationYear)
                ->first();

            if ($graduate) {
                $portalPersonId = (int) $graduate->graduateId;
                $pp = $iportal->table('portal_persons')->where('id', $portalPersonId)->first();

                // Справочники для GRADUATES: ОП, ГОП, степень, форма обучения
                $op = null;
                $gop = null;
                $degree = null;
                $studyForm = null;

                if (! empty($graduate->specializationId)) {
                    $op = $iportal->table('portal_sp_edu_op')
                        ->where('id', $graduate->specializationId)
                        ->first();
                }

                if (! empty($graduate->professionId)) {
                    $gop = $iportal->table('portal_sp_group_edu_op')
                        ->where('id', $graduate->professionId)
                        ->first();
                }

                if (! empty($graduate->degreeId)) {
                    $degree = $iportal->table('epvo_degree_types')
                        ->where('degreeId', $graduate->degreeId)
                        ->first();
                }

                if (! empty($graduate->studyFormId)) {
                    $studyForm = $iportal->table('STUDY_FORMS')
                        ->where('id', $graduate->studyFormId)
                        ->first();
                }

                $data = [
                    'portal_persons_id' => $portalPersonId,
                    'first_name' => $pp ? ($pp->firstname_rus ?? $graduate->firstName) : ($graduate->firstName ?? null),
                    'last_name' => $pp ? ($pp->lastname_rus ?? $graduate->lastName) : ($graduate->lastName ?? null),
                    'middle_name' => $pp ? ($pp->middlename_rus ?? $graduate->patronymic) : ($graduate->patronymic ?? null),
                    'school' => null,
                    // ГОП (группа ОП) из справочника portal_sp_group_edu_op
                    'specialty' => $gop->name_ru ?? null,
                    'study_group' => $pp?->study_group ?? null,
                    // Форма обучения: сначала из portal_persons, затем из GRADUATES/STUDY_FORMS
                    'study_form' => $pp?->study_form ?? $graduate->studyFormId ?? null,
                    'institut_id' => $pp ? ($pp->department_id ?? $pp->docs_department ?? null) : null,
                    // ОП и ГОП из GRADUATES
                    'edu_op' => $graduate->specializationId ?? $pp?->edu_op ?? null,
                    'edu_program' => $graduate->professionId ?? null,
                    // Степень/уровень из epvo_degree_types
                    'degree' => $degree->nameRu ?? null,
                    'study_level_name' => $degree->nameRu ?? null,
                    // Читаемые названия
                    'edu_op_name' => $op->name_ru ?? null,
                    'edu_program_name' => $gop->name_ru ?? null,
                    'study_form_name' => $studyForm->nameRu ?? null,
                    'faculty_name' => null,
                ];

                $sectionPerson = $iportal->table('portal_order_section_persons')
                    ->where('person_id', $portalPersonId)
                    ->orderByDesc('id')
                    ->first();
                if ($sectionPerson) {
                    $data['edu_program'] = $sectionPerson->edu_program ?? null;
                    if ($data['edu_op'] === null) {
                        $data['edu_op'] = $sectionPerson->edu_op ?? null;
                    }
                    if ($data['study_group'] === null) {
                        $data['study_group'] = $sectionPerson->study_group ?? null;
                    }
                    if ($data['study_form'] === null) {
                        $data['study_form'] = $sectionPerson->study_form ?? null;
                    }
                }

                return $data;
            }

            return null;

        } catch (\Exception $e) {
            \Log::error('iPortal fetch failed: ' . $e->getMessage());
            return null;
        }
    }
}
