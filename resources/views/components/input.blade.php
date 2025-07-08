@props(['disabled' => false])

<input {{ $attributes->merge([
    'class' => 'bg-transparent border border-white/30 text-white placeholder-white rounded-full px-10 py-2 w-full
                focus:outline-none focus:bg-transparent focus:ring-2 focus:ring-white/50 hover:border-white font-testo font-bold appearance-none relative z-10'
]) }} {{ $disabled ? 'disabled' : '' }}>
