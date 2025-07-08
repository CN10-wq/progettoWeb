{{-- 
    Pagina del profilo per utenti autenticati: user e admin.
    Include: modifica delle informazioni utente(nome, cognome, email, foto), modifica password, 
    disconnessione da altre sessioni browser (solo per admin) ed eliminazione account (solo per admin, gli user se vogliono eliminare
    il proprio account devono mandare una mail di richiesta all'hotel)
--}}

<x-authentication-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-0">
        <div class="max-w-full mx-auto py-10 space-y-10 sm:space-y-0 sm:px-6 lg:px-8">

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="overflow-x-auto">
                    @livewire('profile.update-profile-information-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0 overflow-x-auto">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if(Auth::user()->hasRole('admin'))
                <div class="mt-10 sm:mt-0 overflow-x-auto">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>
            @endif

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures() && Auth::user()->hasRole('admin'))
                <x-section-border />

                <div class="mt-10 sm:mt-0 overflow-x-auto">
                    @livewire('profile.delete-user-form')
                </div>
            @else
                <div class="mt-10 sm:mt-0">
                    <div class="text-sm text-white/70 bg-white/5 border border-white/10 rounded-xl p-4 backdrop-blur-md shadow text-center">
                        Vuoi eliminare il tuo account? Contattaci a 
                        <a href="mailto:back.to.beauty.hotel@gmail.com" class="underline hover:text-white break-all">back.to.beauty.hotel@gmail.com</a> 
                        per procedere.
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-authentication-layout>
