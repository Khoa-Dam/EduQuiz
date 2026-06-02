<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduQuiz') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=eduquiz-1">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <x-loading-overlay />

        <main class="h-[100dvh] overflow-hidden bg-[#d9d8e8]">
            <div class="absolute inset-y-0 left-0 hidden w-1/2 bg-white/45 lg:block"></div>
            <div class="absolute inset-x-0 top-0 h-[520px] bg-[radial-gradient(circle_at_18%_10%,_rgba(255,255,255,0.65),_transparent_28%),radial-gradient(circle_at_75%_18%,_rgba(109,50,245,0.14),_transparent_24%)]"></div>

            <div class="relative z-10 mx-auto grid h-full w-full max-w-6xl items-center gap-5 px-4 py-4 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:px-8">
                <section class="hidden h-[calc(100dvh-2rem)] max-h-[620px] min-h-0 rounded-[2rem] border border-white/80 bg-white p-6 text-slate-950 shadow-2xl shadow-slate-400/25 lg:flex lg:flex-col lg:justify-between">
                    <a href="/" class="inline-flex w-fit items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-950 text-base font-black text-white">EQ</span>
                        <span>
                            <span class="block text-lg font-black tracking-tight">EduQuiz</span>
                            <span class="block text-xs font-bold uppercase tracking-[0.18em] text-violet-700">Mini Quiz LMS</span>
                        </span>
                    </a>

                    <div>
                        <p class="text-sm font-bold text-violet-700">Learn. Practice. Review.</p>
                        <h1 class="mt-3 max-w-md text-3xl font-black leading-tight tracking-tight text-slate-950">A calm sign-in space for quiz learning.</h1>
                        <p class="mt-4 max-w-lg text-sm leading-6 text-slate-600">Admins manage content. Students submit quizzes. Results stay organized for a short demo.</p>
                    </div>

                    <div class="grid gap-3">
                        <div class="rounded-3xl bg-violet-600 p-5 text-white shadow-xl shadow-violet-300/40">
                            <p class="text-sm font-black">Admin flow</p>
                            <p class="mt-1 text-sm leading-6 text-violet-100">Create courses, quizzes, questions, and review student attempts.</p>
                        </div>
                        <div class="rounded-3xl border border-yellow-200 bg-yellow-50 p-5">
                            <p class="text-sm font-black text-slate-950">Student flow</p>
                            <p class="mt-1 text-sm leading-6 text-slate-600">Browse active courses, take quizzes, and view result history.</p>
                        </div>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-md">
                    <div class="mb-5 flex items-center justify-between gap-4 lg:hidden">
                        <a href="/" class="inline-flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-sm font-black text-white">EQ</span>
                            <span>
                                <span class="block text-base font-black tracking-tight text-slate-950">EduQuiz</span>
                                <span class="block text-xs font-bold uppercase tracking-[0.16em] text-violet-700">Mini Quiz LMS</span>
                            </span>
                        </a>
                    </div>

                    <div class="rounded-[2rem] border border-white/80 bg-white/95 p-5 shadow-2xl shadow-slate-300/70 backdrop-blur sm:p-6">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
