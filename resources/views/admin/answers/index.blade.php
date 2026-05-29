<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Answer Management
            </h2>
            <a href="{{ route('admin.answers.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                New Answer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('admin.answers.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <x-input-label for="question_id" value="Filter by question" />
                        <select id="question_id" name="question_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All questions</option>
                            @foreach ($questions as $question)
                                <option value="{{ $question->id }}" @selected($selectedQuestionId === $question->id)>
                                    {{ \Illuminate\Support\Str::limit($question->question_text, 90) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button>Filter</x-primary-button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($answers->isEmpty())
                        <x-empty-state
                            title="No answers yet"
                            message="Create answers from a question detail page and mark at least one answer as correct."
                            :href="route('admin.answers.create')"
                            action="Create answer"
                        />
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Answer</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Question</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Correct</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($answers as $answer)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ \Illuminate\Support\Str::limit($answer->answer_text, 70) }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ \Illuminate\Support\Str::limit($answer->question->question_text, 70) }}</td>
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

                        <div class="mt-6">
                            {{ $answers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
