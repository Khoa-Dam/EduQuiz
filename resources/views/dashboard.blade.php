<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Student workspace</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Student Dashboard</h2>
            </div>
            <a href="{{ route('courses.index') }}" class="eq-btn-primary">Browse courses</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_20rem]">
                <div class="eq-hero-panel bg-[linear-gradient(135deg,_#064e3b_0%,_#0f172a_58%,_#312e81_100%)] text-white">
                    <div class="grid gap-6 lg:grid-cols-[1.08fr_0.92fr] lg:items-center">
                    <div>
                        <p class="inline-flex items-center rounded-2xl bg-white/10 px-3 py-1 text-xs font-black text-emerald-200 ring-1 ring-white/10">Welcome back, {{ Auth::user()->name }}</p>
                        <h3 class="mt-4 max-w-3xl text-3xl font-black leading-tight tracking-tight text-white">
                            Pick a course, take a quiz, and keep every score organized.
                        </h3>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300">
                            Your student dashboard keeps active learning paths, quiz attempts, and recent progress in one place.
                        </p>
                    </div>

                    <div class="rounded-3xl bg-white p-5 text-slate-950 shadow-xl shadow-slate-950/20">
                        <p class="text-sm font-bold text-emerald-700">Current focus</p>
                        <h4 class="mt-2 text-xl font-black">
                            {{ $latestAttempt ? $latestAttempt->quiz->course->title : ($featuredCourse?->title ?? 'Start with a course') }}
                        </h4>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            {{ $latestAttempt ? 'Last quiz: '.$latestAttempt->quiz->title : 'Choose an active course and complete your first quiz attempt.' }}
                        </p>
                        <div class="mt-5 flex flex-col gap-3 sm:flex-row lg:flex-col">
                            <a href="{{ route('courses.index') }}" class="eq-btn-primary">Continue learning</a>
                            <a href="{{ route('attempts.index') }}" class="eq-btn-secondary">View history</a>
                        </div>
                    </div>
                    </div>
                </div>

                <aside class="eq-card">
                    <p class="text-sm font-black text-slate-950">Learning summary</p>
                    <p class="mt-2 eq-muted">{{ Auth::user()->email }}</p>
                    <div class="mt-5 grid gap-3">
                        <div class="rounded-2xl bg-emerald-50 p-4">
                            <p class="text-xs font-black uppercase tracking-[0.14em] text-emerald-700">Latest attempt</p>
                            <p class="mt-2 text-sm font-black text-slate-950">{{ $latestAttempt?->quiz->title ?? 'No attempt yet' }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $latestAttempt ? 'Score: '.$latestAttempt->score : 'Take a quiz to create history.' }}</p>
                        </div>
                        <a href="{{ route('courses.index') }}" class="eq-btn-secondary">Browse active courses</a>
                    </div>
                </aside>
            </section>

            <section class="mt-6 grid gap-4 sm:grid-cols-3">
                <div class="eq-stat-card">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-500">Active courses</p>
                            <p class="mt-1 text-3xl font-black tabular-nums text-slate-950">{{ $stats['activeCourses'] }}</p>
                        </div>
                        <span class="eq-stat-marker">C</span>
                    </div>
                </div>
                <div class="eq-stat-card">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-500">Active quizzes</p>
                            <p class="mt-1 text-3xl font-black tabular-nums text-slate-950">{{ $stats['activeQuizzes'] }}</p>
                        </div>
                        <span class="eq-stat-marker">Q</span>
                    </div>
                </div>
                <div class="eq-stat-card">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-500">My attempts</p>
                            <p class="mt-1 text-3xl font-black tabular-nums text-slate-950">{{ $stats['attempts'] }}</p>
                        </div>
                        <span class="eq-stat-marker">A</span>
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-4 lg:grid-cols-[1.15fr_0.85fr]">
                <a href="{{ route('courses.index') }}" class="eq-card flex min-h-[180px] flex-col justify-between bg-slate-950 text-white">
                    <div>
                        <p class="text-sm font-bold text-emerald-200">Continue learning</p>
                        <h3 class="mt-3 text-2xl font-black tracking-tight">
                            {{ $latestAttempt ? $latestAttempt->quiz->course->title : ($featuredCourse?->title ?? 'Find your first active course') }}
                        </h3>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300">
                            {{ $latestAttempt ? 'Revisit course content or choose another available quiz.' : 'Browse published courses and open any available quiz to begin.' }}
                        </p>
                    </div>
                    <span class="mt-5 inline-flex text-sm font-black text-emerald-200">Open courses</span>
                </a>

                <div class="grid gap-4">
                    <a href="{{ route('attempts.index') }}" class="eq-card">
                        <p class="text-sm font-bold text-emerald-700">My attempts</p>
                        <h3 class="mt-2 text-lg font-black text-slate-950">Review saved results</h3>
                        <p class="mt-2 eq-muted">Check scores, correct answers, and submitted times.</p>
                    </a>
                    <a href="{{ route('courses.index') }}" class="eq-card">
                        <p class="text-sm font-bold text-emerald-700">Browse courses</p>
                        <h3 class="mt-2 text-lg font-black text-slate-950">Find the next quiz</h3>
                        <p class="mt-2 eq-muted">Only active courses and quizzes are shown to students.</p>
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
