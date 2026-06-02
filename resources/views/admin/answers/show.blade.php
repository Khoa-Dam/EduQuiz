<x-app-layout>
    <x-slot name="header">
        <div class="eq-page-heading">
            <div>
                <p class="text-sm font-bold text-emerald-700">Answer detail</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Answer choice</h2>
            </div>
            <a href="{{ route('admin.answers.edit', $answer) }}" class="eq-btn-primary">Edit answer</a>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <section class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $answer->is_correct ? 'Correct answer' : 'Answer option' }}</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">{{ $answer->answer_text }}</h3>
                    <p class="mt-4 text-sm leading-6 text-slate-600">Question: {{ $answer->question->question_text }}</p>

                    <div class="mt-8 border-t border-slate-100 pt-5">
                        <a href="{{ route('admin.answers.index') }}" class="eq-link">Back to answers</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
