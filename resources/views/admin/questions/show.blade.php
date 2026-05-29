<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Question Detail
            </h2>
            <a href="{{ route('admin.answers.create', ['question_id' => $question->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Add Answer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">{{ $question->quiz->title }} - {{ $question->quiz->course->title }}</p>
                    <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $question->question_text }}</h3>
                    <p class="mt-2 text-sm text-gray-600">Points: {{ $question->points }}</p>

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <h4 class="text-sm font-semibold uppercase text-gray-700">Answers</h4>

                        @if ($question->answers->isEmpty())
                            <div class="mt-4">
                                <x-empty-state
                                    title="No answers yet"
                                    message="Add answer choices so students can submit this question."
                                    :href="route('admin.answers.create', ['question_id' => $question->id])"
                                    action="Add answer"
                                />
                            </div>
                        @else
                            <div class="mt-3 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Answer</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Correct</th>
                                            <th class="px-4 py-3 text-right font-semibold text-gray-700">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @foreach ($question->answers as $answer)
                                            <tr>
                                                <td class="px-4 py-3 text-gray-900">{{ $answer->answer_text }}</td>
                                                <td class="px-4 py-3 text-gray-700">{{ $answer->is_correct ? 'Yes' : 'No' }}</td>
                                                <td class="px-4 py-3 text-right">
                                                    <div class="flex justify-end gap-3">
                                                        <a href="{{ route('admin.answers.edit', $answer) }}" class="font-medium text-indigo-700 hover:text-indigo-900">Edit</a>
                                                        <form method="POST" action="{{ route('admin.answers.destroy', $answer) }}">
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
                        @endif
                    </div>

                    <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                        <a href="{{ route('admin.questions.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to questions
                        </a>
                        <a href="{{ route('admin.questions.edit', $question) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">
                            Edit question
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
