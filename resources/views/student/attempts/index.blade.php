<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Result history</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">My attempts</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6 grid gap-4 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-end">
                        <div>
                            <h3 class="eq-section-title">Submitted quiz results</h3>
                            <p class="mt-2 eq-muted">Review scores, submitted times, XP earned, and detailed answer feedback.</p>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="eq-game-mini">
                                <span>Level</span>
                                <strong>{{ $progress['level'] }}</strong>
                            </div>
                            <div class="eq-game-mini">
                                <span>XP</span>
                                <strong>{{ $progress['totalXp'] }}</strong>
                            </div>
                            <div class="eq-game-mini">
                                <span>Streak</span>
                                <strong>{{ $progress['currentStreak'] }}d</strong>
                            </div>
                        </div>
                    </div>
                    @if ($attempts->isEmpty())
                        <x-empty-state title="No attempts yet" message="Take a quiz to see your scores and answer history here." :href="route('courses.index')" action="Browse courses" />
                    @else
                        <div class="eq-table-wrap">
                            <div class="overflow-x-auto">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Quiz</th>
                                            <th>Course</th>
                                            <th>Score</th>
                                            <th>XP</th>
                                            <th>Submitted</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attempts as $attempt)
                                            <tr>
                                                <td class="font-bold text-slate-950">
                                                    <div class="flex items-center gap-3">
                                                        <div class="h-12 w-16 overflow-hidden rounded-xl bg-slate-900">
                                                            @if ($attempt->quiz->coverImageUrl())
                                                                <img src="{{ $attempt->quiz->coverImageUrl() }}" alt="" class="h-full w-full object-cover">
                                                            @else
                                                                <div class="eq-media-fallback h-full"></div>
                                                            @endif
                                                        </div>
                                                        <span>{{ $attempt->quiz->title }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-slate-700">{{ $attempt->quiz->course->title }}</td>
                                                <td class="font-bold text-slate-900">{{ $attempt->score }} / {{ $attempt->total_questions }}</td>
                                                <td class="font-black text-emerald-700">+{{ $attempt->xp_earned }}</td>
                                                <td class="text-slate-600">{{ $attempt->submitted_at?->format('Y-m-d H:i') }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('attempts.show', $attempt) }}" class="eq-link">View result</a>
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
