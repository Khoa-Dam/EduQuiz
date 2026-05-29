<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Result history</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">My Attempts</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <div class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6">
                        <h3 class="eq-section-title">Submitted quiz results</h3>
                        <p class="mt-2 eq-muted">Review scores, submitted times, and detailed answer feedback.</p>
                    </div>
                    @if ($attempts->isEmpty())
                        <x-empty-state
                            title="No attempts yet"
                            message="Take a quiz to see your scores and answer history here."
                            :href="route('courses.index')"
                            action="Browse courses"
                        />
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Quiz</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Course</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Score</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Submitted</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($attempts as $attempt)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $attempt->quiz->title }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->quiz->course->title }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->score }} / {{ $attempt->total_questions }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $attempt->submitted_at?->format('Y-m-d H:i') }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('attempts.show', $attempt) }}" class="font-medium text-indigo-700 hover:text-indigo-900">
                                                    View result
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
