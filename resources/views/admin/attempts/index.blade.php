<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Admin review</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Attempt review</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6">
                        <h3 class="eq-section-title">Student submissions</h3>
                        <p class="mt-2 eq-muted">Use this page during the demo to show stored attempts and scoring output.</p>
                    </div>
                    @if ($attempts->isEmpty())
                        <x-empty-state title="No attempts yet" message="Student submissions will appear here after a quiz is completed." :href="route('admin.dashboard')" action="Back to dashboard" />
                    @else
                        <div class="eq-table-wrap">
                            <div class="overflow-x-auto">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Quiz</th>
                                            <th>Course</th>
                                            <th>Score</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attempts as $attempt)
                                            <tr>
                                                <td class="font-bold text-slate-950">{{ $attempt->user->name }}</td>
                                                <td class="text-slate-700">{{ $attempt->quiz->title }}</td>
                                                <td class="text-slate-700">{{ $attempt->quiz->course->title }}</td>
                                                <td class="font-bold text-slate-900">{{ $attempt->score }} / {{ $attempt->total_questions }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('admin.attempts.show', $attempt) }}" class="eq-link">Review</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6">{{ $attempts->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
