<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Admin management</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Answers</h2>
            </div>
            <a href="{{ route('admin.answers.create') }}" class="eq-btn-primary">New answer</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <div class="mb-4 eq-card">
                <form method="GET" action="{{ route('admin.answers.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <x-input-label for="question_id" value="Filter by question" />
                        <select id="question_id" name="question_id" class="mt-2 block w-full">
                            <option value="">All questions</option>
                            @foreach ($questions as $question)
                                <option value="{{ $question->id }}" @selected($selectedQuestionId === $question->id)>
                                    {{ \Illuminate\Support\Str::limit($question->question_text, 90) }}
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
                        <h3 class="eq-section-title">Answer choices</h3>
                        <p class="mt-2 eq-muted">Maintain answer options and correct answer flags for quiz scoring.</p>
                    </div>

                    @if ($answers->isEmpty())
                        <x-empty-state title="No answers yet" message="Create answers from a question detail page and mark at least one answer as correct." :href="route('admin.answers.create')" action="Create answer" />
                    @else
                        <div class="eq-table-wrap">
                            <div class="overflow-x-auto">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Answer</th>
                                            <th>Question</th>
                                            <th>Correct</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($answers as $answer)
                                            <tr>
                                                <td class="font-bold text-slate-950">{{ \Illuminate\Support\Str::limit($answer->answer_text, 70) }}</td>
                                                <td class="text-slate-700">{{ \Illuminate\Support\Str::limit($answer->question->question_text, 70) }}</td>
                                                <td><span class="eq-status-badge {{ $answer->is_correct ? 'bg-emerald-50 text-emerald-800 ring-emerald-200' : '' }}">{{ $answer->is_correct ? 'Yes' : 'No' }}</span></td>
                                                <td>
                                                    <div class="eq-action-row">
                                                        <a href="{{ route('admin.answers.edit', $answer) }}" class="eq-link">Edit</a>
                                                        <form method="POST" action="{{ route('admin.answers.destroy', $answer) }}">
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

                        <div class="mt-6">{{ $answers->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
