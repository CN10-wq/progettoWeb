{{-- 
    Dashboard dell'admin in cui vede il numero di prenotazione di oggi, 
    il numero di camere disponibili oggi e il numero totale dei clienti registrati: cliccando sopra
    potrà accedere direttamente alle pagine dedicate.
--}}
<x-app-layout :title="'Dashboard Admin'">
    <div class="max-w-full mx-auto py-12 px-10 text-white space-y-10">
        <br>
        <div class="text-center space-y-3">
            <h1 class="text-4xl font-bold italic mb-2">
                Benvenuto, {{ Auth::user()->name }}!
            </h1>
            <p class="text-white/70 text-sm max-w-xl mx-auto">
                Controlla e gestisci le attività del sito Back To Beauty Hotel. Questa area è riservata agli amministratori.
            </p>
            <p class="text-sm italic text-white/60 mt-2" id="orologioNY">
                {{ \Carbon\Carbon::now('America/New_York')->translatedFormat('l d F Y • H:i:s') }} — New York
            </p>
        </div>

        <div class="max-w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">

            <a href="{{ route('admin.prenotazioni') }}#oggi"
                class="bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-6 shadow-md hover:bg-white/10 transition cursor-pointer block">
                <h3 class="text-sm uppercase tracking-wider text-white/70 mb-2">
                    Prenotazioni oggi
                </h3>
                <p class="text-3xl font-bold italic">
                    {{ $prenotazioniOggi }}
                </p>
            </a>

            <a href="{{ route('admin.camere') }}#disponibili"
                class="bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-6 shadow-md hover:bg-white/10 transition cursor-pointer block">
                <h3 class="text-sm uppercase tracking-wider text-white/70 mb-2">
                    Camere disponibili
                </h3>
                <p class="text-3xl font-bold italic">
                    {{ $camereDisponibili }}
                </p>
            </a>

            <a href="{{ route('admin.eliminaAccount') }}"
                class="bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-6 shadow-md hover:bg-white/10 transition cursor-pointer block">
                <h3 class="text-sm uppercase tracking-wider text-white/70 mb-2">
                    Utenti registrati
                </h3>
                <p class="text-3xl font-bold italic">
                    {{ $clientiRegistrati }}
                </p>
            </a>

        </div>
    </div>
</x-app-layout>
