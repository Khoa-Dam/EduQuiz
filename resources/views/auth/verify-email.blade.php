<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Verify email</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Check your inbox</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you. If you did not receive the email, we will send another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="POST" action="{{ route('verification.send') }}" x-data="{ submitting: false }" x-on:submit="submitting = true">
            @csrf

            <div>
                <x-primary-button class="w-full sm:w-auto" x-bind:disabled="submitting">
                    <span x-show="! submitting">{{ __('Resend Verification Email') }}</span>
                    <span x-cloak x-show="submitting">Sending...</span>
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm font-semibold text-slate-600 transition hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
