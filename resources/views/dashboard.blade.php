<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-semibold">Student Dashboard</p>
                    <p class="mt-2 text-sm text-gray-600">
                        You are logged in as a student.
                    </p>
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a href="{{ route('courses.index') }}" class="rounded-md border border-gray-200 p-4 transition hover:border-indigo-300 hover:bg-gray-50">
                            <span class="block text-sm font-semibold text-gray-900">Browse Courses</span>
                            <span class="mt-1 block text-sm text-gray-600">Find active courses and start available quizzes.</span>
                        </a>
                        <a href="{{ route('attempts.index') }}" class="rounded-md border border-gray-200 p-4 transition hover:border-indigo-300 hover:bg-gray-50">
                            <span class="block text-sm font-semibold text-gray-900">My Attempts</span>
                            <span class="mt-1 block text-sm text-gray-600">Review your submitted quiz results.</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
