@props(['action' => '', 'method' => 'POST'])

<div {{ $attributes->merge(['class' => 'bg-white/5 backdrop-blur-md border border-white/10 rounded-full max-w-6xl mt-8 px-6 py-4 shadow-lg mx-auto']) }}>
    <form action="{{ $action }}" method="{{ $method }}" class="flex flex-col md:flex-row w-full">
        {{ $slot }}
    </form>
</div>
