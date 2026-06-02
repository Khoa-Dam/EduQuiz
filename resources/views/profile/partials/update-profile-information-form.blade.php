<section>
    <header>
        <h2 class="text-lg font-black text-slate-950">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm leading-6 text-slate-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6" x-data="{ submitting: false }" x-on:submit="submitting = true">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" value="Profile photo" />
            <div class="mt-2 flex items-center gap-4">
                @if ($user->avatarUrl())
                    <img src="{{ $user->avatarUrl() }}" alt="Profile photo for {{ $user->name }}" class="h-20 w-20 rounded-3xl object-cover shadow-lg shadow-slate-200">
                @else
                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-slate-950 text-xl font-black text-emerald-300 shadow-lg shadow-slate-200">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <div class="min-w-0 flex-1">
                    <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-emerald-950">
                    <p class="mt-2 text-xs font-semibold text-slate-500">JPG, PNG, or WebP. Maximum 2MB.</p>
                </div>
            </div>
            @if ($user->avatarUrl())
                <label class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="remove_avatar" value="1" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                    Remove current photo
                </label>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-slate-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="rounded-xl text-sm font-bold text-emerald-700 hover:text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button x-bind:disabled="submitting">
                <span x-show="! submitting">{{ __('Save') }}</span>
                <span x-cloak x-show="submitting">Saving...</span>
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-semibold text-slate-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
