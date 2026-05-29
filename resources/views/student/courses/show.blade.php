<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Course detail</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $course->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-hero-panel">
                <p class="eq-badge">Course</p>
                <h3 class="mt-4 max-w-3xl text-3xl font-black tracking-tight text-slate-950">{{ $course->title }}</h3>
                <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $course->description ?: 'No description provided.' }}</p>
            </section>

            <section class="mt-6 eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-5">
                        <h3 class="eq-section-title">Available quizzes</h3>
                        <p class="mt-2 eq-muted">Open a quiz detail page before starting an attempt.</p>
                    </div>

                    @if ($course->quizzes->isEmpty())
                        <x-empty-state title="No active quizzes are available for this course" message="Check another course or come back after an admin publishes a quiz." :href="route('courses.index')" action="Browse courses" />
                    @else
                        <div class="grid gap-4 md:grid-cols-2">
                            @foreach ($course->quizzes as $quiz)
                                <a href="{{ route('quizzes.show', $quiz) }}" class="eq-card">
                                    <p class="text-sm font-bold text-emerald-700">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}</p>
                                    <h4 class="mt-2 text-lg font-black text-slate-950">{{ $quiz->title }}</h4>
                                    <p class="mt-2 eq-muted">{{ $quiz->description ?: 'Open this quiz to see details and start.' }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-6 border-t border-slate-100 pt-4">
                        <a href="{{ route('courses.index') }}" class="eq-link">Back to courses</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
