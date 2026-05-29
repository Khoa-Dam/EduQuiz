<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Course detail</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $course->title }}</h2>
            </div>
            <a href="{{ route('admin.courses.edit', $course) }}" class="eq-btn-primary">Edit course</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">{{ session('success') }}</div>
            @endif

            <section class="eq-panel">
                <div class="eq-panel-body">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="eq-badge">Course</p>
                            <h3 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $course->title }}</h3>
                            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $course->description ?: 'No description provided.' }}</p>
                        </div>
                        <span class="eq-status-badge">{{ ucfirst($course->status) }}</span>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('admin.courses.index') }}" class="eq-link">Back to courses</a>

                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">Delete course</x-danger-button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
