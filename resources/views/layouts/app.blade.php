<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduQuiz') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=eduquiz-1">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-2xl focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-black focus:text-slate-950 focus:shadow-xl">Skip to content</a>
        <x-loading-overlay />

        <div class="eq-app-shell">
            <div class="eq-sidebar-shell">
                @include('layouts.navigation')

                <div class="eq-main-shell">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="eq-shell-header">
                            <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main id="main-content" class="pb-12">
                        {{ $slot }}
                    </main>

                    @auth
                        <nav class="eq-command-dock" aria-label="Quick command dock">
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">Command</a>
                                <a href="{{ route('admin.quiz-builder.create') }}" aria-current="{{ request()->routeIs('admin.quiz-builder.*') ? 'page' : 'false' }}">Studio</a>
                                <a href="{{ route('admin.quizzes.index') }}" aria-current="{{ request()->routeIs('admin.quizzes.*') ? 'page' : 'false' }}">Library</a>
                                <a href="{{ route('admin.attempts.index') }}" aria-current="{{ request()->routeIs('admin.attempts.*') ? 'page' : 'false' }}">Results</a>
                            @else
                                <a href="{{ route('dashboard') }}" aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">Home</a>
                                <a href="{{ route('courses.index') }}" aria-current="{{ request()->routeIs('courses.*') || request()->routeIs('quizzes.*') ? 'page' : 'false' }}">Missions</a>
                                <a href="{{ route('attempts.index') }}" aria-current="{{ request()->routeIs('attempts.*') ? 'page' : 'false' }}">Progress</a>
                            @endif
                        </nav>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
