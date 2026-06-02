<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-violet-700">{{ $quiz->course->title }}</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Take quiz</h2>
        </div>
    </x-slot>

    @php
        $oldAnswers = collect(old('answers', []))
            ->mapWithKeys(fn ($answerId, $questionId) => [(int) $questionId => (string) $answerId])
            ->all();
    @endphp

    <div class="eq-page">
        <div class="eq-cockpit-shell">
            <aside class="eq-cockpit-hud" data-gsap-hero>
                <div>
                    <div>
                        <p class="text-sm font-bold text-violet-700">Mission cockpit</p>
                        <h3 class="mt-3 text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">{{ $quiz->title }}</h3>
                        <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">{{ $quiz->course->title }}</p>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-600">
                        This quiz has {{ $quiz->questions->count() }} questions.
                        {{ $quiz->duration_minutes ? 'Duration: '.$quiz->duration_minutes.' minutes.' : 'There is no time limit.' }}
                        </p>
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="eq-game-chip">
                                <span>Submit</span>
                                <strong>+20</strong>
                            </div>
                            <div class="eq-game-chip">
                                <span>Perfect</span>
                                <strong>+40</strong>
                            </div>
                        </div>
                    </div>
                    <div class="eq-media-frame mt-6 aspect-[4/3]">
                        @if ($quiz->coverImageUrl())
                            <img src="{{ $quiz->coverImageUrl() }}" alt="Cover image for {{ $quiz->title }}">
                        @else
                            <div class="eq-media-fallback h-full">
                                <span class="eq-media-fallback-mark">{{ $quiz->questions->count() }} questions</span>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>

            <section class="eq-cockpit-stage">
                <div class="eq-panel-body">
                    <form
                        method="POST"
                        action="{{ route('quizzes.submit', $quiz) }}"
                        class="space-y-5"
                        x-data="{
                            submitting: false,
                            current: 0,
                            questions: @js($quiz->questions->pluck('id')->values()),
                            selected: @js($oldAnswers),
                            get answeredCount() {
                                return this.questions.filter((id) => this.selected[id]).length;
                            },
                            get allAnswered() {
                                return this.answeredCount === this.questions.length;
                            },
                            get progressPercent() {
                                return this.questions.length === 0 ? 0 : Math.round((this.answeredCount / this.questions.length) * 100);
                            },
                            go(index) {
                                this.current = Math.min(Math.max(index, 0), this.questions.length - 1);
                            },
                            next() {
                                this.go(this.current + 1);
                            },
                            previous() {
                                this.go(this.current - 1);
                            },
                        }"
                        x-on:submit="submitting = true"
                    >
                        @csrf

                        <div class="rounded-[1.25rem] bg-violet-600 p-4 text-white shadow-xl shadow-violet-300/50">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.14em] text-violet-100">Mission progress</p>
                                <h3 class="mt-2 text-xl font-black text-white">
                                    <span x-text="answeredCount"></span> / {{ $quiz->questions->count() }} answered
                                </h3>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="mt-4 flex items-center justify-between gap-3 text-xs font-bold text-violet-100">
                                    <span>Ready to submit</span>
                                    <span x-text="progressPercent + '%'"></span>
                                </div>
                                <div class="mt-2 h-2 overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full rounded-full bg-yellow-300 transition-all duration-300" x-bind:style="`width: ${progressPercent}%`"></div>
                                </div>
                            </div>
                        </div>

                        <div class="eq-cockpit-rail">
                            @foreach ($quiz->questions as $question)
                                <button
                                    type="button"
                                    class="eq-question-dot"
                                    x-bind:class="{
                                        'eq-question-dot-active': current === {{ $loop->index }},
                                        'eq-question-dot-complete': selected[{{ $question->id }}],
                                    }"
                                    x-on:click="go({{ $loop->index }})"
                                >
                                    {{ $loop->iteration }}
                                </button>
                            @endforeach
                        </div>

                        @foreach ($quiz->questions as $question)
                            <fieldset class="eq-question-card" x-show="current === {{ $loop->index }}" x-transition.opacity data-gsap-reveal>
                                <legend class="sr-only">Question {{ $loop->iteration }}</legend>
                                @if ($question->imageUrl())
                                    <div class="eq-question-media">
                                        <img src="{{ $question->imageUrl() }}" alt="Image for question {{ $loop->iteration }}">
                                    </div>
                                @endif
                                <div class="p-5">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-xs font-black uppercase tracking-[0.14em] text-violet-700">Question {{ $loop->iteration }}</p>
                                            <p class="mt-2 px-1 text-xl font-black leading-tight text-slate-950">
                                                {{ $question->question_text }}
                                            </p>
                                        </div>
                                        <span class="eq-xp-pill">+{{ 15 }} XP correct</span>
                                    </div>
                                    <p class="mt-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-500">Points: {{ $question->points }}</p>

                                    <div class="mt-4 space-y-3">
                                        @foreach ($question->answers as $answer)
                                            <label class="eq-answer-option">
                                                <input
                                                    type="radio"
                                                    name="answers[{{ $question->id }}]"
                                                    value="{{ $answer->id }}"
                                                    class="mt-1 shadow-sm"
                                                    x-model="selected[{{ $question->id }}]"
                                                    @checked((int) old("answers.{$question->id}") === $answer->id)
                                                >
                                                <span>{{ $answer->answer_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <x-input-error :messages="$errors->get('answers.'.$question->id)" class="mt-2" />
                                </div>
                            </fieldset>
                        @endforeach

                        <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="eq-link">Back to quiz detail</a>
                            <div class="flex flex-col gap-3 sm:flex-row">
                                <button type="button" class="eq-btn-secondary" x-on:click="previous()" x-bind:disabled="current === 0 || submitting">Previous</button>
                                <button type="button" class="eq-btn-secondary" x-on:click="next()" x-bind:disabled="current === questions.length - 1 || submitting">Next</button>
                                <x-primary-button x-bind:disabled="submitting || ! allAnswered">
                                <span x-show="! submitting">Submit mission</span>
                                <span x-cloak x-show="submitting">Submitting...</span>
                            </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
