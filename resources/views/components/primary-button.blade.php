<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-6 py-3 font-semibold text-white bg-primary rounded-lg shadow-md hover:bg-primary/90 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary']) }}>
    {{ $slot }}
</button>
