<section>
    <form method="post" action="{{ route('profile.alumni.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="alumni_last_name" :value="__('Фамилия')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <x-text-input id="alumni_last_name" name="last_name" type="text" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition"
                    :value="old('last_name', $alumniProfile->last_name)" required />
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('last_name')" />
            </div>
            <div>
                <x-input-label for="alumni_first_name" :value="__('Имя')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <x-text-input id="alumni_first_name" name="first_name" type="text" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition"
                    :value="old('first_name', $alumniProfile->first_name)" required />
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('first_name')" />
            </div>
        </div>

        <div>
            <x-input-label for="alumni_middle_name" :value="__('Отчество')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
            <x-text-input id="alumni_middle_name" name="middle_name" type="text" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition"
                :value="old('middle_name', $alumniProfile->middle_name)" />
            <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('middle_name')" />
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="alumni_school" :value="__('Школа / Факультет')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <select id="alumni_school" name="school"
                    class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition appearance-none bg-no-repeat bg-[length:1rem] bg-[right_0.5rem_center]"
                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%232B2B2B%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27M6 8l4 4 4-4%27/%3E%3C/svg%3E');">
                    <option value="ШИ" {{ old('school', $alumniProfile->school) == 'ШИ' ? 'selected' : '' }}>Школа Инженерии (ШИ)</option>
                    <option value="ША" {{ old('school', $alumniProfile->school) == 'ША' ? 'selected' : '' }}>Школа Архитектуры (ША)</option>
                    <option value="ШС" {{ old('school', $alumniProfile->school) == 'ШС' ? 'selected' : '' }}>Школа Строительства (ШС)</option>
                    <option value="ШД" {{ old('school', $alumniProfile->school) == 'ШД' ? 'selected' : '' }}>Школа Дизайна (ШД)</option>
                    <option value="КАУ" {{ old('school', $alumniProfile->school) == 'КАУ' ? 'selected' : '' }}>Казахско-Американский университет (КАУ)</option>
                </select>
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('school')" />
            </div>
            <div>
                <x-input-label for="alumni_graduation_year" :value="__('Год выпуска')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <x-text-input id="alumni_graduation_year" name="graduation_year" type="number" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition"
                    :value="old('graduation_year', $alumniProfile->graduation_year)" min="1990" :max="date('Y')" required />
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('graduation_year')" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="alumni_study_form_name" :value="__('Форма обучения')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <x-text-input id="alumni_study_form_name" name="study_form_name" type="text" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition"
                    :value="old('study_form_name', $alumniProfile->study_form_name)" />
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('study_form_name')" />
            </div>
            <div>
                <x-input-label for="alumni_study_level_name" :value="__('Степень')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <x-text-input id="alumni_study_level_name" name="study_level_name" type="text" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition"
                    :value="old('study_level_name', $alumniProfile->study_level_name)" />
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('study_level_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <x-input-label for="alumni_edu_program_name" :value="__('ГОП')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <select id="alumni_edu_program_name" name="edu_program" class="js-portal-select js-gop-select mt-1 block w-full">
                    <option value="">Выберите ГОП</option>
                    @foreach(($portalOptions['gops'] ?? collect()) as $gop)
                        <option value="{{ $gop->id }}" {{ (string) old('edu_program', $alumniProfile->edu_program) === (string) $gop->id ? 'selected' : '' }}>
                            {{ $gop->name_ru }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('edu_program')" />
            </div>
            <div>
                <x-input-label for="alumni_edu_op_name" :value="__('ОП')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <select id="alumni_edu_op_name" name="edu_op" class="js-portal-select js-op-select mt-1 block w-full">
                    <option value="">Выберите ОП</option>
                    @foreach(($portalOptions['ops'] ?? collect()) as $op)
                        <option value="{{ $op->id }}" data-gop-id="{{ $op->group_op_id }}" {{ (string) old('edu_op', $alumniProfile->edu_op) === (string) $op->id ? 'selected' : '' }}>
                            {{ $op->name_ru }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('edu_op')" />
            </div>
            <div>
                <x-input-label for="alumni_study_group_name" :value="__('Группа')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <select id="alumni_study_group_name" name="study_group" class="js-portal-select js-group-select mt-1 block w-full">
                    <option value="">Выберите группу</option>
                    @foreach(($portalOptions['groups'] ?? collect()) as $group)
                        <option value="{{ $group->id }}" data-op-id="{{ $group->edu_op }}" {{ (string) old('study_group', $alumniProfile->study_group) === (string) $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('study_group')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-[#8F161C] text-white px-8 py-3 rounded-lg font-semibold uppercase tracking-wider text-sm hover:bg-[#5E0F14] transition-colors duration-200 active:scale-95">
                {{ __('СОХРАНИТЬ ПРОФИЛЬ ВЫПУСКНИКА') }}
            </button>
        </div>
    </form>

    @once
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const $all = $('.js-portal-select');
                const $gop = $('.js-gop-select');
                const $op = $('.js-op-select');
                const $group = $('.js-group-select');

                $all.select2({
                    width: '100%',
                    placeholder: 'Выберите значение',
                    allowClear: true
                });

                const $opOptions = $op.find('option').clone();
                const $groupOptions = $group.find('option').clone();

                function rebuildOpsByGop(gopId) {
                    const current = $op.val();
                    const filtered = $opOptions.filter(function () {
                        const val = $(this).attr('value');
                        if (!val) return true;
                        return !gopId || $(this).data('gop-id') == gopId;
                    });

                    $op.empty().append(filtered);
                    $op.prop('disabled', !gopId);
                    if ($op.find('option[value="' + current + '"]').length) {
                        $op.val(current);
                    } else {
                        $op.val('');
                    }
                    $op.trigger('change.select2');
                }

                function rebuildGroupsByOp(opId) {
                    const current = $group.val();
                    const filtered = $groupOptions.filter(function () {
                        const val = $(this).attr('value');
                        if (!val) return true;
                        return !opId || $(this).data('op-id') == opId;
                    });

                    $group.empty().append(filtered);
                    $group.prop('disabled', !opId);
                    if ($group.find('option[value="' + current + '"]').length) {
                        $group.val(current);
                    } else {
                        $group.val('');
                    }
                    $group.trigger('change.select2');
                }

                $gop.on('change', function () {
                    rebuildOpsByGop($gop.val());
                    rebuildGroupsByOp('');
                });

                $op.on('change', function () {
                    rebuildGroupsByOp($op.val());
                });

                // Первичная синхронизация для уже сохраненных значений.
                rebuildOpsByGop($gop.val());
                rebuildGroupsByOp($op.val());
            });
        </script>
    @endonce
</section>
