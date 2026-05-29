<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Admin management</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">Create answer</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="eq-panel">
                <form method="POST" action="{{ route('admin.answers.store') }}" class="eq-panel-body" x-data="{ submitting: false }" x-on:submit="submitting = true">
                    @csrf

                    @include('admin.answers._form', [
                        'answer' => $answer,
                        'questions' => $questions,
                        'submitLabel' => 'Create Answer',
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
