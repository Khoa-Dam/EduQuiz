<div>
    <x-input-label for="question_id" value="Question" />
    <select id="question_id" name="question_id" class="mt-1 block w-full" required>
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
    <textarea id="answer_text" name="answer_text" rows="4" class="mt-1 block w-full" placeholder="Controllers" required>{{ old('answer_text', $answer->answer_text) }}</textarea>
    <x-input-error :messages="$errors->get('answer_text')" class="mt-2" />
</div>

<div class="mt-4">
    <label for="is_correct" class="inline-flex items-center">
        <input id="is_correct" name="is_correct" type="checkbox" value="1" class="rounded shadow-sm" @checked(old('is_correct', $answer->is_correct))>
        <span class="ms-2 text-sm font-semibold text-slate-700">Correct answer</span>
    </label>
    <x-input-error :messages="$errors->get('is_correct')" class="mt-2" />
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('admin.answers.index') }}" class="eq-link">
        Cancel
    </a>
</div>
