<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EduQuiz - Mini Quiz LMS</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <main class="min-h-screen overflow-hidden bg-slate-950 text-white">
            <div class="absolute inset-x-0 top-0 h-64 bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.28),_transparent_34%),radial-gradient(circle_at_top_right,_rgba(14,165,233,0.16),_transparent_28%)]"></div>

            <nav class="relative z-10">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-400 text-sm font-black text-slate-950 shadow-lg shadow-emerald-500/20">EQ</span>
                        <span class="text-lg font-bold tracking-tight">EduQuiz</span>
                    </a>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-xl border border-white/15 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-200 transition hover:text-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 shadow-sm transition hover:bg-emerald-100">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <section class="relative z-10 mx-auto grid max-w-7xl items-center gap-8 px-5 pb-14 pt-8 lg:grid-cols-[1fr_0.82fr] lg:px-8 lg:pb-16 lg:pt-10">
                <div class="max-w-2xl">
                    <p class="eq-badge bg-white/10 text-emerald-100 ring-white/15">Laravel Blade mini LMS</p>
                    <h1 class="mt-5 text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                        Teach with courses. Test with quizzes. Review results clearly.
                    </h1>
                    <p class="mt-5 max-w-xl text-base leading-7 text-slate-300">
                        EduQuiz is a focused Laravel pre-test project for student quiz taking, admin content management, scoring, and attempt review.
                    </p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-400 px-4 py-2.5 text-sm font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-300">
                            Log in to demo
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl border border-white/15 px-4 py-2.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-white/10">
                                Register as student
                            </a>
                        @endif
                    </div>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 shadow-2xl shadow-emerald-950/30 backdrop-blur">
                    <div class="rounded-2xl bg-white p-4 text-slate-950">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-500">Live demo flow</p>
                                <p class="text-lg font-bold">Laravel MVC quiz app</p>
                            </div>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-800">Ready</span>
                        </div>
                        <div class="mt-4 grid gap-3">
                            <div class="rounded-2xl bg-slate-50 p-3.5">
                                <p class="text-sm font-bold">Admin creates learning content</p>
                                <p class="mt-1 text-sm text-slate-600">Courses, quizzes, questions, and answer choices.</p>
                            </div>
                            <div class="rounded-2xl bg-emerald-50 p-3.5">
                                <p class="text-sm font-bold">Student takes a quiz</p>
                                <p class="mt-1 text-sm text-slate-600">One selected answer per question with saved scoring.</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-3.5">
                                <p class="text-sm font-bold">Results stay reviewable</p>
                                <p class="mt-1 text-sm text-slate-600">Students see history. Admins review all attempts.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="relative z-10 border-t border-white/10 bg-white text-slate-950">
                <div class="mx-auto max-w-7xl px-5 py-12 lg:px-8">
                    <div class="max-w-3xl">
                        <h2 class="text-2xl font-black tracking-tight sm:text-3xl">Built for a clear Laravel demo</h2>
                        <p class="mt-3 text-slate-600">The UI keeps the main pre-test requirements easy to find and easy to explain during a short recording.</p>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        <article class="eq-card">
                            <p class="text-sm font-bold text-emerald-700">Course Management</p>
                            <h3 class="mt-2 text-lg font-bold">Organize quiz content</h3>
                            <p class="mt-2 eq-muted">Admins create courses, attach quizzes, and manage publishing status from simple Blade screens.</p>
                        </article>
                        <article class="eq-card">
                            <p class="text-sm font-bold text-emerald-700">Practice Quizzes</p>
                            <h3 class="mt-2 text-lg font-bold">Answer focused questions</h3>
                            <p class="mt-2 eq-muted">Students browse active courses, open quizzes, select answers, and submit with validation.</p>
                        </article>
                        <article class="eq-card">
                            <p class="text-sm font-bold text-emerald-700">Result Tracking</p>
                            <h3 class="mt-2 text-lg font-bold">Review every attempt</h3>
                            <p class="mt-2 eq-muted">Scores, correct counts, selected answers, and attempt history are visible for students and admins.</p>
                        </article>
                    </div>

                    <div class="mt-10 rounded-2xl bg-slate-950 p-5 text-white sm:p-6">
                        <h2 class="text-xl font-black tracking-tight">Demo route</h2>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-sm font-bold text-emerald-200">Admin flow</p>
                                <p class="mt-2 text-sm leading-6 text-slate-300">Log in, manage courses and quizzes, add questions and answers, then review attempts.</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-sm font-bold text-emerald-200">Student flow</p>
                                <p class="mt-2 text-sm leading-6 text-slate-300">Log in, browse courses, start a quiz, submit answers, and review score history.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
