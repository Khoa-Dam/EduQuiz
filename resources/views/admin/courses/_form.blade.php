<div>
    <x-input-label for="title" value="Title" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $course->title)" placeholder="Laravel Fundamentals" required autofocus />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" rows="5" class="mt-1 block w-full" placeholder="Describe what students will practice in this course.">{{ old('description', $course->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="status" value="Status" />
    <select id="status" name="status" class="mt-1 block w-full">
        @foreach ($statuses as $value => $label)
            <option value="{{ $value }}" @selected(old('status', $course->status ?: 'active') === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('status')" class="mt-2" />
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('admin.courses.index') }}" class="eq-link">
        Cancel
    </a>
</div>
