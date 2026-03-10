<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="name" :value="__('Имя')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-[#2B2B2B] mb-1" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border border-[#D9D9D9] rounded-lg px-4 py-2.5 bg-white text-[#2B2B2B] focus:ring-2 focus:ring-[#8F161C] focus:border-[#8F161C] hover:border-[#C56A6E] transition" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="text-[#C56A6E] text-sm mt-1" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-700">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="underline text-sm text-[#8F161C] hover:text-[#5E0F14] rounded-md focus:outline-none focus:ring-2 focus:ring-[#8F161C]">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm text-[#5E0F14]">{{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-[#8F161C] text-white px-8 py-3 rounded-lg font-semibold uppercase tracking-wider text-sm hover:bg-[#5E0F14] transition-colors duration-200 active:scale-95">
                {{ __('Сохранить') }}
            </button>
        </div>
    </form>
</section>
