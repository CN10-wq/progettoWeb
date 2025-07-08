<button {{ $attributes->merge([
    'type' => 'button',
    'class' => '
        inline-flex items-center justify-center
        px-6 py-3
        rounded-full
        border-2 border-red-600
        bg-red-600/20
        text-base text-white font-bold tracking-wider font-testo uppercase
        backdrop-blur-md
        hover:bg-red-600 hover:text-white
        focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-0
        disabled:opacity-40
        transition-all duration-200
    '
]) }}>
    {{ $slot }}
</button>
