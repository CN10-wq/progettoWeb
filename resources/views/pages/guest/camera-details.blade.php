{{-- 
    Pagina di dettaglio di una singola camera: mostra le informazioni della stessa, con un layout per immagini tutte poste in diagonale (versione responsitive semplificata),
    sotto c'è una sezione per controllare la disponibilità della camera (che oscura già le date occupate, così che non possano essere scelte). Amche per questa parte c'è una versione
    semplificata responsitive.
--}}
<x-guest-layout>
    <div id="prenotazioni-data" class="hidden" data-json='@json($prenotazioni)'></div>

    <br>
    <div class="mt-12 flex justify-start px-10">
        <a href="{{ route('camere') }}"
           class="text-white/70 hover:text-white/90 text-xs tracking-wide italic transition duration-300">
            ← Torna alle camere
        </a>
    </div>

    <div id="prenotazioni-json" class="hidden" data-prenotazioni='@json($prenotazioni)'></div>

    <br>

    <div class="hidden xl:block">
        <section class="w-full px-16 pt-8 pb-12 mx-auto relative">

            <div class="grid grid-cols-3 gap-8 items-start">
                <div id="carousel-wrapper-1-{{ $camera->id }}"
                     class="group relative overflow-hidden rounded-xl border border-white/10 shadow-lg w-full max-w-4xl mx-auto aspect-square"
                     data-immagini='@json($imgs)'>
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out"></div>

                    <button class="carousel-btn-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 p-2 
                                   bg-white/10 hover:bg-white/20 text-white text-lg rounded-full
                                   opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        &#10094;
                    </button>

                    <button class="carousel-btn-next absolute right-0 top-1/2 -translate-y-1/2 z-10 p-2 
                                   bg-white/10 hover:bg-white/20 text-white text-lg rounded-full
                                   opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        &#10095;
                    </button>
                </div>

                <div class="col-span-2 flex justify-end items-start">
                    <div class="text-right leading-snug">
                        <h1 class="text-4xl md:text-5xl font-tit text-white tracking-tight">
                            {{ $camera->titolo }}
                        </h1>
                        <br>
                        <div class="mt-2 text-white/60 text-sm uppercase italic tracking-wide">
                            <span class="tracking-widest italic text-white/70 uppercase">
                                {{ $camera->tipo->nome }}
                            </span>
                            <div>€{{ number_format($camera->prezzo_a_notte, 2) }} / notte</div>
                            <div>{{ $camera->capienza }} ospiti</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8 items-start -mt-80">
                <div></div>

                <div id="carousel-wrapper-2-{{ $camera->id }}"
                     class="group relative overflow-hidden rounded-xl border border-white/10 shadow-lg w-full max-w-4xl mx-auto aspect-square"
                     data-immagini='@json($imgs)'>
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out"></div>

                    <button class="carousel-btn-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 p-2 
                                   bg-white/10 hover:bg-white/20 text-white text-lg rounded-full
                                   opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        &#10094;
                    </button>

                    <button class="carousel-btn-next absolute right-0 top-1/2 -translate-y-1/2 z-10 p-2 
                                   bg-white/10 hover:bg-white/20 text-white text-lg rounded-full
                                   opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        &#10095;
                    </button>
                </div>

                <div></div>
            </div>

            <div class="grid grid-cols-3 gap-8 items-end -mt-80">
                <div class="col-span-2 flex items-end justify-center">
                    <div class="text-center leading-snug w-full max-w-3xl">
                        <div class="text-white/70 text-base font-light leading-relaxed px-4">
                            {{ $camera->descrizione }}
                        </div>
                    </div>
                </div>

                <div id="carousel-wrapper-3-{{ $camera->id }}"
                     class="group relative overflow-hidden rounded-xl border border-white/10 shadow-lg w-full max-w-4xl mx-auto aspect-square"
                     data-immagini='@json($imgs)'>
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out"></div>

                    <button class="carousel-btn-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 p-2 
                                   bg-white/10 hover:bg-white/20 text-white text-lg rounded-full
                                   opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        &#10094;
                    </button>

                    <button class="carousel-btn-next absolute right-0 top-1/2 -translate-y-1/2 z-10 p-2 
                                   bg-white/10 hover:bg-white/20 text-white text-lg rounded-full
                                   opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        &#10095;
                    </button>
                </div>
            </div>

        </section>
    </div>

    <section class="w-full px-4 py-10 max-w-screen-xl mx-auto xl:hidden">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-tit text-white tracking-tight">
                {{ $camera->titolo }}
            </h1>
            <div class="mt-2 text-white/60 text-sm uppercase italic tracking-wide text-center">
                <span class="tracking-widest text-white/70">{{ $camera->tipo->nome }}</span>
                <span class="mx-2">•</span>
                <span>€{{ number_format($camera->prezzo_a_notte, 2) }} / notte</span>
                <span class="mx-2">•</span>
                <span>{{ $camera->capienza }} ospiti</span>
            </div>
        </div>

        <div id="galleria-camera-{{ $camera->id }}"
             class="rounded-xl galleria-bordi-arrotondati"
             data-immagini='@json(array_filter(array_merge([$imgs[0] ?? null], array_slice($imgs->all(), 3))))'>
        </div>

        <br>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="gallery-uno rounded-xl overflow-hidden shadow-lg border border-white/10 aspect-square">
                <a href="{{ asset('storage/immagini/' . ($imgs[1]->path ?? 'placeholder.jpg')) }}">
                    <img src="{{ asset('storage/immagini/' . ($imgs[1]->path ?? 'placeholder.jpg')) }}"
                        class="w-full h-full object-cover" />
                </a>
            </div>
            <div class="gallery-due rounded-xl overflow-hidden shadow-lg border border-white/10 aspect-square">
                <a href="{{ asset('storage/immagini/' . ($imgs[2]->path ?? 'placeholder.jpg')) }}">
                    <img src="{{ asset('storage/immagini/' . ($imgs[2]->path ?? 'placeholder.jpg')) }}"
                        class="w-full h-full object-cover" />
                </a>
            </div>
        </div>

        <div class="text-white/80 text-base font-light leading-relaxed text-center px-4 max-w-full mt-8">
            {{ $camera->descrizione }}
        </div>
    </section>

    <br>
    <br>
    <br>
    <hr>
    <br>

    <h1 class="text-center text-white text-xl md:text-3xl lg:text-4xl font-tit font-bold uppercase tracking-wide mb-6">
        Controlla disponibilità
    </h1>

    <div id="date-error-alert"
         class="hidden opacity-0 transition-all duration-500 ease-in-out 
                bg-red-500/10 text-red-200 backdrop-blur-md border border-red-400/30 
                rounded-md px-4 py-3 mt-4 text-sm shadow-md 
                text-center mx-4 sm:mx-auto sm:max-w-2xl">
        L'intervallo selezionato include notti già prenotate. Seleziona un'altra data!
    </div>

    <div class="hidden xl:block">
        <div class="px-4">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-full max-w-6xl mt-8 px-6 py-4 shadow-lg mx-auto flex flex-col md:flex-row w-full">
                <div class="flex justify-center basis-full md:basis-2/5 mb-4 md:mb-0">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-2 w-full max-w-xs relative">
                        <span class="text-white uppercase text-sm font-semibold">Partenza</span>
                        <div class="relative w-full">
                            <input id="data_inizio" name="arrivo" type="text"
                                   value="{{ request('arrivo') }}"
                                   placeholder="Seleziona una data"
                                   autocomplete="off"
                                   class="w-full px-4 py-2 rounded-full bg-transparent text-white placeholder-white/70 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/30 transition text-sm md:text-base" />
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/50 pointer-events-none">
                                <x-icona-calendario />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center basis-full md:basis-2/5 mb-4 md:mb-0">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-2 w-full max-w-xs relative">
                        <span class="text-white uppercase text-sm font-semibold">Ritorno</span>
                        <div class="relative w-full">
                            <input id="data_fine" name="partenza" type="text"
                                   value="{{ request('partenza') }}"
                                   placeholder="Seleziona una data"
                                   autocomplete="off"
                                   class="w-full px-4 py-2 rounded-full bg-transparent text-white placeholder-white/70 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/30 transition text-sm md:text-base" />
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/50 pointer-events-none">
                                <x-icona-calendario />
                            </div>
                        </div>
                    </div>
                </div>

                <div id="bottonePrenota" class="hidden opacity-0 transition-opacity duration-300 justify-center text-center basis-full md:basis-1/5">
                    @auth
                        @role('admin')
                            <x-a-personalizzato href="{{ url('/dashboard') }}"
                                class="px-4 py-2 hover:border-gray-400 transition-all duration-300 text-xs">
                                Dashboard Admin
                            </x-a-personalizzato>
                        @endrole
                        @role('user')
                            <x-a-personalizzato href="#" onclick="apriModaleConPrenotazione({{ $camera->id }})"
                                class="px-4 py-1 text-xs">
                                Prenota
                                <x-slot name="span">
                                    <span class="ml-2 text-xl inline-block animate-arrow-slide"> &rsaquo;</span>
                                </x-slot>
                            </x-a-personalizzato>
                        @endrole
                    @endauth
                    @guest
                        <x-a-personalizzato href="#" onclick="apriModaleConPrenotazioneGuest({{ $camera->id }})"
                            class="px-4 py-1 text-xs">
                            Prenota
                            <x-slot name="span">
                                <span class="ml-2 text-xl inline-block animate-arrow-slide">&rsaquo;</span>
                            </x-slot>
                        </x-a-personalizzato>
                    @endguest
                </div>
            </div>

            <div class="w-full mt-4 justify-center text-center order-last">
                <button id="resettaDate"
                        class="hidden text-white/80 bg-transparent text-titolo text-xs hover:underline hover:text-white">
                    Resetta date
                </button>
            </div>
        </div>
    </div>

    <div class="block xl:hidden mt-8 px-4">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl px-4 py-5 shadow-md space-y-5 max-w-full">

            <div>
                <span class="text-white uppercase text-sm font-semibold">Partenza</span>
                <div class="relative">
                    <input id="data_inizio_mobile" name="arrivo" type="text"
                           value="{{ request('arrivo') }}"
                           placeholder="Seleziona una data"
                           autocomplete="off"
                           class="w-full px-4 py-2 pr-10 rounded-md bg-transparent text-white placeholder-white/70 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/30 text-base" />
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-white/50">
                        <x-icona-calendario />
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <span class="text-white uppercase text-sm font-semibold">Ritorno</span>
                <div class="relative">
                    <input id="data_fine_mobile" name="partenza" type="text"
                           value="{{ request('partenza') }}"
                           placeholder="Seleziona una data"
                           autocomplete="off"
                           class="w-full px-4 py-2 pr-10 rounded-md bg-transparent text-white placeholder-white/70 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/30 text-base" />
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-white/50">
                        <x-icona-calendario />
                    </div>
                </div>
            </div>

            <div id="bottonePrenotaMobile" class="hidden opacity-0 transition-opacity duration-300 w-full text-center">
                @auth
                    @role('admin')
                        <x-a-personalizzato href="{{ url('/dashboard') }}"
                            class="px-4 py-2 hover:border-gray-400 transition-all duration-300 text-xs">
                            Dashboard Admin
                        </x-a-personalizzato>
                    @endrole

                    @role('user')
                        <br>
                        <x-a-personalizzato href="#" onclick="apriModaleConPrenotazione({{ $camera->id }})"
                            class="px-4 py-1 text-xs">
                            Prenota
                            <x-slot name="span">
                                <span class="ml-2 text-xl inline-block animate-arrow-slide"> &rsaquo;</span>
                            </x-slot>
                        </x-a-personalizzato>
                    @endrole
                @endauth

                @guest
                    <x-a-personalizzato href="#" onclick="apriModaleConPrenotazioneGuest({{ $camera->id }})"
                        class="px-4 py-1 text-xs">
                        Prenota
                        <x-slot name="span">
                            <span class="ml-2 text-xl inline-block animate-arrow-slide">&rsaquo;</span>
                        </x-slot>
                    </x-a-personalizzato>
                @endguest
            </div>

            <div class="text-center mb-3">
                <button id="resettaDateMobile"
                        class="hidden text-white/80 bg-transparent text-titolo text-xs hover:underline hover:text-white">
                    Resetta date
                </button>
            </div>
        </div>
    </div>

    <br>
