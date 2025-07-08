{{--
    Pagina di gestione prenotazioni da parte dell'admin, con possibilità di:
    visualizzare le prenotazioni in attesa (da confermare o annullare), visualizzare
    le prenotazioni previste per oggi e visualizzare l'intero archivio delle prenotazioni (effettuate, confermate, in attesa di conferma e annullate).
    La pagina è inizialmente vuota: l'admin deve selezionare una delle 3 opzioni tramite i button.
    Ogni button richiama la funzione JavaScript selezionaTipoPrenotazione(tipo),
    che aggiorna dinamicamente i contenuti tramite fetch (chiamate ajax), senza ricaricare l'intera pagina.
    Se si seleziona "Archivio", viene mostrato anche un filtro per stato della prenotazione.
--}}
<x-app-layout :title="'Gestione Prenotazioni'">
    <div class="max-w-full mx-auto py-12 px-10 text-white space-y-8">
        <br>

        <h1 class="text-3xl font-bold italic text-center">Gestione Prenotazioni</h1>

        <div class="flex gap-4 justify-center">
            <button id="btn-attesa" onclick="selezionaTipoPrenotazione('attesa')" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded">
                Attesa
            </button>
            <button id="btn-oggi" onclick="selezionaTipoPrenotazione('oggi')" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded">
                Oggi
            </button>
            <button id="btn-archivio" onclick="selezionaTipoPrenotazione('archivio')" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded">
                Archivio
            </button>
        </div>

        <div id="messaggioSuccesso" class="max-w-4xl mx-auto hidden"></div>

        <div id="filtroArchivio" class="mt-6 hidden">
            <div class="flex flex-wrap justify-center gap-3 sm:gap-4 md:gap-6">
                <button onclick="filtraStatoArchivio('tutte')" id="filtro-tutte"
                    class="text-white/60 hover:text-white text-sm sm:text-base font-semibold border-b-2 border-transparent hover:border-white transition">
                    Tutte
                </button>
                <button onclick="filtraStatoArchivio('1')" id="filtro-1"
                    class="text-white/60 hover:text-white text-sm sm:text-base font-semibold border-b-2 border-transparent hover:border-white transition">
                    Annullate
                </button>
                <button onclick="filtraStatoArchivio('2')" id="filtro-2"
                    class="text-white/60 hover:text-white text-sm sm:text-base font-semibold border-b-2 border-transparent hover:border-white transition">
                    Confermate
                </button>
                <button onclick="filtraStatoArchivio('3')" id="filtro-3"
                    class="text-white/60 hover:text-white text-sm sm:text-base font-semibold border-b-2 border-transparent hover:border-white transition">
                    In attesa
                </button>
                <button onclick="filtraStatoArchivio('4')" id="filtro-4"
                    class="text-white/60 hover:text-white text-sm sm:text-base font-semibold border-b-2 border-transparent hover:border-white transition">
                    Effettuate
                </button>
            </div>
        </div>

        <div id="contenitorePrenotazioni" class="space-y-4 mt-6 px-5"></div>
    </div>
</x-app-layout>
