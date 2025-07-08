{{-- 
    Sezione per l'aggiornamento delle informazioni del profilo utente: nome, cognome, email e foto profilo. 
    Gestisce anche l’anteprima della nuova immagine profilo prima del salvataggio e offre la possibilità di rimuovere quella attuale.
--}}  
<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        <h2 class="text-xl font-bold tracking-wide text-white uppercase font-tit">Profilo</h2>
    </x-slot>

    <x-slot name="description">
        <p class="text-sm text-white/70 leading-relaxed">
            Aggiorna le informazioni del tuo profilo e l’indirizzo email associato al tuo account.
        </p>
    </x-slot>

    <x-slot name="form">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <x-label for="photo" value="Foto profilo" />

                <input type="file" id="photo" class="hidden"
                    wire:model.live="photo"
                    x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    " />

                <div class="mt-4" x-show="!photoPreview">
                    @if ($this->user->profile_photo_path !== null)
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                            class="rounded-full size-20 object-cover border border-white/20 shadow" />
                    @else
                        <div class="size-20 rounded-full bg-white/80 text-sfondo font-corsivo flex items-center justify-center font-semibold text-3xl shadow">
                            {{ strtoupper(substr($this->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="mt-4" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center shadow"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="mt-4 flex gap-3">
                    <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                        Seleziona una nuova foto
                    </x-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-secondary-button type="button" wire:click="deleteProfilePhoto">
                            Rimuovi foto
                        </x-secondary-button>
                    @endif
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" :value="'Nome'" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="given-name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="surname" :value="'Cognome'" />
            <x-input id="surname" type="text" class="mt-1 block w-full" wire:model="state.surname" autocomplete="family-name" />
            <x-input-error for="surname" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" :value="'Email'" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="email" />
            <x-input-error for="email" class="mt-2" />

            {{--
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-white/80">
                    Il tuo indirizzo email non è verificato.

                    <button type="button" class="underline hover:text-white ml-2 transition"
                        wire:click.prevent="sendEmailVerification">
                        Clicca qui per inviare di nuovo l’email di verifica.
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-400">
                        È stato inviato un nuovo link di verifica al tuo indirizzo email.
                    </p>
                @endif
            @endif
            --}}
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3 text-white/70" on="saved">
            {{ __(key: 'Salvato!') }}
        </x-action-message>

        <div class="flex gap-3">
            <x-secondary-button type="button" x-on:click.prevent="window.location.reload()">
                {{ __(key: 'Annulla') }}
            </x-secondary-button>

            <x-button wire:loading.attr="disabled" wire:target="photo">
                {{ __(key: 'Salva') }}
            </x-button>
        </div>
    </x-slot>
</x-form-section>
