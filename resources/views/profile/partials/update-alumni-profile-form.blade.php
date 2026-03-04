<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Профиль выпускника') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Редактируйте данные выпускника: ФИО, школа, год выпуска, факультет, форма обучения, степень.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.alumni.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="alumni_last_name" :value="__('Фамилия')" />
                <x-text-input id="alumni_last_name" name="last_name" type="text" class="mt-1 block w-full"
                    :value="old('last_name', $alumniProfile->last_name)" required />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
            <div>
                <x-input-label for="alumni_first_name" :value="__('Имя')" />
                <x-text-input id="alumni_first_name" name="first_name" type="text" class="mt-1 block w-full"
                    :value="old('first_name', $alumniProfile->first_name)" required />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
        </div>

        <div>
            <x-input-label for="alumni_middle_name" :value="__('Отчество')" />
            <x-text-input id="alumni_middle_name" name="middle_name" type="text" class="mt-1 block w-full"
                :value="old('middle_name', $alumniProfile->middle_name)" />
            <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="alumni_school" :value="__('Школа / Факультет')" />
                <select id="alumni_school" name="school"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="ШИ" {{ old('school', $alumniProfile->school) == 'ШИ' ? 'selected' : '' }}>Школа Инженерии (ШИ)</option>
                    <option value="ША" {{ old('school', $alumniProfile->school) == 'ША' ? 'selected' : '' }}>Школа Архитектуры (ША)</option>
                    <option value="ШС" {{ old('school', $alumniProfile->school) == 'ШС' ? 'selected' : '' }}>Школа Строительства (ШС)</option>
                    <option value="ШД" {{ old('school', $alumniProfile->school) == 'ШД' ? 'selected' : '' }}>Школа Дизайна (ШД)</option>
                    <option value="КАУ" {{ old('school', $alumniProfile->school) == 'КАУ' ? 'selected' : '' }}>Казахско-Американский университет (КАУ)</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('school')" />
            </div>
            <div>
                <x-input-label for="alumni_graduation_year" :value="__('Год выпуска')" />
                <x-text-input id="alumni_graduation_year" name="graduation_year" type="number" class="mt-1 block w-full"
                    :value="old('graduation_year', $alumniProfile->graduation_year)" min="1990" :max="date('Y')" required />
                <x-input-error class="mt-2" :messages="$errors->get('graduation_year')" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <x-input-label for="alumni_faculty_name" :value="__('Факультет')" />
                <x-text-input id="alumni_faculty_name" name="faculty_name" type="text" class="mt-1 block w-full"
                    :value="old('faculty_name', $alumniProfile->faculty_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('faculty_name')" />
            </div>
            <div>
                <x-input-label for="alumni_study_form_name" :value="__('Форма обучения')" />
                <x-text-input id="alumni_study_form_name" name="study_form_name" type="text" class="mt-1 block w-full"
                    :value="old('study_form_name', $alumniProfile->study_form_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('study_form_name')" />
            </div>
            <div>
                <x-input-label for="alumni_study_level_name" :value="__('Степень')" />
                <x-text-input id="alumni_study_level_name" name="study_level_name" type="text" class="mt-1 block w-full"
                    :value="old('study_level_name', $alumniProfile->study_level_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('study_level_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <x-input-label for="alumni_study_group_name" :value="__('Группа')" />
                <x-text-input id="alumni_study_group_name" name="study_group_name" type="text" class="mt-1 block w-full"
                    :value="old('study_group_name', $alumniProfile->study_group_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('study_group_name')" />
            </div>
            <div>
                <x-input-label for="alumni_edu_op_name" :value="__('ОП')" />
                <x-text-input id="alumni_edu_op_name" name="edu_op_name" type="text" class="mt-1 block w-full"
                    :value="old('edu_op_name', $alumniProfile->edu_op_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('edu_op_name')" />
            </div>
            <div>
                <x-input-label for="alumni_edu_program_name" :value="__('ГОП')" />
                <x-text-input id="alumni_edu_program_name" name="edu_program_name" type="text" class="mt-1 block w-full"
                    :value="old('edu_program_name', $alumniProfile->edu_program_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('edu_program_name')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Сохранить профиль выпускника') }}</x-primary-button>
            @if (session('status') === 'alumni-profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-gray-600">{{ __('Профиль выпускника сохранён.') }}</p>
            @endif
        </div>
    </form>
</section>
