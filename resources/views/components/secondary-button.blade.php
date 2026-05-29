<button {{ $attributes->merge(['type' => 'button', 'class' => 'eq-btn-secondary disabled:opacity-25']) }}>
    {{ $slot }}
</button>
