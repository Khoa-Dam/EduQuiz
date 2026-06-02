<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">{{ $quiz->course->title }}</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Take quiz</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <section class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $quiz->course->title }}</p>
                    <h3 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        This quiz has {{ $quiz->questions->count() }} questions.
                        {{ $quiz->duration_minutes ? 'Duration: '.$quiz->duration_minutes.' minutes.' : 'There is no time limit.' }}
                    </p>

                    <form method="POST" action="{{ route('quizzes.submit', $quiz) }}" class="mt-6 space-y-5" x-data="{ submitting: false }" x-on:submit="submitting = true">
                        @csrf

                        @foreach ($quiz->questions as $question)
                            <fieldset class="rounded-3xl border border-slate-200 bg-slate-50/80 p-5">
                                <legend class="px-1 text-base font-black text-slate-950">
                                    {{ $loop->iteration }}. {{ $question->question_text }}
                                </legend>
                                <p class="mt-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-500">Points: {{ $question->points }}</p>

                                <div class="mt-4 space-y-3">
                                    @foreach ($question->answers as $answer)
                                        <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100 transition hover:border-emerald-300 hover:bg-emerald-50/70">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="mt-1 shadow-sm" @checked((int) old("answers.{$question->id}") === $answer->id)>
                                            <span>{{ $answer->answer_text }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <x-input-error :messages="$errors->get('answers.'.$question->id)" class="mt-2" />
                            </fieldset>
                        @endforeach

                        <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="eq-link">Back to quiz detail</a>
                            <x-primary-button x-bind:disabled="submitting">
                                <span x-show="! submitting">Submit quiz</span>
                                <span x-cloak x-show="submitting">Submitting...</span>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
