<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <main class="min-h-screen bg-slate-50">
            <div class="mx-auto grid min-h-screen w-full max-w-6xl items-center gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[0.82fr_1fr] lg:px-8">
                <section class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-slate-950 p-6 text-white shadow-sm shadow-slate-300/60 lg:block">
                    <a href="/" class="inline-flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-950">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-400 text-base font-black text-slate-950">EQ</span>
                        <span>
                            <span class="block text-lg font-bold tracking-tight">EduQuiz</span>
                            <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-emerald-200">Mini Quiz LMS</span>
                        </span>
                    </a>

                    <div class="mt-10 max-w-lg">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-200">Learn. Practice. Review.</p>
                        <h1 class="mt-3 text-3xl font-black tracking-tight text-white">Sign in to continue your quiz workflow.</h1>
                        <p class="mt-4 text-sm leading-6 text-slate-300">
                            EduQuiz keeps the demo flow focused: admins manage learning content, students take quizzes, and results stay easy to review.
                        </p>
                    </div>

                    <div class="mt-8 grid gap-3">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                            <p class="text-sm font-semibold text-white">Admin flow</p>
                            <p class="mt-2 text-sm leading-6 text-slate-300">Create courses, quizzes, questions, and review submitted attempts.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                            <p class="text-sm font-semibold text-white">Student flow</p>
                            <p class="mt-2 text-sm leading-6 text-slate-300">Browse active courses, answer quiz questions, and view scores and history.</p>
                        </div>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-md">
                    <div class="mb-5 flex items-center justify-between gap-4 lg:hidden">
                        <a href="/" class="inline-flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-sm font-black text-white">EQ</span>
                            <span>
                                <span class="block text-base font-bold tracking-tight text-slate-950">EduQuiz</span>
                                <span class="block text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700">Mini Quiz LMS</span>
                            </span>
                        </a>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/80 sm:p-6">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
