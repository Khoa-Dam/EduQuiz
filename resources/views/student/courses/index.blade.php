<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-violet-700">Learning catalog</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Courses</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-student-hero mb-6" data-gsap-hero>
                <div class="eq-student-hero-body">
                    <div>
                        <p class="text-sm font-bold text-violet-700">Learning catalog</p>
                        <h3 class="mt-3 max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">Choose what to practice next</h3>
                        <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">Browse active courses, open a quiz, and turn each attempt into fast feedback.</p>
                    </div>
                    <div class="eq-media-frame hidden aspect-[4/3] lg:block" aria-hidden="true">
                        <div class="eq-media-fallback h-full">
                            <span class="eq-media-fallback-mark">{{ $courses->total() }} courses</span>
                        </div>
                    </div>
                </div>
            </section>

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
                                <a href="{{ route('courses.show', $course) }}" class="eq-mission-tile group block" data-gsap-reveal>
                                    <div class="flex items-start justify-between gap-4">
                                        <span class="rounded-xl bg-yellow-300 px-2.5 py-1 text-xs font-black text-slate-950">Active mission path</span>
                                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-50 text-sm font-black text-violet-700 ring-1 ring-violet-100 transition group-hover:bg-violet-600 group-hover:text-white">C</span>
                                    </div>
                                    <h3 class="mt-8 text-2xl font-black text-slate-950">{{ $course->title }}</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $course->description ?: 'No description provided.' }}</p>
                                    <p class="mt-6 text-sm font-black text-violet-700">Open mission path</p>
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
