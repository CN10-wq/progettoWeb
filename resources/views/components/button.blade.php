<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-white px-6 py-3 rounded-full border border-white tracking-wide uppercase backdrop-blur-md bg-white/10 hover:bg-white/90 hover:text-[#2b2b2b]
                transition-all shadow-sm hover:shadow-lg font-testo font-bold']) }}>
    {{ $slot }}
</button>
