<div>
    <x-input-label for="quiz_id" value="Quiz" />
    <select id="quiz_id" name="quiz_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
        <option value="">Select a quiz</option>
        @foreach ($quizzes as $quiz)
            <option value="{{ $quiz->id }}" @selected((int) old('quiz_id', $question->quiz_id) === $quiz->id)>
                {{ $quiz->title }} - {{ $quiz->course->title }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('quiz_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="question_text" value="Question" />
    <textarea id="question_text" name="question_text" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('question_text', $question->question_text) }}</textarea>
    <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="points" value="Points" />
    <x-text-input id="points" name="points" type="number" min="1" max="100" class="mt-1 block w-full" :value="old('points', $question->points ?: 1)" required />
    <x-input-error :messages="$errors->get('points')" class="mt-2" />
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('admin.questions.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
        Cancel
    </a>
</div>
