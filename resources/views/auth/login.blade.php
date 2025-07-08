{{-- Pagina per il login dell'utente indicando mail e password --}}
<x-authentication-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 px-4 py-2 bg-green-500/10 border border-green-400/20 text-green-300 rounded-xl backdrop-blur-md shadow">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>

            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <div class="relative">
                    <x-input
                        id="password"
                        class="block mt-1 pr-10"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    <x-password input-id="password" />
                </div>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-base text-white/80 font-testo">
                        {{ __('Resta connesso') }}
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4 w-full">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white/80 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Hai dimenticato la password?') }}
                    </a>
                @endif

                <x-button class="px-4 py-2 text-sm">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-authentication-layout>
