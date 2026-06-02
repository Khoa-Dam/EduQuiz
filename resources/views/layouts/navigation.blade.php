@php
    $isAdmin = Auth::user()?->isAdmin();
    $links = $isAdmin
        ? [
            ['label' => 'Admin', 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'icon' => 'A'],
            ['label' => 'Courses', 'href' => route('admin.courses.index'), 'active' => request()->routeIs('admin.courses.*'), 'icon' => 'C'],
            ['label' => 'Quizzes', 'href' => route('admin.quizzes.index'), 'active' => request()->routeIs('admin.quizzes.*'), 'icon' => 'Q'],
            ['label' => 'Questions', 'href' => route('admin.questions.index'), 'active' => request()->routeIs('admin.questions.*') || request()->routeIs('admin.answers.*'), 'icon' => '?'],
            ['label' => 'Results', 'href' => route('admin.attempts.index'), 'active' => request()->routeIs('admin.attempts.*'), 'icon' => 'R'],
        ]
        : [
            ['label' => 'Dashboard', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard'), 'icon' => 'D'],
            ['label' => 'Courses', 'href' => route('courses.index'), 'active' => request()->routeIs('courses.*') || request()->routeIs('quizzes.*'), 'icon' => 'C'],
            ['label' => 'My Attempts', 'href' => route('attempts.index'), 'active' => request()->routeIs('attempts.*'), 'icon' => 'A'],
        ];
@endphp

<aside class="eq-sidebar">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-950 text-base font-black text-emerald-300 shadow-lg shadow-slate-300">EQ</span>
        <span>
            <span class="block text-lg font-black tracking-tight text-slate-950">EduQuiz</span>
            <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Mini Quiz LMS</span>
        </span>
    </a>

    <div class="mt-8">
        <p class="px-3 text-xs font-black uppercase tracking-[0.16em] text-slate-400">{{ $isAdmin ? 'Management' : 'Learning' }}</p>
        <nav class="mt-3 grid gap-2" aria-label="Primary">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" class="eq-side-link {{ $link['active'] ? 'eq-side-link-active' : '' }}">
                    <span class="eq-side-icon">{{ $link['icon'] }}</span>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <div class="mt-auto rounded-3xl border border-slate-200 bg-slate-50 p-4">
        <p class="text-xs font-black uppercase tracking-[0.14em] text-slate-400">Signed in</p>
        <p class="mt-2 truncate text-sm font-black text-slate-950">{{ Auth::user()->name }}</p>
        <p class="mt-1 truncate text-xs font-semibold text-slate-500">{{ Auth::user()->email }}</p>

        <div class="mt-4 grid gap-2">
            <a href="{{ route('profile.edit') }}" class="eq-btn-secondary justify-start px-3 py-2">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="eq-btn-ghost w-full justify-start px-3 py-2 text-red-700 hover:bg-red-50 hover:text-red-800">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</aside>

<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-white/80 bg-white/85 shadow-sm shadow-slate-200/70 backdrop-blur lg:hidden">
    <div class="mx-auto px-4 sm:px-6">
        <div class="flex min-h-16 items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-sm font-black text-emerald-300 shadow-sm shadow-slate-300">EQ</span>
                <span class="leading-tight">
                    <span class="block text-base font-black tracking-tight text-slate-950">EduQuiz</span>
                    <span class="block text-[11px] font-bold uppercase tracking-[0.16em] text-emerald-700">Mini LMS</span>
                </span>
            </a>

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-2xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
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
            <div>
                <div class="text-base font-black text-slate-900">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
