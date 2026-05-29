<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Learning catalog</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Courses</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h3 class="eq-section-title">Choose a course to practice</h3>
                            <p class="mt-2 eq-muted">Only active courses are shown to students.</p>
                        </div>
                        <span class="eq-badge">{{ $courses->total() }} available</span>
                    </div>

                    @if ($courses->isEmpty())
                        <x-empty-state title="No active courses available" message="Check again after an admin publishes courses for students." :href="route('dashboard')" action="Back to dashboard" />
                    @else
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach ($courses as $course)
                                <a href="{{ route('courses.show', $course) }}" class="eq-card group block">
                                    <div class="flex items-start justify-between gap-4">
                                        <span class="eq-badge">Active course</span>
                                        <span class="eq-stat-marker transition group-hover:bg-emerald-200">C</span>
                                    </div>
                                    <h3 class="mt-4 text-xl font-black text-slate-950">{{ $course->title }}</h3>
                                    <p class="mt-2 eq-muted">{{ $course->description ?: 'No description provided.' }}</p>
                                    <p class="mt-5 text-sm font-black text-emerald-700">Open course</p>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6">{{ $courses->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
