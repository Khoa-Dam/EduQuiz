@props([
    'code',
    'title',
    'message',
    'ctaLabel' => null,
    'ctaHref' => null,
])

@php
    $safeHref = $ctaHref ?? (auth()->check() ? route('dashboard') : url('/'));
    $safeLabel = $ctaLabel ?? (auth()->check() ? 'Back to dashboard' : 'Back to home');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} - {{ config('app.name', 'EduQuiz') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <x-loading-overlay />

        <main class="eq-app-shell">
            <div class="mx-auto flex min-h-screen max-w-4xl items-center px-4 py-10 sm:px-6 lg:px-8">
                <section class="w-full rounded-3xl border border-white/80 bg-white/90 p-8 text-center shadow-xl shadow-slate-200/80 backdrop-blur sm:p-10">
                    <a href="{{ url('/') }}" class="mx-auto inline-flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-950 text-sm font-black text-emerald-300">EQ</span>
                        <span class="text-left">
                            <span class="block text-lg font-black tracking-tight text-slate-950">EduQuiz</span>
                            <span class="block text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700">Mini Quiz LMS</span>
                        </span>
                    </a>

                    <p class="mt-10 text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Error {{ $code }}</p>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">{{ $title }}</h1>
                    <p class="mx-auto mt-4 max-w-xl text-base leading-7 text-slate-600">{{ $message }}</p>

                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        <a href="{{ $safeHref }}" class="eq-btn-primary">{{ $safeLabel }}</a>
                        <button type="button" onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href = @js($safeHref); }" class="eq-btn-secondary">
                            Go back
                        </button>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
