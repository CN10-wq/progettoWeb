<x-authentication-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-4 text-sm text-white/80 leading-relaxed tracking-wide text-center" x-show="! recovery">
                {{ __('Per favore, conferma l’accesso inserendo il codice di autenticazione generato dalla tua app.') }}
            </div>

            <div class="mb-4 text-sm text-white/80 leading-relaxed tracking-wide text-center" x-cloak x-show="recovery">
                {{ __('Oppure inserisci uno dei tuoi codici di recupero di emergenza.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mt-4" x-show="! recovery">
                    <x-label for="code" :value="'Codice'" />
                    <x-input id="code" class="block mt-1 w-full bg-transparent text-white placeholder-white/60 border-white/30 focus:ring-white focus:border-white" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                <div class="mt-4" x-cloak x-show="recovery">
                    <x-label for="recovery_code" :value="'Codice di recupero'" />
                    <x-input id="recovery_code" class="block mt-1 w-full bg-transparent text-white placeholder-white/60 border-white/30 focus:ring-white focus:border-white" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-4 text-sm font-testo">
                    <button type="button"
                            class="text-white/80 hover:text-white underline underline-offset-2 transition"
                            x-show="! recovery"
                            x-on:click="
                                recovery = true;
                                $nextTick(() => { $refs.recovery_code.focus() })
                            ">
                        {{ __('Usa un codice di recupero') }}
                    </button>

                    <button type="button"
                            class="text-white/80 hover:text-white underline underline-offset-2 transition"
                            x-cloak
                            x-show="recovery"
                            x-on:click="
                                recovery = false;
                                $nextTick(() => { $refs.code.focus() })
                            ">
                        {{ __('Usa un codice di autenticazione') }}
                    </button>

                    <x-button class="ms-0 sm:ms-4 w-full sm:w-auto">
                        {{ __('Accedi') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-authentication-layout>
