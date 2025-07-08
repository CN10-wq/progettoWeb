<a {{ $attributes->merge([
    'class' => 'block w-full px-4 py-2 text-start font-bold text-sm leading-5 text-white/80 hover:bg-white/10 hover:text-white focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out'
]) }}>
    {{ $slot }}
</a>
