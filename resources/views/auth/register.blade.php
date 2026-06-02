<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Start learning</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Create your EduQuiz account</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">Join as a student, browse active courses, take quizzes, and keep your attempt history in one place.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ submitting: false }" x-on:submit="submitting = true">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-2 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-2 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Create a password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="mt-2 block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Repeat your password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full" x-bind:disabled="submitting">
                <span x-show="! submitting">{{ __('Register') }}</span>
                <span x-cloak x-show="submitting">Creating account...</span>
            </x-primary-button>
        </div>
    </form>

    <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-center text-sm text-slate-600">
        Already have an account?
        <a class="font-semibold text-emerald-700 transition hover:text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" href="{{ route('login') }}">
            Log in
        </a>
    </div>
</x-guest-layout>
