<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attempt Result
        </h2>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $attempt->quiz->course->title }}</p>
                    <h3 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $attempt->quiz->title }}</h3>

                    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="eq-stat-card">
                            <dt class="text-sm font-semibold text-slate-500">Score</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $attempt->score }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-semibold text-slate-500">Correct</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $attempt->correct_answers }} / {{ $attempt->total_questions }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-semibold text-slate-500">Submitted</dt>
                            <dd class="mt-2 text-sm font-bold text-slate-950">{{ $attempt->submitted_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <h4 class="text-xl font-bold text-slate-950">Answer Detail</h4>
                        <div class="mt-3 divide-y divide-slate-100 rounded-2xl border border-slate-200">
                            @foreach ($attempt->attemptAnswers as $attemptAnswer)
                                <div class="p-4">
                                    <p class="font-medium text-gray-900">{{ $attemptAnswer->question->question_text }}</p>
                                    <p class="mt-2 text-sm text-gray-700">Your answer: {{ $attemptAnswer->answer->answer_text }}</p>
                                    <p class="mt-1 text-sm font-medium {{ $attemptAnswer->is_correct ? 'text-green-700' : 'text-red-700' }}">
                                        {{ $attemptAnswer->is_correct ? 'Correct' : 'Incorrect' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-4">
                        <a href="{{ route('attempts.index') }}" class="eq-link">
                            Back to my attempts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
