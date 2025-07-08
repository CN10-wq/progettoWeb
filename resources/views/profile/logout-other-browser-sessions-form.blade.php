{{-- 
    Sezione di gestione delle sessioni browser attive che è disponibile solo per l'admin:
    consente la disconnessione da tutte le altre sessioni tramite un modale di conferma che richiede la password
--}}

<x-action-section>
    <x-slot name="title">
        {{ __('Sessioni Browser') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Gestisci e disconnetti le sessioni attive su altri dispositivi.') }}
    </x-slot>

    <x-slot name="content">
        <div class="w-full text-sm text-white/70 leading-relaxed">
            {{ __('Se necessario, puoi disconnettere tutte le altre sessioni del tuo account da altri browser e dispositivi. Alcune sessioni recenti sono elencate qui sotto. Se sospetti un accesso non autorizzato, ti consigliamo anche di aggiornare la tua password.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-6">
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <svg class="size-8 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25" />
                                </svg>
                            @else
                                <svg class="size-8 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <div class="ms-3 overflow-hidden">
                            <div class="text-sm text-white font-medium truncate">
                                {{ $session->agent->platform() ?? 'Sconosciuto' }} - {{ $session->agent->browser() ?? 'Sconosciuto' }}
                            </div>

                            <div class="text-xs text-white/60 truncate">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-green-400 font-semibold">{{ __('Questo dispositivo') }}</span>
                                @else
                                    {{ __('Ultima attività') }}: {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center mt-5 gap-3 w-full">
            <x-button class="text-sm w-full sm:w-auto justify-center" wire:click="confirmLogout" wire:loading.attr="disabled">
                {{ __('Disconnetti tutte le altre sessioni') }}
            </x-button>

            <x-action-message class="text-sm text-white/70" on="loggedOut">
                {{ __('Fatto.') }}
            </x-action-message>
        </div>

        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                {{ __('Conferma disconnessione') }}
            </x-slot>

            <x-slot name="content">
                <p class="text-sm text-white/80 leading-relaxed">
                    {{ __('Per confermare la disconnessione da tutti gli altri dispositivi, inserisci la tua password.') }}
                </p>

                <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input
                        type="password"
                        class="mt-1 block w-full bg-white/10 border border-white/20 text-white rounded-xl"
                        placeholder="Password"
                        x-ref="password"
                        wire:model="password"
                        wire:keydown.enter="logoutOtherBrowserSessions"
                    />
                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-col sm:flex-row sm:justify-end gap-2 w-full">
                    <x-secondary-button class="text-sm w-full sm:w-auto justify-center" wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                        {{ __('Annulla') }}
                    </x-secondary-button>

                    <x-button class="text-sm w-full sm:w-auto justify-center" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
                        {{ __('Conferma disconnessione') }}
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
