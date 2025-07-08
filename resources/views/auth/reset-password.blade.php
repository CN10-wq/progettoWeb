{{-- Pagina per reimpostare la password tramite link ricevuto via mail --}}
<x-authentication-layout>
    <x-authentication-card class="rounded-2xl">
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-white/80 tracking-wide leading-relaxed text-center">
            {{ __('Inserisci la tua email, la nuova password e confermala per reimpostare l\'accesso al tuo account.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input
                    id="email"
                    class="block mt-1 w-full text-white border border-white/20 rounded-2xl px-4 py-2"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>

            <div>
                <x-label for="password" :value="__('Password')" />
                <div class="relative">
                    <x-input
                        id="password"
                        class="mt-1 block w-full pr-10 text-white border border-white/20 rounded-2xl px-4 py-2"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                    />
                    <x-password input-id="password" />
                </div>
            </div>

            <div>
                <x-label for="password_confirmation" :value="__('Conferma Password')" />
                <div class="relative">
                    <x-input
                        id="password_confirmation"
                        class="mt-1 block w-full pr-10 text-white border border-white/20 rounded-2xl px-4 py-2"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <x-password input-id="password_confirmation" />
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <x-button class="px-5 py-2 text-sm rounded-2xl bg-white/10 hover:bg-white/20 border border-white transition text-white">
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-authentication-layout>
