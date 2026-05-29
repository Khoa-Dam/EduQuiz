<div>
    <x-input-label for="question_id" value="Question" />
    <select id="question_id" name="question_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
        <option value="">Select a question</option>
        @foreach ($questions as $question)
            <option value="{{ $question->id }}" @selected((int) old('question_id', $answer->question_id) === $question->id)>
                {{ \Illuminate\Support\Str::limit($question->question_text, 90) }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('question_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="answer_text" value="Answer" />
    <textarea id="answer_text" name="answer_text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('answer_text', $answer->answer_text) }}</textarea>
    <x-input-error :messages="$errors->get('answer_text')" class="mt-2" />
</div>

<div class="mt-4">
    <label for="is_correct" class="inline-flex items-center">
        <input id="is_correct" name="is_correct" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('is_correct', $answer->is_correct))>
        <span class="ms-2 text-sm text-gray-700">Correct answer</span>
    </label>
    <x-input-error :messages="$errors->get('is_correct')" class="mt-2" />
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('admin.answers.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
        Cancel
    </a>
</div>
