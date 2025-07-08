{{-- 
    Sezione per l'eliminazione dell'account che è disponibile solo nel profilo dell'admin.
    Se vuole procedere con l'eliminazione effettiva comprarirà un modale di conferma che richiede la password dell'admin
--}}
<x-action-section>
    <x-slot name="title">
        {{ __('Elimina account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Elimina definitivamente il tuo account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="w-full text-sm text-white/70">
            {{ __('Una volta eliminato il tuo account, tutte le sue risorse e i dati associati saranno cancellati definitivamente. Prima di procedere, assicurati di scaricare qualsiasi informazione che desideri conservare.') }}
        </div>

        <div class="mt-5">
            <x-danger-button class="text-xs w-full sm:w-auto text-center justify-center" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Elimina account') }}
            </x-danger-button>
        </div>

        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Conferma eliminazione') }}
            </x-slot>

            <x-slot name="content">
                <p class="text-sm text-white/80 leading-relaxed w-full">
                    {{ __('Sei sicuro di voler eliminare il tuo account? Questa operazione è irreversibile e tutti i tuoi dati verranno cancellati. Inserisci la tua password per confermare.') }}
                </p>

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input
                        type="password"
                        class="mt-1 block w-full bg-white/10 border border-white/20 text-white rounded-xl"
                        autocomplete="current-password"
                        placeholder="{{ __('Password') }}"
                        x-ref="password"
                        wire:model="password"
                        wire:keydown.enter="deleteUser"
                    />
                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-col sm:flex-row sm:justify-end gap-2 w-full">
                    <x-secondary-button class="w-full sm:w-auto justify-center text-sm" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                        {{ __('Annulla') }}
                    </x-secondary-button>

                    <x-danger-button class="w-full sm:w-auto justify-center text-sm" wire:click="deleteUser" wire:loading.attr="disabled">
                        {{ __('Conferma eliminazione') }}
                    </x-danger-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
