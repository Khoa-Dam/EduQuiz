<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz Detail
            </h2>
            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Edit Quiz
            </a>
        </div>
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
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $quiz->title }}</h3>
                            <p class="mt-1 text-sm text-gray-600">Course: {{ $quiz->course->title }}</p>
                            <p class="mt-3 text-sm text-gray-600">
                                {{ $quiz->description ?: 'No description provided.' }}
                            </p>
                        </div>
                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                            {{ ucfirst($quiz->status) }}
                        </span>
                    </div>

                    <dl class="mt-6 grid grid-cols-1 gap-4 border-t border-gray-100 pt-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase text-gray-500">Duration</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No limit' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $quiz->created_at->format('Y-m-d') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                        <a href="{{ route('admin.quizzes.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to quizzes
                        </a>

                        <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('Delete this quiz?')">
                                Delete Quiz
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
