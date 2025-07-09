@props(['id' => 'modaleGuest', 'maxWidth' => '2xl'])

@php
$widthClass = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6 sm:px-0 font-testo">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" onclick="chiudiModale('{{ $id }}')"></div>

    <div class="relative w-full {{ $widthClass }} bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-2xl overflow-hidden shadow-2xl z-10 p-8
                transition-all duration-300 transform scale-100 hover:scale-[1.01]">
        {{ $slot }}
    </div>
</div>

