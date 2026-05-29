@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-emerald-500 bg-emerald-50 py-2 pe-4 ps-3 text-start text-base font-bold text-emerald-900 focus:outline-none focus:bg-emerald-100 transition duration-150 ease-in-out'
            : 'block w-full border-l-4 border-transparent py-2 pe-4 ps-3 text-start text-base font-bold text-slate-600 hover:border-emerald-200 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:bg-slate-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
