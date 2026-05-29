<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Password help</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Reset your password</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            {{ __('Enter your email address and we will send you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4" x-data="{ submitting: false }" x-on:submit="submitting = true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full" x-bind:disabled="submitting">
                <span x-show="! submitting">{{ __('Email Password Reset Link') }}</span>
                <span x-cloak x-show="submitting">Sending...</span>
            </x-primary-button>
        </div>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('login') }}" class="text-sm font-semibold text-emerald-700 transition hover:text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            Back to login
        </a>
    </div>
</x-guest-layout>
