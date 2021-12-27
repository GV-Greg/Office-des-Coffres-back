<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-auth uppercase tracking-widest focus:outline-none']) }}>
    {{ $slot }}
</button>
