<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Course
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.courses.store') }}" class="p-6">
                    @csrf

                    @include('admin.courses._form', [
                        'course' => $course,
                        'statuses' => $statuses,
                        'submitLabel' => 'Create Course',
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
