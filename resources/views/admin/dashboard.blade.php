<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-semibold">Admin Dashboard</p>
                    <p class="mt-2 text-sm text-gray-600">
                        Manage EduQuiz courses, quizzes, questions, and student attempts from here.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Manage Courses
                        </a>
                        <a href="{{ route('admin.quizzes.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Manage Quizzes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
