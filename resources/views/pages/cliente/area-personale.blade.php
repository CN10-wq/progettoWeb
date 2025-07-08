{{-- 
    Pagina dell'area personale con le varie prenotazioni accessibile al solo user.
    All'inizio mostra tutte le prenotazioni attive (in attesa di conferma e confermate) dell'utente con i vari dettagli e
    consente di eliminare le prenotazioni fino a 24 ore prima, con modale di conferma.
    C'è anche la possibilità di visualizzare un archivio di tutte le prenotazioni in qualsiasi stato e di filtrarle in base ad esso tramite Javascript (chiamata AJAX).
--}}
<x-app-layout :title="'Le mie prenotazioni'">
    <div class="max-w-full mx-auto px-4 py-10 text-white space-y-8">
        <div class="max-w-full mx-auto px-4 py-10 space-y-10 text-white">

            <div class="text-center">
                <a href="javascript:history.back()"
                   class="inline-flex items-center justify-center text-sm text-white/80 hover:text-white transition px-4 py-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Torna indietro
                </a>
            </div>

            <h1 class="text-3xl font-bold text-center italic">Le mie prenotazioni</h1>

            <div id="areaControlliArchivio" class="mt-6 px-4 flex flex-col sm:flex-row sm:justify-center sm:items-center gap-4">
                <button id="visualizzaArchivio"
                        class="px-6 py-3 text-sm font-semibold bg-white/10 text-white border border-white/20 rounded-full hover:bg-white/20">
                    Visualizza tutto l'archivio
                </button>

                <div id="contenitoreFiltro" class="hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <label for="filtroStato" class="text-sm text-white/70 italic">Filtra per stato:</label>
                        <select id="filtroStato"
                                class="px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-sm shadow hover:bg-white/20">
                            <option value="tutte">Tutte</option>
                            <option value="1">Annullata</option>
                            <option value="2">Confermata</option>
                            <option value="3">In attesa di conferma</option>
                            <option value="4">Effettuata</option>
                        </select>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 3000)"
                     x-show="show"
                     x-transition.duration.500ms
                     class="max-w-4xl mx-auto bg-white/10 text-white/80 border border-white/30 rounded-xl px-4 py-3 backdrop-blur-md shadow-md text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div id="prenotazioniAttive">
                @forelse ($prenotazioni as $prenotazione)

                    <div class="bg-white/5 p-6 rounded-2xl border border-white/10 backdrop-blur-md shadow-md">
                        <div class="flex flex-col sm:flex-row gap-6">

                            <div class="w-full sm:w-72 flex-shrink-0 mx-auto sm:mx-0">
                                <div id="galleria-camera-{{ $prenotazione->camera->id }}"
                                     class="relative aspect-square rounded-xl overflow-hidden border border-white/10 shadow"
                                     data-immagini='@json($prenotazione->camera->immagini)'>
                                </div>
                            </div>

                            <div class="flex-1 flex flex-col justify-between space-y-4">
                                <div>
                                    <h2 class="text-2xl font-semibold">{{ $prenotazione->camera->titolo }}</h2>

                                    <p class="text-sm text-white/60 italic mt-1">
                                        Dal {{ \Carbon\Carbon::parse($prenotazione->data_inizio)->translatedFormat('d F Y') }}
                                        al {{ \Carbon\Carbon::parse($prenotazione->data_fine)->translatedFormat('d F Y') }}
                                    </p>

                                    <p class="text-sm text-white/60 mt-1">
                                        Ospiti: <span class="italic">{{ $prenotazione->numero_persone }}</span>
                                        {{ $prenotazione->numero_persone == 1 ? 'persona' : 'persone' }}
                                    </p>

                                    <p class="text-sm text-white/60 mt-1">
                                        Richieste: <span class="italic">{{ $prenotazione->eventuali_richieste_cliente ?? 'Nessuna' }}</span>
                                    </p>

                                    <p class="text-sm text-white/70 mt-3">
                                        <span class="font-medium text-white">Stato:</span> {{ $prenotazione->stato->nome }}
                                    </p>

                                    <p class="text-sm text-white/70 mt-3">
                                        <span class="font-medium">Totale camera per {{ $prenotazione->notti }} {{ $prenotazione->notti == 1 ? 'notte' : 'notti' }}:</span>
                                        €{{ number_format($prenotazione->prezzo_totale_camera, 2, ',', '.') }}
                                    </p>

                                    @if($prenotazione->serviziExtra->isNotEmpty())
                                        <div class="mt-3">
                                            <p class="text-sm text-white/80 font-medium">Servizi extra:</p>
                                            <ul class="list-disc ml-6 text-sm text-white/70">
                                                @foreach ($prenotazione->serviziExtra as $se)
                                                    <li>
                                                        {{ $se->nome }} — {{ $se->pivot->quantita }} × €{{ number_format($se->pivot->prezzo_unitario, 2, ',', '.') }}
                                                        ({{ $se->prezzo_unita }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 pt-4 border-t border-white/10">
                                    <p class="text-lg font-semibold text-white">
                                        Totale: €{{ number_format($prenotazione->totale_spesa, 2, ',', '.') }}
                                    </p>

                                    @if($prenotazione->dataInizio->greaterThan($oggi))
                                        <x-button onclick="apriModale('modaleEliminaPrenotazione_{{ $prenotazione->id }}')" class="text-xs">
                                            Elimina prenotazione
                                        </x-button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <x-modale-personalizzato id="modaleEliminaPrenotazione_{{ $prenotazione->id }}">
                        <h2 class="text-xl font-bold mb-4">Conferma eliminazione</h2>
                        <p class="text-sm text-white/80">Vuoi davvero eliminare questa prenotazione?</p>

                        <div class="mt-6 flex justify-end gap-4">
                            <button onclick="chiudiModale('modaleEliminaPrenotazione_{{ $prenotazione->id }}')"
                                    class="text-sm text-white/60 hover:text-white underline">
                                Annulla
                            </button>

                            <form method="POST" action="{{ route('prenotazione.cancellata', $prenotazione->id) }}">
                                @csrf
                                @method('DELETE')
                                <x-button class="text-xs">Elimina</x-button>
                            </form>
                        </div>
                    </x-modale-personalizzato>
                @empty
                    <p class="text-center text-white/70 italic">Non hai ancora effettuato nessuna prenotazione.</p>
                @endforelse
            </div>

            <div id="contenitoreArchivio" class="mt-8 space-y-6 hidden"></div>
        </div>
    </div>
</x-app-layout>
