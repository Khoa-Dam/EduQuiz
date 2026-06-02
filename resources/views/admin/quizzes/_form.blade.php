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

<div class="mt-4">
    <x-input-label for="cover_image" value="Cover image" />
    @if ($quiz->coverImageUrl())
        <div class="mt-2 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
            <img src="{{ $quiz->coverImageUrl() }}" alt="Current cover image for {{ $quiz->title }}" class="h-44 w-full object-cover">
        </div>
        <label class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="remove_cover_image" value="1" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
            Remove current image
        </label>
    @endif
    <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-emerald-950">
    <p class="mt-2 text-xs font-semibold text-slate-500">JPG, PNG, or WebP. Maximum 2MB.</p>
    <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
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
    <x-primary-button x-bind:disabled="submitting">
        <span x-show="! submitting">{{ $submitLabel }}</span>
        <span x-cloak x-show="submitting">Saving...</span>
    </x-primary-button>
    <a href="{{ route('admin.quizzes.index') }}" class="eq-link">
        Cancel
    </a>
</div>
