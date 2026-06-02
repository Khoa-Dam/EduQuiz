<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Admin management</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Questions</h2>
            </div>
            <a href="{{ route('admin.questions.create') }}" class="eq-btn-primary">New question</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-4 eq-card">
                <form method="GET" action="{{ route('admin.questions.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <x-input-label for="quiz_id" value="Filter by quiz" />
                        <select id="quiz_id" name="quiz_id" class="mt-2 block w-full">
                            <option value="">All quizzes</option>
                            @foreach ($quizzes as $quiz)
                                <option value="{{ $quiz->id }}" @selected($selectedQuizId === $quiz->id)>
                                    {{ $quiz->title }} - {{ $quiz->course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button>Filter</x-primary-button>
                </form>
            </div>

            <section class="eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-6">
                        <h3 class="eq-section-title">Question bank</h3>
                        <p class="mt-2 eq-muted">Build prompts, points, and answer choices for each quiz.</p>
                    </div>

                    @if ($questions->isEmpty())
                        <x-empty-state title="No questions yet" message="Create questions after a quiz exists so each quiz has answer choices." :href="route('admin.questions.create')" action="Create question" />
                    @else
                        <div class="eq-table-wrap">
                            <div class="overflow-x-auto">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Quiz</th>
                                            <th>Points</th>
                                            <th>Answers</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questions as $question)
                                            <tr>
                                                <td class="max-w-md font-bold text-slate-950"><a href="{{ route('admin.questions.show', $question) }}">{{ \Illuminate\Support\Str::limit($question->question_text, 80) }}</a></td>
                                                <td class="text-slate-700">{{ $question->quiz->title }}</td>
                                                <td class="text-slate-600">{{ $question->points }}</td>
                                                <td class="text-slate-600">{{ $question->answers_count }}</td>
                                                <td>
                                                    <div class="eq-action-row">
                                                        <a href="{{ route('admin.answers.create', ['question_id' => $question->id]) }}" class="eq-link">Add answer</a>
                                                        <a href="{{ route('admin.questions.edit', $question) }}" class="eq-link">Edit</a>
                                                        <form method="POST" action="{{ route('admin.questions.destroy', $question) }}">
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

                        <div class="mt-6">{{ $questions->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
