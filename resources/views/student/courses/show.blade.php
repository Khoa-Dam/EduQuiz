<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm text-gray-600">{{ $course->description ?: 'No description provided.' }}</p>

                    <div class="mt-8">
                        <h3 class="text-base font-semibold text-gray-900">Available Quizzes</h3>

                        @if ($course->quizzes->isEmpty())
                            <p class="mt-3 text-sm text-gray-600">No active quizzes are available for this course.</p>
                        @else
                            <div class="mt-4 divide-y divide-gray-100 rounded-md border border-gray-200">
                                @foreach ($course->quizzes as $quiz)
                                    <div class="flex flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $quiz->title }}</p>
                                            <p class="mt-1 text-sm text-gray-600">
                                                {{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}
                                            </p>
                                        </div>
                                        <a href="{{ route('quizzes.show', $quiz) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">
                                            View quiz
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <a href="{{ route('courses.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
