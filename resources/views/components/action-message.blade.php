@props(['on'])

<div
    x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => {
        clearTimeout(timeout);
        shown = true;
        timeout = setTimeout(() => { shown = false }, 2000);
    })"
    x-show.transition.opacity.duration.800ms="shown"
    x-transition:leave.opacity.duration.600ms
    style="display: none;"
    {{ $attributes->merge([
        'class' => 'px-4 py-2 text-sm text-white bg-transparent rounded-xl shadow transition'
    ]) }}>
    {{ $slot->isEmpty() ? 'Salvato!' : $slot }}
</div>
