{{-- Pagina per il recupero password tramite link di reset via mail --}}
<x-authentication-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-white/80 tracking-wide leading-relaxed text-center">
            {{ __('Hai dimenticato la password? Nessun problema. Inserisci la tua email e ti invieremo un link per crearne una nuova.') }}
        </div>

        @session('status')
            <div class="mb-4 px-4 py-2 bg-green-500/10 border border-green-400/20 text-green-300 rounded-xl backdrop-blur-md shadow">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex justify-end mt-6">
                <x-button class="px-4 py-2 text-xs sm:text-sm w-full sm:w-auto text-center">
                    {{ __('Invia link per reimpostare la password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-authentication-layout>
