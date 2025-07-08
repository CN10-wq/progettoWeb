@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="description">
            {{ $description }}
        </x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="{{ $submit }}">
            <div class="px-6 py-5 bg-white/5 border border-white/10 text-white backdrop-blur-md shadow-lg {{ isset($actions) ? 'rounded-t-2xl sm:rounded-t-3xl' : 'rounded-2xl sm:rounded-3xl' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-6 py-4 bg-white/5 border border-white/10 text-white backdrop-blur-md shadow-sm rounded-b-2xl sm:rounded-b-3xl">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
