<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Question detail</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Question and answers</h2>
            </div>
            <a href="{{ route('admin.answers.create', ['question_id' => $question->id]) }}" class="eq-btn-primary">Add answer</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">{{ session('success') }}</div>
            @endif

            <section class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $question->quiz->title }} - {{ $question->quiz->course->title }}</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">{{ $question->question_text }}</h3>
                    <p class="mt-3 text-sm font-bold text-slate-500">Points: {{ $question->points }}</p>

                    <div class="mt-7 border-t border-slate-100 pt-5">
                        <div class="mb-4 flex items-center justify-between gap-4">
                            <h4 class="text-lg font-black text-slate-950">Answer choices</h4>
                            <a href="{{ route('admin.questions.edit', $question) }}" class="eq-link">Edit question</a>
                        </div>

                        @if ($question->answers->isEmpty())
                            <x-empty-state title="No answers yet" message="Add answer choices so students can submit this question." :href="route('admin.answers.create', ['question_id' => $question->id])" action="Add answer" />
                        @else
                            <div class="eq-table-wrap">
                                <div class="overflow-x-auto">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Answer</th>
                                                <th>Correct</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($question->answers as $answer)
                                                <tr>
                                                    <td class="font-bold text-slate-950">{{ $answer->answer_text }}</td>
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
                        @endif
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-4">
                        <a href="{{ route('admin.questions.index') }}" class="eq-link">Back to questions</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
