<div>
    <x-input-label for="quiz_id" value="Quiz" />
    <select id="quiz_id" name="quiz_id" class="mt-1 block w-full" required>
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
    <textarea id="question_text" name="question_text" rows="5" class="mt-1 block w-full" placeholder="Which layer handles HTTP requests in Laravel MVC?" required>{{ old('question_text', $question->question_text) }}</textarea>
    <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="question_image" value="Question image" />
    @if ($question->imageUrl())
        <div class="mt-2 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
            <img src="{{ $question->imageUrl() }}" alt="Current image for this question" class="h-44 w-full object-cover">
        </div>
        <label class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="remove_question_image" value="1" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
            Remove current image
        </label>
    @endif
    <input id="question_image" name="question_image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-emerald-950">
    <p class="mt-2 text-xs font-semibold text-slate-500">JPG, PNG, or WebP. Maximum 2MB.</p>
    <x-input-error :messages="$errors->get('question_image')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="points" value="Points" />
    <x-text-input id="points" name="points" type="number" min="1" max="100" class="mt-1 block w-full" :value="old('points', $question->points ?: 1)" required />
    <x-input-error :messages="$errors->get('points')" class="mt-2" />
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button x-bind:disabled="submitting">
        <span x-show="! submitting">{{ $submitLabel }}</span>
        <span x-cloak x-show="submitting">Saving...</span>
    </x-primary-button>
    <a href="{{ route('admin.questions.index') }}" class="eq-link">
        Cancel
    </a>
</div>
