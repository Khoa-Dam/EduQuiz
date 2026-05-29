<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">{{ $quiz->course->title }}</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Start Quiz</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $quiz->course->title }}</p>
                    <h3 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        This quiz has {{ $quiz->questions->count() }} questions.
                        {{ $quiz->duration_minutes ? 'Duration: '.$quiz->duration_minutes.' minutes.' : 'There is no time limit.' }}
                    </p>

                    <form method="POST" action="{{ route('quizzes.submit', $quiz) }}" class="mt-6 space-y-6">
                        @csrf

                        @foreach ($quiz->questions as $question)
                            <fieldset class="rounded-2xl border border-slate-200 bg-slate-50/70 p-5">
                                <legend class="px-1 text-base font-bold text-slate-950">
                                    {{ $loop->iteration }}. {{ $question->question_text }}
                                </legend>
                                <p class="mt-1 text-xs font-semibold text-slate-500">Points: {{ $question->points }}</p>

                                <div class="mt-4 space-y-3">
                                    @foreach ($question->answers as $answer)
                                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50/50">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="mt-1 shadow-sm" @checked((int) old("answers.{$question->id}") === $answer->id)>
                                            <span>{{ $answer->answer_text }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <x-input-error :messages="$errors->get('answers.'.$question->id)" class="mt-2" />
                            </fieldset>
                        @endforeach

                        <div class="flex items-center justify-between border-t border-slate-100 pt-5">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="eq-link">
                                Back to quiz detail
                            </a>
                            <x-primary-button>Submit Quiz</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
