<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="EduQuiz turns courses and quizzes into a focused mission-style learning workspace.">

        <title>EduQuiz - Quiz Mission Workspace</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=eduquiz-1">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-2xl focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-black focus:text-slate-950 focus:shadow-xl">Skip to content</a>
        <x-loading-overlay />

        <main id="main-content" class="min-h-screen overflow-hidden bg-[#d9d8e8] text-slate-950">
            <div class="pointer-events-none fixed inset-0 bg-[radial-gradient(circle_at_12%_8%,_rgba(255,255,255,0.62),_transparent_28%),radial-gradient(circle_at_88%_0%,_rgba(109,50,245,0.12),_transparent_25%)]"></div>

            <nav class="relative z-10 px-4 py-4 sm:px-6 lg:px-8" aria-label="Primary">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 rounded-2xl border border-white/80 bg-white/90 px-4 py-3 shadow-xl shadow-slate-400/25 backdrop-blur">
                    <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-600 text-sm font-black text-white shadow-lg shadow-violet-300/40">EQ</span>
                        <span class="min-w-0">
                            <span class="block text-base font-black tracking-tight text-slate-950">EduQuiz</span>
                            <span class="block text-[0.68rem] font-black uppercase tracking-[0.14em] text-violet-700">Quiz missions</span>
                        </span>
                    </a>

                    @if (Route::has('login'))
                        <div class="flex shrink-0 items-center gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="eq-btn-primary px-4 py-2">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-xl px-3 py-2 text-sm font-black text-slate-700 transition hover:bg-violet-50 hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-violet-500 sm:px-4">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="eq-btn-primary px-4 py-2">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <section class="relative z-10 mx-auto grid max-w-7xl gap-6 px-4 pb-10 pt-5 sm:px-6 lg:grid-cols-[minmax(0,1.05fr)_25rem] lg:items-stretch lg:px-8 lg:pb-14 lg:pt-8">
                <div class="eq-hero-panel eq-game-hero" data-gsap-hero>
                    <div class="grid h-full gap-8 p-1 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-center">
                        <div>
                            <p class="inline-flex items-center rounded-2xl bg-violet-50 px-3 py-1 text-xs font-black uppercase tracking-[0.12em] text-violet-700 ring-1 ring-violet-100">
                                Laravel Blade learning arena
                            </p>
                            <h1 class="mt-5 max-w-4xl text-4xl font-black leading-[1.02] tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                                Run courses, launch quizzes, and track every win.
                            </h1>
                            <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600">
                                EduQuiz gives admins a focused quiz studio and gives students a mission board with XP, attempts, and clear next steps.
                            </p>

                            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="eq-btn-primary px-5 py-3">Open dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="eq-btn-primary px-5 py-3">Start demo</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="eq-btn-secondary px-5 py-3">Create student account</a>
                                    @endif
                                @endauth
                            </div>

                            <div class="mt-8 grid gap-3 sm:grid-cols-3">
                                <div class="eq-game-chip">
                                    <span>Admin studio</span>
                                    <strong>01</strong>
                                </div>
                                <div class="eq-game-chip">
                                    <span>Student XP</span>
                                    <strong>120</strong>
                                </div>
                                <div class="eq-game-chip">
                                    <span>Attempt log</span>
                                    <strong>24/7</strong>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-[1.25rem] bg-violet-600 p-5 text-white shadow-lg shadow-violet-300/40">
                            <p class="text-xs font-black uppercase tracking-[0.14em] text-violet-100">Mission status</p>
                            <h2 class="mt-3 text-2xl font-black tracking-tight">Ready to launch</h2>
                            <p class="mt-3 text-sm font-semibold leading-6 text-violet-100">
                                Build a quiz, publish only when complete, then review student results from one workflow.
                            </p>
                            <div class="mt-5 rounded-2xl bg-white/10 p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-xs font-black uppercase tracking-[0.14em] text-violet-100">Readiness</span>
                                    <span class="text-sm font-black text-white">85%</span>
                                </div>
                                <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full w-[85%] rounded-full bg-yellow-300"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="eq-card flex flex-col justify-between" data-gsap-reveal>
                    <div>
                        <p class="text-sm font-black text-violet-700">Demo paths</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Two roles, one clean flow.</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            The first screen now matches the same workspace style used after login.
                        </p>
                    </div>

                    <div class="mt-6 grid gap-3">
                        <a href="{{ route('login') }}" class="rounded-[1.15rem] border border-slate-100 bg-slate-50 p-4 transition hover:-translate-y-0.5 hover:border-violet-200 hover:bg-violet-50">
                            <span class="block text-sm font-black text-slate-950">Student mission board</span>
                            <span class="mt-1 block text-sm font-semibold text-slate-600">Browse courses, take quizzes, earn XP.</span>
                        </a>
                        <a href="{{ route('login') }}" class="rounded-[1.15rem] border border-violet-100 bg-violet-50 p-4 transition hover:-translate-y-0.5 hover:bg-white">
                            <span class="block text-sm font-black text-slate-950">Admin quiz studio</span>
                            <span class="mt-1 block text-sm font-semibold text-slate-600">Create, check readiness, publish, review.</span>
                        </a>
                        <a href="{{ route('login') }}" class="rounded-[1.15rem] bg-yellow-300 p-4 text-slate-950 shadow-lg shadow-yellow-200 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-black">Result review</span>
                            <span class="mt-1 block text-sm font-semibold text-slate-700">Inspect score, answer, and attempt history.</span>
                        </a>
                    </div>
                </aside>
            </section>

            <section class="relative z-10 mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
                <div class="grid gap-5 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
                    <div data-gsap-reveal>
                        <p class="text-sm font-black text-violet-700">What changed on the front page</p>
                        <h2 class="mt-2 max-w-xl text-3xl font-black tracking-tight text-slate-950">
                            The landing screen now previews the real product experience.
                        </h2>
                        <p class="mt-4 max-w-xl text-sm leading-6 text-slate-600">
                            Instead of the older green demo board, the homepage now introduces the same learning game, studio, and progress language used across EduQuiz.
                        </p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <article class="eq-card md:col-span-2" data-gsap-reveal>
                            <p class="text-sm font-bold text-violet-700">Quiz Builder</p>
                            <h3 class="mt-2 text-xl font-black text-slate-950">Build complete quizzes before students see them.</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Admins work from a studio-style flow with readiness checks and publish controls.</p>
                        </article>
                        <article class="eq-card" data-gsap-reveal>
                            <p class="text-sm font-bold text-violet-700">Student XP</p>
                            <h3 class="mt-2 text-lg font-black text-slate-950">Attempts feel like short missions.</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Students see progress, streak context, and saved quiz history.</p>
                        </article>
                        <article class="eq-card" data-gsap-reveal>
                            <p class="text-sm font-bold text-violet-700">Review loop</p>
                            <h3 class="mt-2 text-lg font-black text-slate-950">Results stay easy to inspect.</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Admins can review submissions while students keep their own attempt record.</p>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
