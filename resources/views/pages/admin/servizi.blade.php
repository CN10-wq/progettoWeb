{{--
    Pagina di gestione dei servizi-extra: visualizzazione di tutti i servizi-extra attivi in una tabella,
    possibilità di modificare un servizio esistente tramite form inline dinamico, possibilità di eliminare 
    un servizio tramite modale di conferma e aggiunta di un nuovo servizio extra tramite form inizialmente nascosto.
    La gestione dei form e modali avviene tramite funzioni JavaScript; viene gestita anche la versione responsitive della tabella.
--}}
<x-app-layout :title="'Gestione Servizi Extra'">
    <div class="max-w-full mx-auto py-12 px-10 text-white space-y-8">
         <br>
        <div class="text-center space-y-3">
            <h1 class="text-3xl font-bold italic text-center">Gestione Servizi Extra</h1>
        </div>

        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition.duration.500ms
                class="max-w-4xl mx-auto bg-white/10 text-white/80 border border-white/30 rounded-xl px-4 py-3 backdrop-blur-md shadow-md text-center">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition.duration.500ms
                class="max-w-4xl mx-auto bg-red-600/10 text-red-300 border border-red-400/30 rounded-xl px-4 py-3 backdrop-blur-md shadow-md text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="hidden sm:block w-full px-4">
            <div class="w-full rounded-xl shadow border border-white/10 backdrop-blur-md">
                <table class="w-full table-auto text-sm">
                    <thead class="bg-white/5 text-white/60 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Nome</th>
                            <th class="px-4 py-3 text-center">Prezzo</th>
                            <th class="px-4 py-3 text-center">Unità</th>
                            <th class="px-4 py-3 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="text-white/90">
                        @forelse ($servizi as $servizio)
                            <tr class="border-t border-white/10">
                                <td class="px-4 py-3 break-words">{{ $servizio->nome }}</td>
                                <td class="px-4 py-3 text-center break-words">€ {{ number_format($servizio->prezzo, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center break-words">/ {{ $servizio->prezzo_unita }}</td>
                                <td class="px-4 py-3 text-center space-x-2" id="azione-servizio-{{ $servizio->id }}">
                                    <button onclick="toggleFormModificaServizio(@js($servizio), {{ $servizio->id }})"
                                        class="px-3 py-1 text-xs rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 text-white/70 hover:text-white transition">
                                        Modifica
                                    </button>
                                    <button onclick="apriModaleEliminazione({{ $servizio->id }}, @js($servizio->nome))"
                                        class="px-3 py-1 text-xs rounded-lg bg-red-500/10 hover:bg-red-500/20 border border-red-400/30 text-red-300 hover:text-red-100 transition">
                                        Elimina
                                    </button>
                                </td>
                            </tr>

                            <tr id="formModificaRow-{{ $servizio->id }}" class="hidden border-t border-white/10">
                                <td colspan="4" class="px-4 pb-6 pt-0" id="formContainer-{{ $servizio->id }}">
                                    <x-form-modifica-servizio :servizio="$servizio" :id="$servizio->id" prefix="" />
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-white/10">
                                <td colspan="4" class="px-4 py-6 text-center text-white/50 italic">
                                    Nessun servizio attivo disponibile.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="block sm:hidden space-y-4">
            @forelse ($servizi as $servizio)
                <div class="rounded-2xl border border-white/10 backdrop-blur-md shadow px-4 py-3 space-y-3 text-white text-sm">
                    <div class="space-y-1">
                        <p><span class="text-white/60 font-semibold">Nome:</span> {{ $servizio->nome }}</p>
                        <p><span class="text-white/60 font-semibold">Prezzo:</span> € {{ number_format($servizio->prezzo, 2, ',', '.') }}</p>
                        <p><span class="text-white/60 font-semibold">Unità:</span> / {{ $servizio->prezzo_unita }}</p>
                    </div>

                    <div class="flex justify-end gap-2 pt-1" id="azione-servizio-mobile-{{ $servizio->id }}">
                        <button onclick="toggleFormModificaServizio(@js($servizio), {{ $servizio->id }}, true)"
                            class="px-3 py-1 text-xs rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 text-white/70 hover:text-white transition">
                            Modifica
                        </button>
                        <button onclick="apriModaleEliminazione({{ $servizio->id }}, @js($servizio->nome))"
                            class="px-3 py-1 text-xs rounded-lg bg-red-500/10 hover:bg-red-500/20 border border-red-400/30 text-red-300 hover:text-red-100 transition">
                            Elimina
                        </button>
                    </div>

                    <div id="formModificaRow-mobile-{{ $servizio->id }}" class="hidden pt-2">
                        <div id="formContainer-mobile-{{ $servizio->id }}">
                            <x-form-modifica-servizio :servizio="$servizio" :id="$servizio->id" prefix="mobile-" />
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-white/50 italic text-center">Nessun servizio attivo disponibile.</div>
            @endforelse
        </div>

        <div class="text-right mt-8">
            <button onclick="toggleFormServizio()" id="toggleBtnServizio"
                class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl transition text-sm">
                + Aggiungi Servizio
            </button>
        </div>

        <div id="formNuovoServizio" class="bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-md shadow mt-4 hidden">
            <h2 class="text-xl font-semibold text-white/80 mb-4">Inserisci i dettagli del nuovo servizio:</h2>

            <form method="POST" action="{{ route('servizi-extra.store') }}" id="formAggiungiServizio" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf

                <div class="sm:col-span-2">
                    <label for="nome" class="block text-sm text-white/70 mb-1">Nome servizio<span class="text-white/70">*</span></label>
                    <input type="text" name="nome" id="nome" required
                        class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2" />
                </div>

                <div>
                    <label for="prezzo" class="block text-sm text-white/70 mb-1">Prezzo (€)<span class="text-white/70">*</span></label>
                    <input type="number" name="prezzo" id="prezzo" step="0.01" required
                        class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2" />
                </div>

                <div>
                    <label for="prezzo_unita" class="block text-sm text-white/70 mb-1">Unità di prezzo<span class="text-white/70">*</span></label>
                    <input type="text" name="prezzo_unita" id="prezzo_unita" placeholder="es. a notte, a giorno" required
                        class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2" />
                </div>

                <div class="sm:col-span-2">
                    <label for="descrizione" class="block text-sm text-white/70 mb-1">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="3"
                        class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2"></textarea>
                </div>

                <div class="sm:col-span-2 text-right">
                    <x-button class="text-xs px-4 py-1">Aggiungi</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

{{-- Modale per confermare l’eliminazione di un servizio-extra --}}
<x-modale-personalizzato id="modaleEliminaServizio" titolo="Conferma eliminazione">
    <form id="formEliminaServizio" method="POST" action="">
        @csrf
        @method('DELETE')

        <p class="text-sm text-white/70 mb-4" id="testoEliminaServizio">
            Sei sicuro di voler eliminare questo servizio?
        </p>

        <div class="flex flex-col gap-3">
            <x-button class="bg-white/10 hover:bg-white/20 border border-white/30 text-white justify-center text-sm px-4 py-1">
                Elimina definitivamente
            </x-button>

            <button type="button" onclick="chiudiModale('modaleEliminaServizio')"
                class="text-xs text-white/60 hover:text-white tracking-wide uppercase">
                Annulla
            </button>
        </div>
    </form>
</x-modale-personalizzato>
