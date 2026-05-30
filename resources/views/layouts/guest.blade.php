<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduQuiz') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <x-loading-overlay />

        <main class="min-h-screen overflow-hidden bg-[#eef4ed]">
            <div class="absolute inset-y-0 left-0 hidden w-1/2 bg-slate-950 lg:block"></div>
            <div class="absolute inset-x-0 top-0 h-[520px] bg-[radial-gradient(circle_at_18%_10%,_rgba(16,185,129,0.24),_transparent_28%),radial-gradient(circle_at_75%_18%,_rgba(124,58,237,0.10),_transparent_24%)]"></div>

            <div class="relative z-10 mx-auto grid min-h-screen w-full max-w-6xl items-center gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:px-8">
                <section class="hidden min-h-[680px] rounded-[2.25rem] border border-white/10 bg-[radial-gradient(circle_at_25%_15%,_rgba(16,185,129,0.30),_transparent_26%),linear-gradient(135deg,_#0f172a_0%,_#052e2b_55%,_#111827_100%)] p-7 text-white shadow-2xl shadow-emerald-950/30 lg:flex lg:flex-col lg:justify-between">
                    <a href="/" class="inline-flex w-fit items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-950">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400 text-base font-black text-slate-950">EQ</span>
                        <span>
                            <span class="block text-lg font-black tracking-tight">EduQuiz</span>
                            <span class="block text-xs font-bold uppercase tracking-[0.18em] text-emerald-200">Mini Quiz LMS</span>
                        </span>
                    </a>

                    <div>
                        <p class="text-sm font-bold text-emerald-200">Learn. Practice. Review.</p>
                        <h1 class="mt-3 max-w-md text-4xl font-black leading-tight tracking-tight text-white">A calm sign-in space for quiz learning.</h1>
                        <p class="mt-4 max-w-lg text-sm leading-6 text-slate-300">Admins manage content. Students submit quizzes. Results stay organized for a short demo.</p>
                    </div>

                    <div class="grid gap-3">
                        <div class="rounded-3xl bg-white p-5 text-slate-950 shadow-xl shadow-emerald-950/20">
                            <p class="text-sm font-black">Admin flow</p>
                            <p class="mt-1 text-sm leading-6 text-slate-600">Create courses, quizzes, questions, and review student attempts.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5">
                            <p class="text-sm font-black text-white">Student flow</p>
                            <p class="mt-1 text-sm leading-6 text-slate-300">Browse active courses, take quizzes, and view result history.</p>
                        </div>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-md">
                    <div class="mb-5 flex items-center justify-between gap-4 lg:hidden">
                        <a href="/" class="inline-flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-950">
                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-400 text-sm font-black text-slate-950">EQ</span>
                            <span>
                                <span class="block text-base font-black tracking-tight text-white">EduQuiz</span>
                                <span class="block text-xs font-bold uppercase tracking-[0.16em] text-emerald-200">Mini Quiz LMS</span>
                            </span>
                        </a>
                    </div>

                    <div class="rounded-[2rem] border border-white/80 bg-white/95 p-5 shadow-2xl shadow-slate-300/70 backdrop-blur sm:p-7">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
