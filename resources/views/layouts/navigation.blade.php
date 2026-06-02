@php
    $isAdmin = Auth::user()?->isAdmin();
    $links = $isAdmin
        ? [
            ['label' => 'Admin', 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'icon' => 'A'],
            ['label' => 'Builder', 'href' => route('admin.quiz-builder.create'), 'active' => request()->routeIs('admin.quiz-builder.*'), 'icon' => 'B'],
            ['label' => 'Courses', 'href' => route('admin.courses.index'), 'active' => request()->routeIs('admin.courses.*'), 'icon' => 'C'],
            ['label' => 'Quizzes', 'href' => route('admin.quizzes.index'), 'active' => request()->routeIs('admin.quizzes.*') || request()->routeIs('admin.questions.*') || request()->routeIs('admin.answers.*'), 'icon' => 'Q'],
            ['label' => 'Results', 'href' => route('admin.attempts.index'), 'active' => request()->routeIs('admin.attempts.*'), 'icon' => 'R'],
        ]
        : [
            ['label' => 'Dashboard', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard'), 'icon' => 'D'],
            ['label' => 'Courses', 'href' => route('courses.index'), 'active' => request()->routeIs('courses.*') || request()->routeIs('quizzes.*'), 'icon' => 'C'],
            ['label' => 'My Attempts', 'href' => route('attempts.index'), 'active' => request()->routeIs('attempts.*'), 'icon' => 'A'],
        ];
@endphp

<aside class="eq-sidebar">
    <div class="eq-topbar">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-violet-500">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-950 text-sm font-black text-white">EQ</span>
            <span class="hidden sm:block">
                <span class="block text-base font-black tracking-tight text-slate-950">EduQuiz</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 rounded-full bg-slate-100 p-1 lg:flex" aria-label="Primary">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" class="eq-top-link {{ $link['active'] ? 'eq-top-link-active' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="relative flex items-center" x-data="{ userMenuOpen: false }" x-on:keydown.escape.window="userMenuOpen = false">
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-full p-1.5 text-slate-700 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-violet-500"
                aria-haspopup="menu"
                x-bind:aria-expanded="userMenuOpen.toString()"
                x-on:click="userMenuOpen = ! userMenuOpen"
            >
                @if (Auth::user()->avatarUrl())
                    <img src="{{ Auth::user()->avatarUrl() }}" alt="Profile photo for {{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover shadow-sm">
                @else
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-violet-600 text-white shadow-sm" aria-hidden="true">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 21a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                @endif
                <svg class="hidden h-4 w-4 text-slate-500 sm:block" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="sr-only">Open user menu</span>
            </button>

            <div
                x-cloak
                x-show="userMenuOpen"
                x-transition.opacity.scale.origin.top.right
                x-on:click.outside="userMenuOpen = false"
                role="menu"
                class="absolute right-0 top-12 z-50 w-64 overflow-hidden rounded-2xl border border-white/80 bg-white p-2 text-slate-950 shadow-2xl shadow-slate-400/30"
            >
                <div class="border-b border-slate-100 px-3 py-3">
                    <p class="truncate text-sm font-black">{{ Auth::user()->name }}</p>
                    <p class="mt-1 truncate text-xs font-semibold text-slate-500">{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="mt-2 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500" role="menuitem" x-on:click="userMenuOpen = false">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 21a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-bold text-slate-700 transition hover:bg-red-50 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" role="menuitem">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="m16 17 5-5-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-white/80 bg-white/85 shadow-sm shadow-slate-200/70 backdrop-blur lg:hidden">
    <div class="mx-auto px-4 sm:px-6">
        <div class="flex min-h-16 items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-violet-500">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-sm font-black text-white shadow-sm shadow-slate-300">EQ</span>
                <span class="leading-tight">
                    <span class="block text-base font-black tracking-tight text-slate-950">EduQuiz</span>
                    <span class="block text-[11px] font-bold uppercase tracking-[0.16em] text-violet-700">Mini LMS</span>
                </span>
            </a>

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-2xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-violet-500">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-100 bg-white/95">
        <div class="space-y-1 px-4 py-3">
            @foreach ($links as $link)
                <x-responsive-nav-link :href="$link['href']" :active="$link['active']">
                    {{ $link['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="border-t border-slate-100 px-4 py-4">
            <div class="flex items-center gap-3">
                @if (Auth::user()->avatarUrl())
                    <img src="{{ Auth::user()->avatarUrl() }}" alt="Profile photo for {{ Auth::user()->name }}" class="h-12 w-12 rounded-2xl object-cover shadow-sm">
                @else
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-600 text-sm font-black text-white shadow-sm">
                        {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                    </span>
                @endif
                <div class="min-w-0">
                    <div class="truncate text-base font-black text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="truncate text-sm font-medium text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <span class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 21a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ __('Profile') }}
                    </span>
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="m16 17 5-5-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            {{ __('Log Out') }}
                        </span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
