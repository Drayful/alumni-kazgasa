<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Текущий пароль')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition" autocomplete="current-password" />
            <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Новый пароль')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition" autocomplete="new-password" />
            <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Подтвердите пароль')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition" autocomplete="new-password" />
            <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-[#8F161C] text-white px-8 py-3 rounded-lg font-semibold uppercase tracking-wider text-sm hover:bg-[#5E0F14] transition-colors duration-200 active:scale-95">
                {{ __('Сохранить пароль') }}
            </button>
        </div>
    </form>
</section>
