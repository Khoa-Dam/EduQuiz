<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="EduQuiz is a Laravel Blade mini LMS for courses, quizzes, scoring, and attempt review.">

        <title>EduQuiz - Mini Quiz LMS</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <main class="min-h-screen overflow-hidden bg-slate-950 text-white">
            <div class="absolute inset-x-0 top-0 h-[560px] bg-[radial-gradient(circle_at_20%_10%,_rgba(16,185,129,0.28),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(45,212,191,0.12),_transparent_26%)]"></div>

            <nav class="relative z-10">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-950">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400 text-base font-black text-slate-950 shadow-lg shadow-emerald-500/20">EQ</span>
                        <span>
                            <span class="block text-lg font-black tracking-tight">EduQuiz</span>
                            <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-200">Mini Quiz LMS</span>
                        </span>
                    </a>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-xl border border-white/15 px-4 py-2 text-sm font-bold text-white transition hover:bg-white/10">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-xl px-4 py-2 text-sm font-bold text-slate-200 transition hover:bg-white/10 hover:text-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-xl bg-emerald-400 px-4 py-2 text-sm font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-300">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <section class="relative z-10 mx-auto grid max-w-7xl items-center gap-8 px-5 pb-14 pt-8 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:pb-16 lg:pt-12">
                <div class="max-w-3xl">
                    <p class="text-sm font-bold text-emerald-200">Laravel Blade learning workspace</p>
                    <h1 class="mt-4 max-w-4xl text-4xl font-black leading-[1.05] tracking-tight sm:text-5xl lg:text-6xl">
                        Courses, quizzes, and results in one clear demo flow.
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300">
                        EduQuiz shows a complete Laravel MVC workflow: admins prepare learning content, students take quizzes, and every attempt stays easy to review.
                    </p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-400 px-5 py-3 text-sm font-black text-slate-950 shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-300">
                            Start demo
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-white/10">
                                Create student account
                            </a>
                        @endif
                    </div>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-4 shadow-2xl shadow-emerald-950/40 backdrop-blur">
                    <div class="overflow-hidden rounded-3xl bg-slate-50 text-slate-950">
                        <div class="border-b border-slate-200 bg-white p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">Demo board</p>
                                    <p class="mt-1 text-xl font-black">Quiz operations</p>
                                </div>
                                <span class="eq-status-badge bg-emerald-50 text-emerald-800 ring-emerald-200">Ready</span>
                            </div>
                        </div>
                        <div class="grid gap-3 p-5">
                            <div class="rounded-2xl bg-slate-950 p-4 text-white">
                                <p class="text-sm font-bold text-emerald-200">Admin workspace</p>
                                <p class="mt-2 text-sm leading-6 text-slate-300">Create courses, quizzes, questions, and answers from simple Blade screens.</p>
                            </div>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div class="rounded-2xl bg-white p-4 shadow-sm shadow-slate-200/70">
                                    <p class="text-3xl font-black tabular-nums text-slate-950">3</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-600">Core student steps</p>
                                </div>
                                <div class="rounded-2xl bg-emerald-50 p-4 shadow-sm shadow-emerald-100">
                                    <p class="text-3xl font-black tabular-nums text-emerald-900">100%</p>
                                    <p class="mt-1 text-sm font-semibold text-emerald-900">Saved scoring flow</p>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-white p-4 shadow-sm shadow-slate-200/70">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-bold">Student takes quiz</p>
                                    <span class="text-xs font-bold text-emerald-700">Result saved</span>
                                </div>
                                <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full w-3/4 rounded-full bg-emerald-400"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="relative z-10 bg-slate-100 text-slate-950">
                <div class="mx-auto max-w-7xl px-5 py-14 lg:px-8">
                    <div class="grid gap-8 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
                        <div>
                            <p class="text-sm font-bold text-emerald-700">What the demo proves</p>
                            <h2 class="mt-2 text-3xl font-black tracking-tight">A small LMS with the important pieces visible.</h2>
                            <p class="mt-4 text-sm leading-6 text-slate-600">The interface is built for a short recording: each page makes the role, action, and result clear without adding extra features.</p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <article class="eq-feature-card md:col-span-2">
                                <p class="text-sm font-bold text-emerald-700">Course management</p>
                                <h3 class="mt-2 text-xl font-black">Build the learning path first</h3>
                                <p class="mt-2 eq-muted">Admins create courses, attach quizzes, and control publishing status.</p>
                            </article>
                            <article class="eq-feature-card">
                                <p class="text-sm font-bold text-emerald-700">Practice quizzes</p>
                                <h3 class="mt-2 text-lg font-black">Students answer focused questions</h3>
                                <p class="mt-2 eq-muted">Each question stores one selected answer for scoring.</p>
                            </article>
                            <article class="eq-feature-card">
                                <p class="text-sm font-bold text-emerald-700">Result tracking</p>
                                <h3 class="mt-2 text-lg font-black">Attempts stay reviewable</h3>
                                <p class="mt-2 eq-muted">Students see history while admins review submitted results.</p>
                            </article>
                        </div>
                    </div>

                    <div class="mt-10 grid gap-4 rounded-3xl bg-white p-5 shadow-xl shadow-slate-200/70 md:grid-cols-2">
                        <div class="rounded-2xl bg-slate-950 p-5 text-white">
                            <p class="text-sm font-bold text-emerald-200">Admin flow</p>
                            <p class="mt-3 text-sm leading-6 text-slate-300">Log in, manage courses and quizzes, add questions and answers, then review attempts.</p>
                        </div>
                        <div class="rounded-2xl bg-emerald-50 p-5 text-slate-950">
                            <p class="text-sm font-bold text-emerald-800">Student flow</p>
                            <p class="mt-3 text-sm leading-6 text-emerald-950">Log in, browse courses, start a quiz, submit answers, and review score history.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
