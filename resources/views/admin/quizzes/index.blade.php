<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Admin management</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Quiz Management</h2>
            </div>
            <a href="{{ route('admin.quizzes.create') }}" class="eq-btn-primary">New quiz</a>
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
                        <p class="mt-2 eq-muted">Attach assessments to courses and control publishing status.</p>
                    </div>

                    @if ($quizzes->isEmpty())
                        <x-empty-state title="No quizzes yet" message="Create a quiz and attach it to a course so students can practice." :href="route('admin.quizzes.create')" action="Create quiz" />
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
                                                <td><span class="eq-status-badge">{{ ucfirst($quiz->status) }}</span></td>
                                                <td>
                                                    <div class="eq-action-row">
                                                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="eq-link">Edit</a>
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
