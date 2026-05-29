<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-white/80 bg-white/80 shadow-sm shadow-slate-200/70 backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-14 justify-between gap-4 py-2.5">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-950 text-sm font-black text-emerald-300 shadow-sm shadow-slate-300">EQ</span>
                        <span class="hidden leading-tight sm:block">
                            <span class="block text-base font-black tracking-tight text-slate-950">EduQuiz</span>
                            <span class="block text-[11px] font-bold uppercase tracking-[0.16em] text-emerald-700">Mini LMS</span>
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden items-center gap-1.5 sm:ms-7 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if (! Auth::user()?->isAdmin())
                        <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*') || request()->routeIs('quizzes.*')">
                            {{ __('Courses') }}
                        </x-nav-link>
                        <x-nav-link :href="route('attempts.index')" :active="request()->routeIs('attempts.*')">
                            {{ __('My Attempts') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::user()?->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses.*')">
                            {{ __('Courses') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.quizzes.index')" :active="request()->routeIs('admin.quizzes.*')">
                            {{ __('Quizzes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.questions.index')" :active="request()->routeIs('admin.questions.*')">
                            {{ __('Questions') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.attempts.index')" :active="request()->routeIs('admin.attempts.*')">
                            {{ __('Results') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm font-bold leading-4 text-slate-600 shadow-sm transition duration-150 ease-in-out hover:border-emerald-300 hover:text-slate-900 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 transition duration-150 ease-in-out hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:bg-slate-100 focus:text-slate-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if (! Auth::user()?->isAdmin())
                <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*') || request()->routeIs('quizzes.*')">
                    {{ __('Courses') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('attempts.index')" :active="request()->routeIs('attempts.*')">
                    {{ __('My Attempts') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::user()?->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses.*')">
                    {{ __('Courses') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.quizzes.index')" :active="request()->routeIs('admin.quizzes.*')">
                    {{ __('Quizzes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.questions.index')" :active="request()->routeIs('admin.questions.*')">
                    {{ __('Questions') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.attempts.index')" :active="request()->routeIs('admin.attempts.*')">
                    {{ __('Results') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
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
