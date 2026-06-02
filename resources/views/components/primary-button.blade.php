<button {{ $attributes->merge(['type' => 'submit', 'class' => 'eq-btn-primary']) }}>
    {{ $slot }}
</button>
