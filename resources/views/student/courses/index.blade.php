<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Courses
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($courses->isEmpty())
                        <div class="rounded-md border border-dashed border-gray-300 p-8 text-center">
                            <p class="text-sm font-medium text-gray-900">No active courses available.</p>
                            <p class="mt-1 text-sm text-gray-600">Check again after an admin publishes courses.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach ($courses as $course)
                                <a href="{{ route('courses.show', $course) }}" class="block rounded-md border border-gray-200 p-5 transition hover:border-indigo-300 hover:bg-gray-50">
                                    <h3 class="text-base font-semibold text-gray-900">{{ $course->title }}</h3>
                                    <p class="mt-2 text-sm text-gray-600">{{ $course->description ?: 'No description provided.' }}</p>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
