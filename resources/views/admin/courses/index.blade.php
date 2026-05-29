<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Admin management</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Course Management</h2>
            </div>
            <a href="{{ route('admin.courses.create') }}" class="eq-btn-primary">New course</a>
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
                        <h3 class="eq-section-title">Course library</h3>
                        <p class="mt-2 eq-muted">Create and publish course containers before attaching quizzes.</p>
                    </div>

                    @if ($courses->isEmpty())
                        <x-empty-state title="No courses yet" message="Create the first course to start building quizzes for students." :href="route('admin.courses.create')" action="Create course" />
                    @else
                        <div class="eq-table-wrap">
                            <div class="overflow-x-auto">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $course)
                                            <tr>
                                                <td class="font-bold text-slate-950">
                                                    <a href="{{ route('admin.courses.show', $course) }}">{{ $course->title }}</a>
                                                </td>
                                                <td><span class="eq-status-badge">{{ ucfirst($course->status) }}</span></td>
                                                <td class="text-slate-600">{{ $course->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="eq-action-row">
                                                        <a href="{{ route('admin.courses.edit', $course) }}" class="eq-link">Edit</a>
                                                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}">
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

                        <div class="mt-6">{{ $courses->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
