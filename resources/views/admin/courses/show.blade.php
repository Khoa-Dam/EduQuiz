<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Course Detail
            </h2>
            <a href="{{ route('admin.courses.edit', $course) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Edit Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $course->title }}</h3>
                            <p class="mt-2 text-sm text-gray-600">
                                {{ $course->description ?: 'No description provided.' }}
                            </p>
                        </div>
                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                            {{ ucfirst($course->status) }}
                        </span>
                    </div>

                    <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                        <a href="{{ route('admin.courses.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Back to courses
                        </a>

                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('Delete this course?')">
                                Delete Course
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
