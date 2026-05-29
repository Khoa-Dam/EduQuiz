<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Question
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.questions.update', $question) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    @include('admin.questions._form', [
                        'question' => $question,
                        'quizzes' => $quizzes,
                        'submitLabel' => 'Update Question',
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
