<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">{{ $quiz->course->title }}</p>
                    <p class="mt-3 text-sm text-gray-700">{{ $quiz->description ?: 'No description provided.' }}</p>

                    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase text-gray-500">Questions</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $quiz->questions->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase text-gray-500">Duration</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                        <a href="{{ route('courses.show', $quiz->course) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to course
                        </a>
                        <a href="{{ route('quizzes.start', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Start Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
