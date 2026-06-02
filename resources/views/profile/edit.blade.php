<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Account settings</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ __('Profile') }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container space-y-6">
            <div class="eq-panel">
                <div class="max-w-xl">
                    <div class="eq-panel-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="eq-panel">
                <div class="max-w-xl">
                    <div class="eq-panel-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="eq-panel">
                <div class="max-w-xl">
                    <div class="eq-panel-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
