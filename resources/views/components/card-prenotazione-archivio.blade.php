{{-- Componente che mostra una singola prenotazione nell’archivio utente con i diversi dettagli annessi --}}
@props(['prenotazione'])

<div class="relative bg-white/5 p-6 rounded-2xl border border-white/10 backdrop-blur-md shadow-md">
    <div class="absolute top-4 right-4 hidden md:block">
        <span class="px-3 py-1 text-xs font-semibold rounded-full border border-white/20 bg-white/10 text-white/80 backdrop-blur-md">
            {{ $prenotazione->stato->nome }}
        </span>
    </div>

    <div class="flex flex-col sm:flex-row gap-6">
        <div class="w-full sm:w-72 flex-shrink-0 mx-auto sm:mx-0">
            <div id="galleria-camera-{{ $prenotazione->camera->id }}"
                class="relative aspect-square rounded-xl overflow-hidden border border-white/10 shadow"
                data-immagini='@json(
                    $prenotazione->camera->immagini->map(fn($img) => ['path' => "/storage/immagini/{$img->path}"])
                )'>
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
                    {{ $prenotazione->numero_persone === 1 ? 'persona' : 'persone' }}
                </p>

                <p class="text-sm text-white/60 mt-1">
                    Richieste: <span class="italic">{{ $prenotazione->eventuali_richieste_cliente ?? 'Nessuna' }}</span>
                </p>

                <p class="text-sm text-white/60 mt-1">
                    <span class="italic">
                        Totale camera per {{ $prenotazione->notti }} {{ $prenotazione->notti === 1 ? 'notte' : 'notti' }}:
                    </span>
                    €{{ number_format($prenotazione->prezzo_totale_camera, 2, ',', '.') }}
                </p>

                @if($prenotazione->serviziExtra->isNotEmpty())
                    <div class="mt-3">
                        <p class="text-sm text-white/80 font-medium">Servizi extra:</p>
                        <ul class="list-disc ml-6 text-sm text-white/70">
                            @foreach ($prenotazione->serviziExtra as $se)
                                <li>
                                    {{ $se->nome }} × {{ $se->pivot->quantita }}
                                    (€{{ number_format($se->pivot->prezzo_unitario, 2, ',', '.') }} al {{ $se->prezzo_unita }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="block md:hidden mt-4">
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full border border-white/20 bg-white/10 text-white/80 backdrop-blur-md">
                    {{ $prenotazione->stato->nome }}
                </span>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 pt-4 border-t border-white/10">
                <p class="text-lg font-semibold text-white">
                    Totale: €{{ number_format($prenotazione->totale_spesa, 2, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</div>
