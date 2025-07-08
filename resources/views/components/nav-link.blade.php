@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-1 border-b-2 border-white text-sm font-bold leading-5 text-white transition duration-200 ease-in-out'
    : 'inline-flex items-center px-3 py-1 border-b-2 border-transparent text-sm font-bold leading-5 text-white/60 hover:text-white hover:border-white/30 transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
