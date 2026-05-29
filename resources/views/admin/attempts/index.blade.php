<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Admin review</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Attempt Review</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <div class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6">
                        <h3 class="eq-section-title">Student submissions</h3>
                        <p class="mt-2 eq-muted">Use this page during the demo to show stored attempts and scoring output.</p>
                    </div>
                    @if ($attempts->isEmpty())
                        <x-empty-state
                            title="No attempts yet"
                            message="Student submissions will appear here after a quiz is completed."
                            :href="route('admin.dashboard')"
                            action="Back to dashboard"
                        />
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Student</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Quiz</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Course</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Score</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($attempts as $attempt)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $attempt->user->name }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->quiz->title }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->quiz->course->title }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->score }} / {{ $attempt->total_questions }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('admin.attempts.show', $attempt) }}" class="font-medium text-indigo-700 hover:text-indigo-900">
                                                    Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $attempts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
