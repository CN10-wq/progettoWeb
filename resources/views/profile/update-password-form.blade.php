{{-- 
    Sezione per la modifica della password dell'utente autenticato che comprende: password attuale, nuova password e conferma della nuova password
--}}
<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Modifica password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Assicurati di usare una password lunga e sicura per proteggere il tuo account.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Password attuale') }}" />
            <div class="relative">
                <x-input 
                    id="current_password" 
                    type="password" 
                    class="mt-1 block w-full" 
                    wire:model="state.current_password" 
                    autocomplete="current-password" 
                />
                <x-password input-id="current_password" />
            </div>                
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('Nuova Password') }}" />
            <div class="relative">
                <x-input 
                    id="password" 
                    type="password" 
                    class="mt-1 block w-full" 
                    wire:model="state.password" 
                    autocomplete="new-password" 
                />
                <x-password input-id="password" />
            </div>   
            <x-input-error for="password" class="mt-2" /> 
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Conferma nuova Password') }}" />
            <div class="relative">
                <x-input 
                    id="password_confirmation" 
                    type="password" 
                    class="mt-1 block w-full" 
                    wire:model="state.password_confirmation" 
                    autocomplete="new-password" 
                />
                <x-password input-id="password_confirmation" />
            </div> 
            <x-input-error for="password_confirmation" class="mt-2" />   
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __(key: 'Salvato!') }}
        </x-action-message>

        <div class="flex gap-3">
            <x-secondary-button 
                type="button" 
                x-on:click.prevent="window.location.reload()"
            >
                {{ __(key: 'Annulla') }}
            </x-secondary-button>

            <x-button 
                wire:loading.attr="disabled" 
                wire:target="photo"
            >
                {{ __(key: 'Salva') }}
            </x-button>
        </div>
    </x-slot>
</x-form-section>
