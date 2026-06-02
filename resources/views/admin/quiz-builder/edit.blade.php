<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-violet-700">Quiz Builder - Live Studio</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h2>
            </div>
            <a href="{{ route('admin.quizzes.show', $quiz) }}" class="eq-btn-secondary">View quiz</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            @include('admin.quiz-builder._form', [
                'action' => route('admin.quiz-builder.update', $quiz),
                'method' => 'PUT',
                'submitLabel' => $quiz->status === 'active' ? 'Save changes' : 'Save draft',
                'submitIntent' => $quiz->status === 'active' ? 'save' : 'draft',
            ])
        </div>
    </div>
</x-app-layout>
