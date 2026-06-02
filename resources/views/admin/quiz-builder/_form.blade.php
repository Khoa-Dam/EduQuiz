@php
    $oldQuestions = old('questions');

    if (is_array($oldQuestions)) {
        $initialQuestions = collect($oldQuestions)->values()->map(fn ($question) => [
            'id' => $question['id'] ?? null,
            'question_text' => $question['question_text'] ?? '',
            'points' => $question['points'] ?? 1,
            'image_url' => null,
            'answers' => collect($question['answers'] ?? [])->values()->map(fn ($answer) => [
                'id' => $answer['id'] ?? null,
                'answer_text' => $answer['answer_text'] ?? '',
                'is_correct' => (bool) ($answer['is_correct'] ?? false),
            ])->values()->all(),
        ])->values()->all();
    } else {
        $initialQuestions = $builderQuestions->map(fn ($question) => [
            'id' => $question->id,
            'question_text' => $question->question_text,
            'points' => $question->points ?: 1,
            'image_url' => $question->imageUrl(),
            'answers' => $question->answers->map(fn ($answer) => [
                'id' => $answer->id,
                'answer_text' => $answer->answer_text,
                'is_correct' => $answer->is_correct,
            ])->values()->all(),
        ])->values()->all();
    }

    if ($initialQuestions === []) {
        $initialQuestions = [[
            'id' => null,
            'question_text' => '',
            'points' => 1,
            'image_url' => null,
            'answers' => [
                ['id' => null, 'answer_text' => '', 'is_correct' => true],
                ['id' => null, 'answer_text' => '', 'is_correct' => false],
            ],
        ]];
    }
@endphp

<form
    method="POST"
    action="{{ $action }}"
    enctype="multipart/form-data"
    class="eq-builder-shell"
    x-data="{
        submitting: false,
        intent: @js($submitIntent),
        courseMode: @js(old('course_mode', 'existing')),
        questions: @js($initialQuestions),
        addQuestion() {
            this.questions.push({
                id: null,
                question_text: '',
                points: 1,
                image_url: null,
                answers: [
                    { id: null, answer_text: '', is_correct: true },
                    { id: null, answer_text: '', is_correct: false },
                ],
            });
        },
        removeQuestion(index) {
            this.questions.splice(index, 1);
            if (this.questions.length === 0) {
                this.addQuestion();
            }
        },
        addAnswer(question) {
            question.answers.push({ id: null, answer_text: '', is_correct: false });
        },
        removeAnswer(question, index) {
            question.answers.splice(index, 1);
        },
        submitAs(nextIntent) {
            this.intent = nextIntent;
        },
        filledQuestions() {
            return this.questions.filter((question) => question.question_text && question.question_text.trim() !== '').length;
        },
        filledAnswers(question) {
            return question.answers.filter((answer) => answer.answer_text && answer.answer_text.trim() !== '').length;
        },
        hasCorrectAnswer(question) {
            return question.answers.some((answer) => answer.is_correct);
        },
        questionReady(question) {
            return (question.question_text && question.question_text.trim() !== '') && this.filledAnswers(question) >= 2 && this.hasCorrectAnswer(question);
        },
        readyQuestions() {
            return this.questions.filter((question) => this.questionReady(question)).length;
        },
        completionPercent() {
            return this.questions.length === 0 ? 0 : Math.round((this.readyQuestions() / this.questions.length) * 100);
        },
        isReady() {
            return this.questions.length > 0 && this.readyQuestions() === this.questions.length;
        },
    }"
    x-on:submit="submitting = true"
