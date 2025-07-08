{{-- Pagina per registrare un utente, compilando con nome, cognome, email, password e conferma password --}}
<x-authentication-layout>
    <div class="min-h-screen flex items-center justify-center bg-sfondo px-6 sm:px-10 py-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 max-w-full w-full mt-[-40px]">

            <div class="w-full md:w-1/5 flex justify-center items-center">
                <x-authentication-card-logo />
            </div>

            <div class="w-full md:w-4/5 px-8 py-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl shadow-xl">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-label for="name" :value="'Nome'" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="surname" :value="'Cognome'" />
                        <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autocomplete="family-name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="email" :value="'Email'" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" :value="'Password'" />
                        <div class="relative">
                            <x-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" />
                            <x-password input-id="password" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="'Conferma password'" />
                        <div class="relative">
                            <x-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-password input-id="password_confirmation" />
                        </div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />
                                    <div class="ms-2 text-sm text-white/70">
                                        {!! __('Accetto i :terms_of_service e la :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline hover:text-white">'.__('Condizioni di Servizio').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline hover:text-white">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-between mt-6">
                        <a class="underline text-sm text-white/80 hover:text-white" href="{{ route('login') }}">
                            {{ __('Già registrato?') }}
                        </a>

                        <x-button class="px-4 py-2 text-sm">
                            {{ __('Registrati') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-authentication-layout>
