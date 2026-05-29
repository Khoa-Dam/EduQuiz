@props([
    'title',
    'message',
    'href' => null,
    'action' => null,
])

<div {{ $attributes->merge(['class' => 'eq-empty']) }}>
    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-lg font-black text-emerald-700 shadow-sm shadow-emerald-100">EQ</div>
    <p class="eq-empty-title">{{ $title }}</p>
    <p class="eq-empty-text">{{ $message }}</p>

    @if ($href && $action)
        <div class="mt-5">
            <a href="{{ $href }}" class="eq-btn-secondary">{{ $action }}</a>
        </div>
    @endif
</div>
