<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Attempt Detail</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $attempt->quiz->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <section class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $attempt->quiz->course->title }}</p>
                    <h3 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $attempt->quiz->title }}</h3>
                    <p class="mt-2 text-sm font-semibold text-slate-600">Student: {{ $attempt->user->name }} ({{ $attempt->user->email }})</p>

                    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Score</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $attempt->score }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Correct</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $attempt->correct_answers }} / {{ $attempt->total_questions }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Submitted</dt>
                            <dd class="mt-2 text-sm font-black text-slate-950">{{ $attempt->submitted_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8 divide-y divide-slate-100 overflow-hidden rounded-3xl border border-slate-200 bg-white">
                        @foreach ($attempt->attemptAnswers as $attemptAnswer)
                            <div class="p-5">
                                <p class="font-bold text-slate-950">{{ $attemptAnswer->question->question_text }}</p>
                                <p class="mt-2 text-sm text-slate-700">Selected answer: {{ $attemptAnswer->answer->answer_text }}</p>
                                <p class="mt-2 inline-flex rounded-xl px-2.5 py-1 text-xs font-black {{ $attemptAnswer->is_correct ? 'bg-emerald-50 text-emerald-800' : 'bg-red-50 text-red-800' }}">
                                    {{ $attemptAnswer->is_correct ? 'Correct' : 'Incorrect' }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-4">
                        <a href="{{ route('admin.attempts.index') }}" class="eq-link">Back to attempts</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
