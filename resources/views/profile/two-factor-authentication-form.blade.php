<x-action-section>
    <x-slot name="title">
        {{ __('Autenticazione a due fattori') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Aggiungi un ulteriore livello di sicurezza al tuo account.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-semibold text-white">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Completa l’attivazione dell’autenticazione a due fattori.') }}
                @else
                    {{ __('Hai attivato l’autenticazione a due fattori.') }}
                @endif
            @else
                {{ __('Non hai attivato l’autenticazione a due fattori.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-white/70 leading-relaxed">
            <p>
                {{ __('Quando attiva, durante l’accesso ti verrà richiesto un codice di verifica generato dalla tua app di autenticazione.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-white/70">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('Per completare l’attivazione, scansiona il codice QR o inserisci la chiave segreta, poi conferma il codice OTP generato.') }}
                        @else
                            {{ __('Scansiona il seguente codice QR o inserisci la chiave per configurare l’app di autenticazione.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 inline-block bg-white p-4 rounded-xl shadow">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-white/70">
                    <p class="font-semibold">
                        {{ __('Chiave segreta') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4 max-w-sm">
                        <x-label for="code" :value="__('Codice')" />
                        <x-input id="code" type="text" class="mt-1 block w-full" inputmode="numeric"
                                 wire:model="code"
                                 wire:keydown.enter="confirmTwoFactorAuthentication" />
                        <x-input-error for="code" class="mt-2" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-white/70">
                    <p class="font-semibold">
                        {{ __('Salva questi codici in un luogo sicuro: potrai usarli se perdi accesso all’app di autenticazione.') }}
                    </p>
                </div>

                <div class="grid gap-2 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-white/5 text-white border border-white/10 rounded-xl backdrop-blur-md shadow">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-6 flex flex-wrap items-center gap-3">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        {{ __('Attiva') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button>
                            {{ __('Rigenera codici di recupero') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" wire:loading.attr="disabled">
                            {{ __('Conferma') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button>
                            {{ __('Mostra codici di recupero') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button>
                            {{ __('Annulla') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button>
                            {{ __('Disattiva') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </x-slot>
</x-action-section>
