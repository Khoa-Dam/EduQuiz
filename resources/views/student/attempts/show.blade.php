<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attempt Result
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">{{ $attempt->quiz->course->title }}</p>
                    <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $attempt->quiz->title }}</h3>

                    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-md bg-gray-50 p-4">
                            <dt class="text-xs font-semibold uppercase text-gray-500">Score</dt>
                            <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $attempt->score }}</dd>
                        </div>
                        <div class="rounded-md bg-gray-50 p-4">
                            <dt class="text-xs font-semibold uppercase text-gray-500">Correct</dt>
                            <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $attempt->correct_answers }} / {{ $attempt->total_questions }}</dd>
                        </div>
                        <div class="rounded-md bg-gray-50 p-4">
                            <dt class="text-xs font-semibold uppercase text-gray-500">Submitted</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $attempt->submitted_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <h4 class="text-sm font-semibold uppercase text-gray-700">Answer Detail</h4>
                        <div class="mt-3 divide-y divide-gray-100 rounded-md border border-gray-200">
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

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <a href="{{ route('attempts.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to my attempts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
