@props(['value', 'for'])

<label for="{{ $for }}" {{ $attributes->merge(['class' => 'text-sm uppercase tracking-wide font-testo font-bold text-white']) }}>
    {{ $value ?? $slot }}
</label>
