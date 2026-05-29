<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attempt Review
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($attempts->isEmpty())
                        <div class="rounded-md border border-dashed border-gray-300 p-8 text-center">
                            <p class="text-sm font-medium text-gray-900">No attempts yet.</p>
                            <p class="mt-1 text-sm text-gray-600">Student submissions will appear here.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Student</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Quiz</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Course</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Score</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($attempts as $attempt)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $attempt->user->name }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->quiz->title }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->quiz->course->title }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $attempt->score }} / {{ $attempt->total_questions }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('admin.attempts.show', $attempt) }}" class="font-medium text-indigo-700 hover:text-indigo-900">
                                                    Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $attempts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
