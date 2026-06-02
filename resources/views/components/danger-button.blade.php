<button {{ $attributes->merge(['type' => 'submit', 'class' => 'eq-btn-danger']) }}>
    {{ $slot }}
</button>
