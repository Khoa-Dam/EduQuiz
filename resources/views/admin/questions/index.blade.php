<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Question Management
            </h2>
            <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                New Question
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('admin.questions.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <x-input-label for="quiz_id" value="Filter by quiz" />
                        <select id="quiz_id" name="quiz_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All quizzes</option>
                            @foreach ($quizzes as $quiz)
                                <option value="{{ $quiz->id }}" @selected($selectedQuizId === $quiz->id)>
                                    {{ $quiz->title }} - {{ $quiz->course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button>Filter</x-primary-button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($questions->isEmpty())
                        <x-empty-state
                            title="No questions yet"
                            message="Create questions after a quiz exists so each quiz has answer choices."
                            :href="route('admin.questions.create')"
                            action="Create question"
                        />
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Question</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Quiz</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Points</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Answers</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                <a href="{{ route('admin.questions.show', $question) }}" class="hover:text-indigo-700">
                                                    {{ \Illuminate\Support\Str::limit($question->question_text, 80) }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">{{ $question->quiz->title }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $question->points }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $question->answers_count }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex justify-end gap-3">
                                                    <a href="{{ route('admin.answers.create', ['question_id' => $question->id]) }}" class="font-medium text-gray-700 hover:text-gray-900">Add Answer</a>
                                                    <a href="{{ route('admin.questions.edit', $question) }}" class="font-medium text-indigo-700 hover:text-indigo-900">Edit</a>
                                                    <form method="POST" action="{{ route('admin.questions.destroy', $question) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-red-700 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $questions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
