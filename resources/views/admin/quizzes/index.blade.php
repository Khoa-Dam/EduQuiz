<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz Management
            </h2>
            <a href="{{ route('admin.quizzes.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                New Quiz
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($quizzes->isEmpty())
                        <div class="rounded-md border border-dashed border-gray-300 p-8 text-center">
                            <p class="text-sm font-medium text-gray-900">No quizzes yet.</p>
                            <p class="mt-1 text-sm text-gray-600">Create a quiz and attach it to a course.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Title</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Course</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Duration</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($quizzes as $quiz)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                <a href="{{ route('admin.quizzes.show', $quiz) }}" class="hover:text-indigo-700">
                                                    {{ $quiz->title }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">{{ $quiz->course->title }}</td>
                                            <td class="px-4 py-3 text-gray-600">
                                                {{ $quiz->duration_minutes ? $quiz->duration_minutes.' min' : 'No limit' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">
                                                    {{ ucfirst($quiz->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex justify-end gap-3">
                                                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="font-medium text-indigo-700 hover:text-indigo-900">Edit</a>
                                                    <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-red-700 hover:text-red-900" onclick="return confirm('Delete this quiz?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $quizzes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
