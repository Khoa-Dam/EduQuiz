@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'eq-alert-success']) }}>
        {{ $status }}
    </div>
@endif
