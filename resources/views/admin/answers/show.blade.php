<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Answer Detail
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">
                        {{ \Illuminate\Support\Str::limit($answer->question->question_text, 120) }}
                    </p>
                    <p class="mt-4 text-gray-900">{{ $answer->answer_text }}</p>
                    <p class="mt-3 text-sm text-gray-600">Correct: {{ $answer->is_correct ? 'Yes' : 'No' }}</p>

                    <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                        <a href="{{ route('admin.questions.show', $answer->question) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to question
                        </a>
                        <a href="{{ route('admin.answers.edit', $answer) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">
                            Edit answer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
