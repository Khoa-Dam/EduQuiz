<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Start Quiz
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">{{ $quiz->course->title }}</p>
                    <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $quiz->title }}</h3>
                    <p class="mt-3 text-sm text-gray-700">
                        This quiz has {{ $quiz->questions->count() }} questions.
                        {{ $quiz->duration_minutes ? 'Duration: '.$quiz->duration_minutes.' minutes.' : 'There is no time limit.' }}
                    </p>

                    <form method="POST" action="{{ route('quizzes.submit', $quiz) }}" class="mt-6 space-y-6">
                        @csrf

                        @foreach ($quiz->questions as $question)
                            <fieldset class="rounded-md border border-gray-200 p-4">
                                <legend class="text-sm font-semibold text-gray-900">
                                    {{ $loop->iteration }}. {{ $question->question_text }}
                                </legend>
                                <p class="mt-1 text-xs text-gray-500">Points: {{ $question->points }}</p>

                                <div class="mt-4 space-y-3">
                                    @foreach ($question->answers as $answer)
                                        <label class="flex items-start gap-3 text-sm text-gray-700">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="mt-1 border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked((int) old("answers.{$question->id}") === $answer->id)>
                                            <span>{{ $answer->answer_text }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <x-input-error :messages="$errors->get('answers.'.$question->id)" class="mt-2" />
                            </fieldset>
                        @endforeach

                        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
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
