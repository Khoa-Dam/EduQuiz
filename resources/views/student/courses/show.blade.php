<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Course detail</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $course->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <div class="eq-panel">
                <div class="eq-panel-body">
                    <p class="max-w-3xl text-base leading-7 text-slate-700">{{ $course->description ?: 'No description provided.' }}</p>

                    <div class="mt-8">
                        <h3 class="eq-section-title">Available quizzes</h3>

                        @if ($course->quizzes->isEmpty())
                            <div class="mt-4">
                                <x-empty-state
                                    title="No active quizzes are available for this course"
                                    message="Check another course or come back after an admin publishes a quiz."
                                    :href="route('courses.index')"
                                    action="Browse courses"
                                />
                            </div>
                        @else
                            <div class="mt-4 grid gap-3">
                                @foreach ($course->quizzes as $quiz)
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="font-bold text-slate-950">{{ $quiz->title }}</p>
                                            <p class="mt-1 text-sm text-slate-600">
                                                {{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}
                                            </p>
                                        </div>
                                        <a href="{{ route('quizzes.show', $quiz) }}" class="mt-3 inline-flex text-sm font-semibold text-emerald-700 hover:text-emerald-900 sm:mt-0">
                                            View quiz
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-4">
                        <a href="{{ route('courses.index') }}" class="eq-link">
                            Back to courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
