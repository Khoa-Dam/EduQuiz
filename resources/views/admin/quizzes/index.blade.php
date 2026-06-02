<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Admin management</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Quiz Management</h2>
            </div>
            <a href="{{ route('admin.quiz-builder.create') }}" class="eq-btn-primary">Create quiz</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">{{ session('success') }}</div>
            @endif

            <section class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6">
                        <h3 class="eq-section-title">Quiz library</h3>
                        <p class="mt-2 eq-muted">Continue drafts, fix setup issues, and publish complete quizzes from one builder.</p>
                    </div>

                    @if ($quizzes->isEmpty())
                        <x-empty-state title="No quizzes yet" message="Create a quiz with course, questions, and answers in one guided flow." :href="route('admin.quiz-builder.create')" action="Open builder" />
                    @else
                        <div class="eq-table-wrap">
                            <div class="overflow-x-auto">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Course</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quizzes as $quiz)
                                            <tr>
                                                <td class="font-bold text-slate-950"><a href="{{ route('admin.quizzes.show', $quiz) }}">{{ $quiz->title }}</a></td>
                                                <td class="text-slate-700">{{ $quiz->course->title }}</td>
                                                <td class="text-slate-600">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' min' : 'No limit' }}</td>
                                                <td>
                                                    @php($ready = $quizReadiness[$quiz->id] ?? false)
                                                    <span class="eq-status-badge {{ $quiz->status === 'active' ? 'bg-emerald-50 text-emerald-800 ring-emerald-200' : ($ready ? 'bg-amber-50 text-amber-800 ring-amber-200' : '') }}">
                                                        {{ $quiz->status === 'active' ? 'Active' : ($ready ? 'Ready' : 'Needs setup') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="eq-action-row">
                                                        <a href="{{ route('admin.quiz-builder.edit', $quiz) }}" class="eq-link">Builder</a>
                                                        <a href="{{ route('admin.quizzes.show', $quiz) }}" class="eq-link">View</a>
                                                        <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="eq-delete-link" onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6">{{ $quizzes->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
