<div>
    <x-input-label for="course_id" value="Course" />
    <select id="course_id" name="course_id" class="mt-1 block w-full" required>
        <option value="">Select a course</option>
        @foreach ($courses as $course)
            <option value="{{ $course->id }}" @selected((int) old('course_id', $quiz->course_id) === $course->id)>
                {{ $course->title }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="title" value="Title" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $quiz->title)" placeholder="Laravel MVC Quiz" required />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" rows="5" class="mt-1 block w-full" placeholder="Explain the quiz goal and what students should expect.">{{ old('description', $quiz->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <x-input-label for="duration_minutes" value="Duration minutes" />
        <x-text-input id="duration_minutes" name="duration_minutes" type="number" min="1" class="mt-1 block w-full" :value="old('duration_minutes', $quiz->duration_minutes)" placeholder="15" />
        <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full">
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $quiz->status ?: 'active') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('admin.quizzes.index') }}" class="eq-link">
        Cancel
    </a>
</div>
