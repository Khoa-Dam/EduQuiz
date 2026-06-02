<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-violet-700">EduQuiz account</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Welcome back</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">Log in to continue learning or manage your quizzes.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5 rounded-2xl border border-violet-200 bg-violet-50 px-4 py-3 text-sm font-medium text-violet-900" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ submitting: false }" x-on:submit="submitting = true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="student@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-2 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center rounded-xl focus-within:ring-2 focus-within:ring-violet-500 focus-within:ring-offset-2">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-violet-600 shadow-sm focus:ring-violet-500" name="remember">
                <span class="ms-2 text-sm font-medium text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-violet-700 transition hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div>
            <x-primary-button class="w-full" x-bind:disabled="submitting">
                <span x-show="! submitting">{{ __('Log in') }}</span>
                <span x-cloak x-show="submitting">Logging in...</span>
            </x-primary-button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-center text-sm text-slate-600">
            New to EduQuiz?
            <a href="{{ route('register') }}" class="font-semibold text-violet-700 transition hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                Create an account
            </a>
        </div>
    @endif
</x-guest-layout>
