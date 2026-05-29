<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Learning catalog</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Courses</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <div class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6">
                        <h3 class="eq-section-title">Choose a course to practice</h3>
                        <p class="mt-2 eq-muted">Only active courses are shown to students.</p>
                    </div>
                    @if ($courses->isEmpty())
                        <div class="eq-empty">
                            <p class="text-sm font-medium text-gray-900">No active courses available.</p>
                            <p class="mt-1 text-sm text-gray-600">Check again after an admin publishes courses.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach ($courses as $course)
                                <a href="{{ route('courses.show', $course) }}" class="eq-card block">
                                    <span class="eq-badge">Active course</span>
                                    <h3 class="mt-4 text-xl font-bold text-slate-950">{{ $course->title }}</h3>
                                    <p class="mt-2 eq-muted">{{ $course->description ?: 'No description provided.' }}</p>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
