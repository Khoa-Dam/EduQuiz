@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-full bg-emerald-50 px-3 py-2 text-sm font-semibold leading-5 text-emerald-800 ring-1 ring-inset ring-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-full px-3 py-2 text-sm font-semibold leading-5 text-slate-600 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
