<button {{ $attributes->merge([
    'type' => 'button',
    'class' => '
        inline-flex items-center justify-center
        px-5 py-2
        rounded-full
        border border-white/20
        bg-white/5
        text-sm text-white/80 font-testo tracking-wide
        backdrop-blur-md
        hover:bg-white/10 hover:text-white
        focus:outline-none focus:ring-2 focus:ring-white/40
        disabled:opacity-30
        transition-all duration-200
    '
]) }}>
    {{ $slot }}
</button>
