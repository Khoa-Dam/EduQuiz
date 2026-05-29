<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Quiz detail</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h2>
            </div>
            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="eq-btn-primary">Edit quiz</a>
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
                            <p class="eq-badge">{{ $quiz->course->title }}</p>
                            <h3 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h3>
                            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $quiz->description ?: 'No description provided.' }}</p>
                        </div>
                        <span class="eq-status-badge">{{ ucfirst($quiz->status) }}</span>
                    </div>

                    <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Duration</dt>
                            <dd class="mt-2 text-xl font-black text-slate-950">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No limit' }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Created</dt>
                            <dd class="mt-2 text-xl font-black text-slate-950">{{ $quiz->created_at->format('Y-m-d') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('admin.quizzes.index') }}" class="eq-link">Back to quizzes</a>

                        <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">Delete quiz</x-danger-button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
