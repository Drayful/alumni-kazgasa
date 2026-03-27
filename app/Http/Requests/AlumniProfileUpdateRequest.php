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
            'study_form_name' => ['nullable', 'string', 'max:255'],
            'study_level_name' => ['nullable', 'string', 'max:255'],
            'study_group' => ['nullable', 'integer'],
            'edu_op' => ['nullable', 'integer'],
            'edu_program' => ['nullable', 'integer'],
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
            'study_form_name' => 'Форма обучения',
            'study_level_name' => 'Степень',
            'study_group' => 'Группа',
            'edu_op' => 'ОП',
            'edu_program' => 'ГОП',
        ];
    }
}
