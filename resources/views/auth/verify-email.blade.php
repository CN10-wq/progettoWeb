<x-authentication-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-white/80 leading-relaxed tracking-wide text-center">
            Prima di continuare, verifica il tuo indirizzo email cliccando sul link che ti abbiamo appena inviato. <br class="hidden sm:inline"> Se non hai ricevuto l’email, saremo felici di inviarne un’altra.
        </div>


        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 px-4 py-2 bg-green-500/10 border border-green-400/20 text-green-300 rounded-xl backdrop-blur-md shadow">
                {{ __('Un nuovo link di verifica è stato inviato all’indirizzo email che hai indicato nelle impostazioni del profilo.') }}
            </div>
        @endif


        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button type="submit">
                        {{ __('Invia nuovamente l’email di verifica') }}
                    </x-button>
                </div>
            </form>

            <div class="mt-6 flex items-center justify-between text-sm font-testo">
                <a href="{{ route('profile.show') }}" class="text-white/80 hover:text-white transition underline underline-offset-2">
                    {{ __('Modifica profilo') }}
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                     @csrf
                    <button type="submit" class="text-white/80 hover:text-white transition underline underline-offset-2 ms-4">
                        {{ __('Log out') }}
                    </button>
                </form>
            </div>

        </div>
    </x-authentication-card>
</x-authentication-layout>