>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <input type="hidden" name="intent" x-bind:value="intent">

    <div class="space-y-6">
        @if (session('success'))
            <div class="eq-alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->has('publish'))
            <div class="rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-800">
                <p class="font-black">Quiz is not ready to publish</p>
                <ul class="mt-3 list-disc space-y-1 pl-5">
                    @foreach ($errors->get('publish') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="eq-studio-panel">
            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-end">
                <div>
                    <p class="text-sm font-black text-violet-700">Quiz Builder - Live Studio</p>
                    <h3 class="mt-3 max-w-3xl text-4xl font-black tracking-tight text-slate-950">Build the mission, then launch it.</h3>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-600">Course setup, question blocks, answer choices, readiness checks, and publishing now live in one launch surface.</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-4">
                    <p class="text-xs font-black uppercase tracking-[0.14em] text-violet-700">Studio signal</p>
                    <p class="mt-2 text-3xl font-black tabular-nums text-slate-950"><span x-text="completionPercent()"></span>%</p>
                    <p class="mt-1 text-sm font-semibold text-slate-600">ready to publish</p>
                </div>
            </div>
        </section>

        <section class="eq-panel">
            <div class="eq-panel-body">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="eq-badge">Step 1</p>
                        <h3 class="mt-3 text-xl font-black text-slate-950">Course and quiz setup</h3>
                        <p class="mt-2 eq-muted">Create the course shell and quiz details in one place.</p>
                    </div>
                    <span class="eq-status-badge">{{ $quiz->status === 'active' ? 'Active' : 'Draft' }}</span>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    <label class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <input type="radio" name="course_mode" value="existing" x-model="courseMode" class="text-violet-600 focus:ring-violet-500">
                        <span class="ms-2 text-sm font-black text-slate-950">Use existing course</span>
                    </label>
                    <label class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <input type="radio" name="course_mode" value="new" x-model="courseMode" class="text-violet-600 focus:ring-violet-500">
                        <span class="ms-2 text-sm font-black text-slate-950">Create new course</span>
                    </label>
                </div>

                <div class="mt-4" x-show="courseMode === 'existing'">
                    <x-input-label for="course_id" value="Course" />
                    <select id="course_id" name="course_id" class="mt-1 block w-full">
                        <option value="">Select a course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected((int) old('course_id', $quiz->course_id) === $course->id)>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                </div>

                <div class="mt-4 grid gap-4 md:grid-cols-2" x-show="courseMode === 'new'">
                    <div>
                        <x-input-label for="course_title" value="New course title" />
                        <x-text-input id="course_title" name="course_title" class="mt-1 block w-full" :value="old('course_title')" placeholder="Laravel fundamentals" />
                        <x-input-error :messages="$errors->get('course_title')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="course_description" value="Course description" />
                        <x-text-input id="course_description" name="course_description" class="mt-1 block w-full" :value="old('course_description')" placeholder="Short learning path summary" />
                        <x-input-error :messages="$errors->get('course_description')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    <div>
                        <x-input-label for="title" value="Quiz title" />
                        <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title', $quiz->title)" required placeholder="Laravel MVC quiz" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="duration_minutes" value="Duration minutes" />
                        <x-text-input id="duration_minutes" name="duration_minutes" type="number" min="1" class="mt-1 block w-full" :value="old('duration_minutes', $quiz->duration_minutes)" placeholder="15" />
                        <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-4">
                    <x-input-label for="description" value="Quiz description" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full" placeholder="Describe what students will practice.">{{ old('description', $quiz->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="cover_image" value="Cover image" />
                    @if ($quiz->coverImageUrl())
                        <div class="mt-2 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                            <img src="{{ $quiz->coverImageUrl() }}" alt="Current cover image for {{ $quiz->title }}" class="h-44 w-full object-cover">
                        </div>
                        <label class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <input type="checkbox" name="remove_cover_image" value="1" class="rounded border-slate-300 text-violet-600 shadow-sm focus:ring-violet-500">
                            Remove current image
                        </label>
                    @endif
                    <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-violet-600 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-violet-700">
                    <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                </div>
            </div>
        </section>

        <section class="eq-panel">
            <div class="eq-panel-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="eq-badge">Live Studio</p>
                        <h3 class="mt-3 text-xl font-black text-slate-950">Question canvas</h3>
                        <p class="mt-2 eq-muted">Build answerable prompts and watch readiness update before publishing.</p>
                    </div>
                    <button type="button" class="eq-btn-secondary" x-on:click="addQuestion()">Add question</button>
                </div>

                <div class="mt-5 rounded-[1.25rem] bg-violet-600 p-4 text-white shadow-lg shadow-violet-300/40">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-violet-100">Studio readiness</p>
                            <p class="mt-2 text-2xl font-black"><span x-text="readyQuestions()"></span> / <span x-text="questions.length"></span> blocks ready</p>
                        </div>
                        <div class="min-w-0 flex-1 md:max-w-md">
                            <div class="flex items-center justify-between text-xs font-bold text-violet-100">
                                <span>Publish meter</span>
                                <span x-text="completionPercent() + '%'"></span>
                            </div>
                            <div class="mt-2 h-2 overflow-hidden rounded-full bg-white/10">
                                <div class="h-full rounded-full bg-yellow-300 transition-all duration-300" x-bind:style="`width: ${completionPercent()}%`"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <template x-for="(question, qIndex) in questions" :key="`rail-${qIndex}`">
                            <span class="eq-studio-dot" x-bind:class="{ 'eq-studio-dot-ready': questionReady(question) }">
                                Q<span x-text="qIndex + 1"></span>
                            </span>
                        </template>
                    </div>
                </div>

                <template x-for="(question, qIndex) in questions" :key="qIndex">
                    <div class="mt-5 rounded-3xl border bg-slate-50 p-4 transition duration-300" x-bind:class="questionReady(question) ? 'border-violet-300 shadow-lg shadow-violet-100' : 'border-slate-200'">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-black text-slate-950">Question <span x-text="qIndex + 1"></span></p>
                                <p class="mt-1 text-xs font-bold" x-bind:class="questionReady(question) ? 'text-violet-700' : 'text-amber-700'" x-text="questionReady(question) ? 'Ready to launch' : 'Needs setup'"></p>
                            </div>
                            <button type="button" class="eq-delete-link" x-on:click="removeQuestion(qIndex)">Remove</button>
                        </div>

                        <input type="hidden" x-bind:name="`questions[${qIndex}][id]`" x-bind:value="question.id || ''">

                        <div class="mt-4">
                            <x-input-label value="Question text" />
                            <textarea rows="3" class="mt-1 block w-full" x-bind:name="`questions[${qIndex}][question_text]`" x-model="question.question_text" placeholder="Which layer handles HTTP requests?"></textarea>
                        </div>

                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label value="Points" />
                                <x-text-input type="number" min="1" max="100" class="mt-1 block w-full" x-bind:name="`questions[${qIndex}][points]`" x-model="question.points" />
                            </div>
                            <div>
                                <x-input-label value="Question image" />
                                <input type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-violet-600 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-violet-700" x-bind:name="`questions[${qIndex}][question_image]`">
                            </div>
                        </div>

                        <template x-if="question.image_url">
                            <label class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                                <input type="checkbox" value="1" class="rounded border-slate-300 text-violet-600 shadow-sm focus:ring-violet-500" x-bind:name="`questions[${qIndex}][remove_question_image]`">
                                Remove current image
                            </label>
                        </template>

                        <div class="mt-5 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-black text-slate-950">Answers</p>
                                <button type="button" class="eq-link" x-on:click="addAnswer(question)">Add answer</button>
                            </div>

                            <template x-for="(answer, aIndex) in question.answers" :key="aIndex">
                                <div class="grid gap-3 rounded-2xl border border-white bg-white p-3 md:grid-cols-[1fr_auto_auto] md:items-center">
                                    <input type="hidden" x-bind:name="`questions[${qIndex}][answers][${aIndex}][id]`" x-bind:value="answer.id || ''">
                                    <x-text-input class="block w-full" x-bind:name="`questions[${qIndex}][answers][${aIndex}][answer_text]`" x-model="answer.answer_text" placeholder="Answer choice" />
                                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <input type="checkbox" value="1" class="rounded border-slate-300 text-violet-600 shadow-sm focus:ring-violet-500" x-bind:name="`questions[${qIndex}][answers][${aIndex}][is_correct]`" x-model="answer.is_correct">
                                        Correct
                                    </label>
                                    <button type="button" class="eq-delete-link text-left md:text-right" x-on:click="removeAnswer(question, aIndex)">Remove</button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </section>
    </div>

    <aside class="eq-studio-panel h-fit xl:sticky xl:top-6">
        <p class="text-sm font-black text-slate-950">Launch console</p>
        <p class="mt-2 text-sm leading-6 text-slate-600">Drafts can be saved anytime. Publishing needs every question block ready.</p>

        <div class="mt-5 rounded-[1.25rem] bg-violet-600 p-4 text-white shadow-lg shadow-violet-300/40">
            <p class="text-xs font-black uppercase tracking-[0.14em] text-violet-100">Launch score</p>
            <p class="mt-2 text-4xl font-black tabular-nums"><span x-text="completionPercent()"></span>%</p>
            <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                <div class="h-full rounded-full bg-yellow-300 transition-all duration-300" x-bind:style="`width: ${completionPercent()}%`"></div>
            </div>
        </div>

        <div class="mt-5 space-y-2 text-sm font-semibold text-slate-700">
            <p class="rounded-2xl bg-violet-50 px-3 py-2">Questions with text: <span x-text="filledQuestions()"></span></p>
            <p class="rounded-2xl bg-violet-50 px-3 py-2">Ready blocks: <span x-text="readyQuestions()"></span> / <span x-text="questions.length"></span></p>
            <p class="rounded-2xl bg-violet-50 px-3 py-2" x-text="isReady() ? 'Ready to publish' : 'Publishing locked until every block is ready'"></p>
        </div>

        @if ($readinessErrors !== [])
            <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-4">
                <p class="text-sm font-black text-amber-900">Needs setup</p>
                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-amber-800">
                    @foreach ($readinessErrors as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 grid gap-3">
            <x-primary-button class="w-full justify-center" x-on:click="submitAs('{{ $submitIntent }}')" x-bind:disabled="submitting">
                <span x-show="! submitting">{{ $submitLabel }}</span>
                <span x-cloak x-show="submitting">Saving...</span>
            </x-primary-button>
            @if ($quiz->exists && $quiz->status === 'active')
                <button type="submit" class="eq-btn-ghost justify-center" x-on:click="submitAs('draft')" x-bind:disabled="submitting">
                    Move to draft
                </button>
            @endif
            <button type="submit" class="eq-btn-secondary justify-center" x-on:click="submitAs('publish')" x-bind:disabled="submitting || ! isReady()">
                Publish quiz
            </button>
        </div>
    </aside>
</form>
