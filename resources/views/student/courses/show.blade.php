<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-violet-700">Course detail</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $course->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-student-hero" data-gsap-hero>
                <div class="eq-student-hero-body">
                    <div>
                        <p class="text-sm font-bold text-violet-700">Course detail</p>
                        <h3 class="mt-3 max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">{{ $course->title }}</h3>
                        <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">{{ $course->description ?: 'No description provided.' }}</p>
                    </div>
                    <div class="eq-media-frame hidden aspect-[4/3] lg:block" aria-hidden="true">
                        <div class="eq-media-fallback h-full">
                            <span class="eq-media-fallback-mark">{{ $course->quizzes->count() }} quizzes</span>
                        </div>
                    </div>
                </div>
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
                        <div class="grid gap-5 md:grid-cols-2">
                            @foreach ($course->quizzes as $quiz)
                                <a href="{{ route('quizzes.show', $quiz) }}" class="eq-quiz-tile" data-gsap-quiz-card>
                                    <div class="eq-quiz-tile-media">
                                        @if ($quiz->coverImageUrl())
                                            <img src="{{ $quiz->coverImageUrl() }}" alt="Cover image for {{ $quiz->title }}">
                                        @else
                                            <div class="eq-media-fallback h-full">
                                                <span class="eq-media-fallback-mark">Quiz</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="eq-quiz-tile-body">
                                        <p class="text-sm font-bold text-violet-700">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}</p>
                                        <h4 class="mt-2 text-xl font-black text-slate-950">{{ $quiz->title }}</h4>
                                        <p class="mt-2 eq-muted">{{ $quiz->description ?: 'Open this quiz to see details and start.' }}</p>
                                        <p class="mt-5 text-sm font-black text-violet-700">Open quiz</p>
                                    </div>
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
