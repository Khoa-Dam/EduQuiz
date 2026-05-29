<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Admin workspace</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Admin Dashboard</h2>
            </div>
            <a href="{{ route('admin.courses.create') }}" class="eq-btn-primary">New course</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-hero-panel bg-slate-950 text-white">
                <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                    <div>
                        <p class="text-sm font-bold text-emerald-300">Demo control center</p>
                        <h3 class="mt-3 max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                            Manage content, publish quizzes, and review student results.
                        </h3>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300">
                            The admin workspace keeps the full quiz workflow visible for a short recording: courses, quizzes, questions, answers, and attempts.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.courses.index') }}" class="rounded-2xl bg-white p-4 text-slate-950 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-black">Courses</span>
                            <span class="mt-1 block text-xs font-semibold text-slate-600">Learning paths</span>
                        </a>
                        <a href="{{ route('admin.quizzes.index') }}" class="rounded-2xl bg-white/10 p-4 text-white ring-1 ring-white/10 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-black">Quizzes</span>
                            <span class="mt-1 block text-xs font-semibold text-slate-300">Assessments</span>
                        </a>
                        <a href="{{ route('admin.questions.index') }}" class="rounded-2xl bg-white/10 p-4 text-white ring-1 ring-white/10 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-black">Questions</span>
                            <span class="mt-1 block text-xs font-semibold text-slate-300">Scoring setup</span>
                        </a>
                        <a href="{{ route('admin.attempts.index') }}" class="rounded-2xl bg-emerald-400 p-4 text-slate-950 transition hover:-translate-y-0.5">
                            <span class="block text-sm font-black">Results</span>
                            <span class="mt-1 block text-xs font-semibold text-emerald-950">Attempt review</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['label' => 'Courses', 'value' => $stats['courses'], 'marker' => 'C'],
                    ['label' => 'Quizzes', 'value' => $stats['quizzes'], 'marker' => 'Q'],
                    ['label' => 'Questions', 'value' => $stats['questions'], 'marker' => '?'],
                    ['label' => 'Attempts', 'value' => $stats['attempts'], 'marker' => 'A'],
                ] as $item)
                    <div class="eq-stat-card">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-bold text-slate-500">{{ $item['label'] }}</p>
                                <p class="mt-1 text-3xl font-black tabular-nums text-slate-950">{{ $item['value'] }}</p>
                            </div>
                            <span class="eq-stat-marker">{{ $item['marker'] }}</span>
                        </div>
                    </div>
                @endforeach
            </section>

            <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('admin.courses.index') }}" class="eq-card min-h-[150px]">
                    <p class="text-sm font-bold text-emerald-700">Manage courses</p>
                    <h3 class="mt-2 text-lg font-black text-slate-950">Organize learning paths</h3>
                    <p class="mt-2 eq-muted">Create active course containers for students to browse.</p>
                </a>
                <a href="{{ route('admin.quizzes.index') }}" class="eq-card min-h-[150px]">
                    <p class="text-sm font-bold text-emerald-700">Manage quizzes</p>
                    <h3 class="mt-2 text-lg font-black text-slate-950">Attach tests to courses</h3>
                    <p class="mt-2 eq-muted">Set descriptions, duration, and publishing status.</p>
                </a>
                <a href="{{ route('admin.questions.index') }}" class="eq-card min-h-[150px]">
                    <p class="text-sm font-bold text-emerald-700">Manage questions</p>
                    <h3 class="mt-2 text-lg font-black text-slate-950">Build answerable prompts</h3>
                    <p class="mt-2 eq-muted">Add points and answer choices for accurate scoring.</p>
                </a>
                <a href="{{ route('admin.attempts.index') }}" class="eq-card min-h-[150px]">
                    <p class="text-sm font-bold text-emerald-700">Review results</p>
                    <h3 class="mt-2 text-lg font-black text-slate-950">Inspect attempts</h3>
                    <p class="mt-2 eq-muted">Check score, selected answers, student, course, and quiz context.</p>
                </a>
            </section>
        </div>
    </div>
</x-app-layout>
