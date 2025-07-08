{{--
    Pagina di gestione camere da parte dell'admin, con permessi di: 
    visualizzare le camere attive (con possibilità di eliminarle o modificarle), visualizzare le camere eliminate (con possibilità di ripristinarle),
    visualizzare le camere disponibili per oggi ed infine aggiungere una nuova camera.
    All'inizio la pagina è vuota e l'admin deve selezionare una delle 4 opzioni tramite i diversi button. 
    Ciascun di essi richiama la funzione JavaScript selezionaTipoCamera(tipo), 
    che aggiorna dinamicamente i contenuti tramite fetch(chiamate ajax), che permette di aggiornare la pagina senza ricaricarla.
--}}
<x-app-layout :title="'Gestione Camere'">
    <div class="max-w-full mx-auto py-12 px-4 text-white space-y-8">
        <br>
        <h1 class="text-3xl font-bold italic text-center">Gestione Camere</h1>

        <div class="flex flex-wrap gap-4 justify-center">
            <button id="btn-attive"
                    class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded transition"
                    onclick="selezionaTipoCamera('attive')">
                Camere attive
            </button>

            <button id="btn-eliminate"
                    class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded transition"
                    onclick="selezionaTipoCamera('eliminate')">
                Camere eliminate
            </button>

            <button id="btn-disponibili"
                    class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded transition"
                    onclick="selezionaTipoCamera('disponibili')">
                Camere disponibili oggi
            </button>

            <button id="btn-nuova"
                    class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded transition"
                    onclick="selezionaTipoCamera('nuova')">
                Aggiungi camera
            </button>
        </div>

        <div id="messaggioSuccessoCamera" class="max-w-4xl mx-auto hidden"></div>

        <div id="contenuto-camere" class="mt-8 space-y-6"></div>
    </div>
</x-app-layout>

{{-- Modale di conferma per il ripristino di una camera eliminata --}}
<x-modale-personalizzato id="modaleConfermaRipristino" maxWidth="md">
    <h2 class="text-lg font-semibold mb-4">Conferma ripristino</h2>

    <p class="text-sm text-white/70 mb-6" id="testoConfermaRipristino">
        Sei sicuro di voler ripristinare questa camera?
    </p>

    <div class="flex justify-end gap-3">
        <button type="button"
                onclick="chiudiModale('modaleConfermaRipristino')"
                class="text-xs text-white/60 hover:text-white tracking-wide uppercase">
            Annulla
        </button>

        <button type="button"
                onclick="confermaRipristinoCamera()"
                class="px-4 py-1 rounded-xl text-sm text-white bg-white/10 hover:bg-white/20 border border-white/20 transition backdrop-blur-md">
            Ripristina
        </button>
    </div>
</x-modale-personalizzato>

{{-- Modale di conferma per l'eliminazione (soft delete) di una camera --}}
<x-modale-personalizzato id="modaleConfermaEliminazione" maxWidth="md">
    <h2 class="text-lg font-semibold mb-4">Conferma eliminazione</h2>

    <p class="text-sm text-white/70 mb-6">
        Sei sicuro di voler eliminare questa camera? Potrai comunque ripristinarla in seguito.
    </p>

    <div class="flex justify-end gap-3">
        <button type="button"
                onclick="chiudiModale('modaleConfermaEliminazione')"
                class="text-xs text-white/60 hover:text-white tracking-wide uppercase">
            Annulla
        </button>

        <button type="button"
                onclick="confermaEliminazioneCamera()"
                class="px-4 py-1 rounded-xl text-sm text-white bg-white/10 hover:bg-white/20 border border-white/20 transition backdrop-blur-md">
            Elimina
        </button>
    </div>
</x-modale-personalizzato>
