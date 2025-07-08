@props([
    'title' => __('Conferma password'),
    'content' => __('Per motivi di sicurezza, conferma la tua password per continuare.'),
    'button' => __('Conferma')
])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-dialog-modal wire:model.live="confirmingPassword">
    <x-slot name="title">
        <span class="text-white font-tit text-xl tracking-wide">
            {{ $title }}
        </span>
    </x-slot>

    <x-slot name="content">
        <p class="text-white/80 text-sm leading-relaxed">
            {{ $content }}
        </p>

        <div class="mt-4" x-data="{}"
             x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <div class="relative">
                <x-input type="password"
                         class="mt-1 block w-3/4 pr-10"
                         placeholder="{{ __('Password') }}"
                         autocomplete="current-password"
                         x-ref="confirmable_password"
                         wire:model="confirmablePassword"
                         wire:keydown.enter="confirmPassword" />
                
            </div>

            <x-input-error for="confirmable_password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
            {{ __('Annulla') }}
        </x-secondary-button>

        <x-button class="ms-3"
                  dusk="confirm-password-button"
                  wire:click="confirmPassword"
                  wire:loading.attr="disabled">
            {{ $button }}
        </x-button>
    </x-slot>
</x-dialog-modal>
@endonce
