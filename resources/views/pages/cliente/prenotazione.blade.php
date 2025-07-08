{{-- 
    Pagina di riepilogo prenotazione: mostra i dettagli della camera selezionata e del soggiorno e permette l'aggiunta opzionale di servizi-extra con quantità.
     Calcola dinamicamente il totale complessivo (camera+eventuali servizi).
--}}
<x-app-layout :title="'Riepilogo Prenotazione'">
    <div id="datiPrenotazione"
         data-prezzo-camera="{{ $totale }}"
         data-servizi-extra='@json($prezziServiziExtra)'>
    </div>

    <div class="max-w-full mx-auto px-10 py-10 space-y-10 text-white">
        <div class="text-center py-5">
            <a href="{{ route('camere') }}"
               class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white transition px-4 py-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Torna alla lista camere</span>
            </a>
        </div>

        <h1 class="text-3xl md:text-5xl font-bold tracking-wide text-center italic font-cor">
            Riepilogo Prenotazione
        </h1>

        <form method="POST" action="{{ route('prenotazione.successo') }}" class="space-y-10">
            @csrf
            <input type="hidden" name="camera_id" value="{{ $camera->id }}">
            <input type="hidden" name="data_inizio" value="{{ $data_inizio }}">
            <input type="hidden" name="data_fine" value="{{ $data_fine }}">

            <div class="flex flex-col md:flex-row gap-6 items-center bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-6">
                <div class="w-full md:w-1/3">
                    <div id="galleria-camera-{{ $camera->id }}"
                        class="relative rounded-xl overflow-hidden border border-white/10 shadow"
                        data-immagini='@json($camera->immagini)'>
                    </div>
                </div>

                <div class="flex-1 space-y-2 text-center md:text-left">
                    <h2 class="text-2xl font-bold">{{ $camera->titolo }}</h2>
                    <p class="text-white/70 uppercase tracking-wide text-sm">{{ $camera->tipo->nome }}</p>
                    <p class="text-sm text-white/60">Soggiorno di <strong>{{ $notti }}</strong> nott{{ $notti > 1 ? 'i' : 'e' }}</p>
                    <p class="text-lg font-bold text-white mt-1">Totale camera: €{{ number_format($totale, 2) }}</p>
                    <input type="hidden" name="prezzo_totale_camera" value="{{ $totale }}">
                </div>
            </div>

            <div class="w-full bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-4 mt-8">
                <label for="numero_persone" class="block text-white/90 text-sm font-semibold mb-2 text-center tracking-wide uppercase">
                    Numero di persone
                </label>
                <input type="number"
                       id="numero_persone"
                       name="numero_persone"
                       min="1"
                       max="{{ $camera->capienza }}"
                       value="1"
                       required
                       class="w-full text-center rounded-md bg-white/10 text-white placeholder-white/50 px-4 py-2 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white transition duration-300" />
                <p class="text-xs text-white/60 text-center mt-1 italic">
                    Massimo {{ $camera->capienza }} ospit{{ $camera->capienza > 1 ? 'i' : 'e' }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 text-sm bg-white/5 p-6 rounded-xl border border-white/10 backdrop-blur-md">
                <div>
                    <p class="uppercase text-xs text-white/50 mb-1">Check-in</p>
                    <p class="text-base font-semibold">{{ \Carbon\Carbon::parse($data_inizio)->translatedFormat('d F Y') }} dalle 15:00</p>
                </div>
                <div>
                    <p class="uppercase text-xs text-white/50 mb-1">Check-out</p>
                    <p class="text-base font-semibold">{{ \Carbon\Carbon::parse($data_fine)->translatedFormat('d F Y') }} entro le 11:00</p>
                </div>
            </div>

            <div class="bg-white/5 p-6 rounded-xl border border-white/10 backdrop-blur-md">
                <x-label for="richieste" :value="'Richieste particolari (facoltative)'" />
                <textarea name="richieste" id="richieste" rows="3"
                          class="mt-2 w-full bg-transparent text-sm border border-white/20 rounded-lg p-3 focus:outline-none focus:ring focus:border-white/40 placeholder-white/30"
                          placeholder="Es. letto aggiuntivo, vista preferita, allergie..."></textarea>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <x-checkbox id="toggleServiziExtra" class="cursor-pointer" />
                    <label for="toggleServiziExtra" id="labelServiziToggle" class="text-sm text-white/80 select-none">
                        Visualizza e aggiungi servizi extra
                    </label>
                </div>
            </div>

            <div id="sezioneServiziExtra" class="hidden transition-all duration-300 space-y-4">
                <div id="resetServiziWrapper" class="hidden justify-end text-right">
                    <button type="button"
                            onclick="resetServiziExtra()"
                            class="text-xs text-white/60 hover:text-white hover:underline transition duration-200">
                        Rimuovi tutti i servizi selezionati
                    </button>
                </div>

                @foreach ($servizi_extra as $servizio)
                    <div class="block bg-white/5 border border-white/10 rounded-lg p-4 backdrop-blur-md hover:bg-white/10 transition-all">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-base">{{ $servizio->nome }}</p>
                                <p class="text-sm text-white/60 italic">{{ $servizio->descrizione }}</p>
                            </div>
                            <div class="text-right text-sm text-white/70">
                                €{{ number_format($servizio->prezzo, 2) }}
                                <br><span class="text-xs">/ {{ $servizio->prezzo_unita }}</span>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-col md:flex-row md:items-center md:gap-6">
                            <div class="flex items-center gap-2">
                                <x-checkbox
                                    id="servizio_{{ $servizio->id }}"
                                    name="servizi_extra[{{ $servizio->id }}][attivo]"
                                    value="1"
                                    onchange="toggleQuantita({{ $servizio->id }})"
                                />
                                <label for="servizio_{{ $servizio->id }}" class="text-sm text-white/70 cursor-pointer">
                                    Aggiungi servizio
                                </label>
                            </div>

                            <div id="quantita_wrapper_{{ $servizio->id }}" class="mt-3 md:mt-0 hidden">
                                <label for="quantita_{{ $servizio->id }}" class="text-white/60 text-xs block mb-1">
                                    Quantità
                                </label>
                                <input type="number"
                                       name="servizi_extra[{{ $servizio->id }}][quantita]"
                                       id="quantita_{{ $servizio->id }}"
                                       min="1"
                                       max="{{ $servizio->nome === 'Colazione in Camera' ? $notti : $notti + 1 }}"
                                       value="1"
                                       class="w-24 bg-white/10 text-white text-sm p-2 rounded border border-white/20"
                                       onchange="aggiornaTotaleComplessivo()"
                                       oninput="aggiornaTotale({{ $servizio->id }}, {{ $servizio->prezzo }})" />
                                <input type="hidden"
                                       name="servizi_extra[{{ $servizio->id }}][prezzo_unitario]"
                                       value="{{ $servizio->prezzo }}">

                                <p id="totale_servizio_{{ $servizio->id }}" class="text-white/70 text-sm mt-2 hidden text-right">
                                    Totale: €<span>0.00</span>
                                </p>
                                <p class="text-xs text-white/50 italic mt-1">
                                    Deseleziona per annullare l’aggiunta del servizio
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p id="totale_complessivo" class="text-xl font-bold text-white text-center mt-6">
                Totale complessivo: €{{ number_format($totale, 2) }}
            </p>

            <div class="flex justify-center gap-4 mt-8">
                <a href="{{ route('camere') }}"
                   class="px-8 py-3 text-sm font-bold tracking-wide uppercase rounded-full border border-white/20 text-white backdrop-blur-md bg-white/5 hover:bg-white/10 transition">
                    Annulla
                </a>

                <x-button type="submit" class="px-8 py-3 text-sm font-bold tracking-wide uppercase">
                    Salva Prenotazione
                </x-button>
            </div>
        </form>

        <br><br>
    </div>
</x-app-layout>
