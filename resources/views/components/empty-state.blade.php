@props([
    'title',
    'message',
    'href' => null,
    'action' => null,
])

<div {{ $attributes->merge(['class' => 'eq-empty']) }}>
    <p class="eq-empty-title">{{ $title }}</p>
    <p class="eq-empty-text">{{ $message }}</p>

    @if ($href && $action)
        <div class="mt-5">
            <a href="{{ $href }}" class="eq-btn-secondary">{{ $action }}</a>
        </div>
    @endif
</div>
