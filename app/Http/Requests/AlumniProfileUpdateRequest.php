<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumniProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $profile = $this->user()->alumniProfile;
        return $profile && $profile->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'school' => ['required', 'in:ШИ,ША,ШС,ШД,КАУ'],
            'graduation_year' => ['required', 'integer', 'min:1990', 'max:' . (int) date('Y')],
            'faculty_name' => ['nullable', 'string', 'max:255'],
            'study_form_name' => ['nullable', 'string', 'max:255'],
            'study_level_name' => ['nullable', 'string', 'max:255'],
            'study_group_name' => ['nullable', 'string', 'max:255'],
            'edu_op_name' => ['nullable', 'string', 'max:255'],
            'edu_program_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'school' => 'Школа/Факультет',
            'graduation_year' => 'Год выпуска',
            'faculty_name' => 'Факультет',
            'study_form_name' => 'Форма обучения',
            'study_level_name' => 'Степень',
            'study_group_name' => 'Группа',
            'edu_op_name' => 'ОП',
            'edu_program_name' => 'ГОП',
        ];
    }
}
