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

                    <div class="mt-6 rounded-md bg-gray-50 p-4 text-sm text-gray-700">
                        Quiz answering and scoring are implemented in the next phase.
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <a href="{{ route('quizzes.show', $quiz) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to quiz detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
