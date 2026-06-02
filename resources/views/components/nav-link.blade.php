@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-xl bg-slate-950 px-3 py-1.5 text-sm font-bold leading-5 text-white shadow-sm shadow-slate-300 focus:outline-none focus:ring-2 focus:ring-violet-500 transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-xl px-3 py-1.5 text-sm font-bold leading-5 text-slate-600 hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