</x-guest-layout>


{{-- Modale per i guest: richiede login o registrazione per procedere con la prenotazione --}}
<x-modale-personalizzato id="modaleGuest" maxWidth="md">
    <div class="text-center space-y-6">
        <h2 class="text-2xl font-corsivo font-bold italic tracking-wide">Accedi o Registrati</h2>
        <p class="text-white/70 text-sm max-w-md mx-auto leading-relaxed">
            Per poter prenotare una delle nostre camere, effettua l'accesso o crea un nuovo account.
        </p>

        <div class="flex flex-col gap-3 text-sm max-w-xs mx-auto">
            <x-a-personalizzato href="{{ route('login') . '?redirect=prenotazione' }}"
                                class="px-6 py-2 text-center justify-center">
                Accedi
            </x-a-personalizzato>

            <x-a-personalizzato href="{{ route('register') . '?redirect=prenotazione' }}"
                                class="px-6 py-2 text-center justify-center">
                Registrati
            </x-a-personalizzato>

            <button onclick="chiudiModale('modaleGuest')"
                    class="text-xs text-white/60 hover:text-white mt-2 tracking-wide uppercase">
                Torna indietro
            </button>
        </div>
    </div>
</x-modale-personalizzato>

{{-- Modale di conferma prenotazione per utenti user --}}
<x-modale-personalizzato id="modaleConfermaPrenotazione" maxWidth="md">
    <div class="text-center space-y-6">
        <h2 class="text-2xl font-corsivo font-bold italic tracking-wide">Conferma Prenotazione</h2>
        <p class="text-white/70 text-sm max-w-md mx-auto leading-relaxed">
            Sei sicuro di voler procedere con la prenotazione di questa camera?<br>
            Potrai visualizzare le tue prenotazioni nella sezione dedicata.
        </p>

        <div class="flex flex-col gap-3 text-sm max-w-xs mx-auto">
            <x-a-personalizzato href="#"
                                id="linkConfermaPrenotazione"
                                class="px-4 py-1 text-sm justify-center">
                Conferma
            </x-a-personalizzato>

            <button onclick="chiudiModale('modaleConfermaPrenotazione')"
                    class="text-xs text-white/60 hover:text-white mt-2 tracking-wide uppercase">
                Annulla
            </button>
        </div>
    </div>
</x-modale-personalizzato>
