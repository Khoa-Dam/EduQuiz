<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Course
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="p-6" x-data="{ submitting: false }" x-on:submit="submitting = true">
                    @csrf
                    @method('PUT')

                    @include('admin.courses._form', [
                        'course' => $course,
                        'statuses' => $statuses,
                        'submitLabel' => 'Update Course',
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
