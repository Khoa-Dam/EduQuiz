<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Admin workspace</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">
                Admin Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-hero-panel bg-slate-950 text-white">
                <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold text-emerald-300">Demo control center</p>
                        <h3 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">
                            Manage the learning flow from content to results.
                        </h3>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300">
                            Create courses, attach quizzes, maintain answer choices, and review every submitted attempt from one clear admin area.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.courses.index') }}" class="rounded-2xl bg-white p-4 text-slate-950 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-bold">Courses</span>
                            <span class="mt-1 block text-xs text-slate-600">Build learning paths</span>
                        </a>
                        <a href="{{ route('admin.quizzes.index') }}" class="rounded-2xl bg-white/10 p-4 text-white ring-1 ring-white/10 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-bold">Quizzes</span>
                            <span class="mt-1 block text-xs text-slate-300">Create assessments</span>
                        </a>
                        <a href="{{ route('admin.questions.index') }}" class="rounded-2xl bg-white/10 p-4 text-white ring-1 ring-white/10 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-bold">Questions</span>
                            <span class="mt-1 block text-xs text-slate-300">Manage scoring</span>
                        </a>
                        <a href="{{ route('admin.attempts.index') }}" class="rounded-2xl bg-emerald-400 p-4 text-slate-950 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-bold">Results</span>
                            <span class="mt-1 block text-xs text-emerald-950">Review attempts</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="eq-stat-card">
                    <p class="text-sm font-semibold text-slate-500">Courses</p>
                    <p class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $stats['courses'] }}</p>
                </div>
                <div class="eq-stat-card">
                    <p class="text-sm font-semibold text-slate-500">Quizzes</p>
                    <p class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $stats['quizzes'] }}</p>
                </div>
                <div class="eq-stat-card">
                    <p class="text-sm font-semibold text-slate-500">Questions</p>
                    <p class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $stats['questions'] }}</p>
                </div>
                <div class="eq-stat-card">
                    <p class="text-sm font-semibold text-slate-500">Attempts</p>
                    <p class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $stats['attempts'] }}</p>
                </div>
            </section>

            <section class="mt-6 grid gap-4 md:grid-cols-2">
                <a href="{{ route('admin.courses.index') }}" class="eq-card">
                    <p class="text-sm font-bold text-emerald-700">Manage Courses</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Organize learning content</h3>
                    <p class="mt-2 eq-muted">Create active course containers for students to browse.</p>
                </a>
                <a href="{{ route('admin.quizzes.index') }}" class="eq-card">
                    <p class="text-sm font-bold text-emerald-700">Manage Quizzes</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Attach tests to courses</h3>
                    <p class="mt-2 eq-muted">Set quiz descriptions, duration, and publishing status.</p>
                </a>
                <a href="{{ route('admin.questions.index') }}" class="eq-card">
                    <p class="text-sm font-bold text-emerald-700">Manage Questions</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Build answerable prompts</h3>
                    <p class="mt-2 eq-muted">Add points and answer choices for accurate scoring.</p>
                </a>
                <a href="{{ route('admin.attempts.index') }}" class="eq-card">
                    <p class="text-sm font-bold text-emerald-700">Review Results</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Inspect student attempts</h3>
                    <p class="mt-2 eq-muted">Check score, selected answers, student, course, and quiz context.</p>
                </a>
            </section>
        </div>
    </div>
</x-app-layout>
