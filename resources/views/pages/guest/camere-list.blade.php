{{-- 
    Pagina pubblica contenente la lista delle camere: contiene una barra per verificare la disponibilità delle varie camere nelle date selezionate
    dall'utente (con versione anche responsitive), la possibilità di filtrare le camere a seconda del tipo e la possibilità di visualizzare tutte le camere
    (se l'utente non seleziona le date, puù accedere ai dettagli della camera, altrimenti appare un link per prenotare con annesso diversi modali di conferma a seconda 
    che l'utente sia un guest o un user, se è un admin invece per sicurezza appare un link alla sua dashboard)
--}}
<x-guest-layout>
    <div class="text-center my-10 px-4">
        <h1 id="titolo-home"
            class="text-3xl md:text-5xl lg:text-6xl font-cor text-white italic tracking-wide max-w-4xl mx-auto leading-snug font-bold pt-6 pb-3 animate-fade-in-up">
            Un Hotel, Tre Correnti
        </h1>
        <p class="text-white/70 text-sm md:text-base max-w-2xl mx-auto animate-fade-in-up delay-200">
            Ogni camera riflette una corrente artistica. Scegli l’emozione che vuoi vivere.
        </p>
    </div>

    <div class="px-4 pt-0 max-w-full">
        <div id="errore-date"
             class="hidden mx-auto max-w-xl text-tit text-sm text-white/90 text-center px-4 py-2 rounded-xl shadow-md backdrop-blur-sm bg-white/5 border border-white/20 transition-opacity duration-500">
        </div>

        <div class="hidden sm:block">
            <x-form-personalizzato action="{{ route('camere') }}" method="GET" id="formCamere">
                <div class="flex justify-center basis-full md:basis-2/5 mb-4 md:mb-0">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-2 w-full max-w-xs relative">
                        <span class="text-white uppercase text-sm font-semibold">Partenza</span>
                        <div class="relative w-full">
                            <input id="data_inizio_camere" name="arrivo" type="text"
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
                            <input id="data_fine_camere" name="partenza" type="text"
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

                <div class="flex justify-center basis-full md:basis-1/5">
                    <x-button type="submit">Cerca</x-button>
                </div>
            </x-form-personalizzato>

            <div class="w-full mt-4 justify-center text-center order-last">
                <button id="resettaDateButton"
                        class="hidden text-white/80 bg-transparent mt-2 text-titolo text-xs hover:underline hover:text-white">
                    Resetta date
                </button>
            </div>
        </div>

        <div class="block sm:hidden text-center -mt-10">
            <br>
            <button id="toggleDateMobile"
                    class="inline-flex items-center gap-1 text-white/80 text-sm hover:text-white transition">
                <span id="testoToggleDate">Seleziona date per verificare la disponibilità</span>
                <svg id="frecciaToggleDate"
                     xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4 transform transition-transform duration-300"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <div id="contenitoreFormDateMobile" class="sm:hidden px-2 pt-0 -mt-5 hidden transition-all duration-300">
            <div id="errore-date-mobile"
                 class="hidden mx-auto max-w-xs text-tit text-sm text-white/90 text-center px-4 py-2 rounded-xl shadow-md backdrop-blur-sm bg-white/5 border border-white/20 transition-opacity duration-500">
            </div>

            <x-form-personalizzato action="{{ route('camere') }}" method="GET" id="formCamereMobile"
                class="w-full max-w-md mx-auto bg-white/5 border border-white/20 backdrop-blur-md rounded-xl shadow-md px-6 py-4 space-y-8">

                <div>
                    <span class="text-white uppercase text-sm font-semibold">Partenza</span>
                    <div class="relative">
                        <input id="data_inizio_camere_mobile" name="arrivo" type="text"
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
                        <input id="data_fine_camere_mobile" name="partenza" type="text"
                            value="{{ request('partenza') }}"
                            placeholder="Seleziona una data"
                            autocomplete="off"
                            class="w-full px-4 py-2 pr-10 rounded-md bg-transparent text-white placeholder-white/70 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/30 text-base" />
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-white/50">
                            <x-icona-calendario />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-3 pt-2">
                    <x-button type="submit" class="w-full rounded-md text-sm py-2">Cerca</x-button>
                    <button type="button" id="resettaDateButtonMobile"
                            class="hidden text-white/80 text-xs hover:underline hover:text-white transition">
                        Resetta date
                    </button>
                </div>
            </x-form-personalizzato>
        </div>
    </div>

    <br>
    <hr>

    <div class="w-full flex flex-wrap justify-center gap-x-4 gap-y-2 mt-8 text-white font-testo text-xs sm:text-sm uppercase tracking-wide text-center">
        <a href="{{ route('camere', ['tipo' => null, 'arrivo' => request('arrivo'), 'partenza' => request('partenza')]) }}"
            class="{{ is_null(request('tipo')) ? 'underline font-bold' : 'hover:underline' }}">
            Panoramica
        </a>
        <a href="{{ route('camere', ['tipo' => 'Espressionismo', 'arrivo' => request('arrivo'), 'partenza' => request('partenza')]) }}"
            class="{{ request('tipo') === 'Espressionismo' ? 'underline font-bold' : 'hover:underline' }}">
            Espressionismo
        </a>
        <a href="{{ route('camere', ['tipo' => 'Surrealismo', 'arrivo' => request('arrivo'), 'partenza' => request('partenza')]) }}"
            class="{{ request('tipo') === 'Surrealismo' ? 'underline font-bold' : 'hover:underline' }}">
            Surrealismo
        </a>
        <a href="{{ route('camere', ['tipo' => 'Cubismo', 'arrivo' => request('arrivo'), 'partenza' => request('partenza')]) }}"
            class="{{ request('tipo') === 'Cubismo' ? 'underline font-bold' : 'hover:underline' }}">
            Cubismo
        </a>
    </div>

    <br>
    <hr>
    <br>

    @if ($tipoCamera && ($camere->isNotEmpty()))
        <p id="sottotitolo"
           class="w-full px-4 text-center mt-4 italic font-cor text-base sm:text-lg md:text-2xl tracking-wide animate-fade-in-up">
            {{ $tipoCamera->descrizione }}
        </p>
    @elseif ($camere->isNotEmpty())
        <p id="sottotitolo"
           class="w-full px-4 text-center mt-4 italic font-cor text-base sm:text-lg md:text-2xl tracking-wide animate-fade-in-up">
            Dormire in un'opera d'arte. Ogni camera è pensata per sorprendere, ispirare, accogliere.
        </p>
    @endif

    @if ($camere->isEmpty() && $tipoCamera)
        <div class="w-full px-4 text-center mt-12 opacity-80 text-xs sm:text-sm uppercase tracking-wide font-bold font-tit">
            Nessuna camera {{ $tipoCamera->nome }} disponibile per le date selezionate!
        </div>
    @elseif ($camere->isEmpty())
        <div class="w-full px-4 text-center mt-12 opacity-80 text-xs sm:text-sm uppercase tracking-wide font-bold font-tit">
            Nessuna camera disponibile per le date selezionate nella nostra struttura!
        </div>
    @endif

    <div id="sezioneCamere"
         class="w-full px-6 py-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
        @foreach ($camere as $camera)
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl overflow-hidden shadow-lg text-white transition-all duration-300">
                <div id="galleria-camera-{{ $camera->id }}"
                     data-immagini='@json($camera->immagini)'
                     class="mb-4">
                    @if (empty($camera->immagini) || count($camera->immagini) === 0)
                        <div class="w-full h-48 bg-gray-700 flex items-center justify-center text-sm opacity-50 rounded-xl">
                            Nessuna immagine
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <h3 class="text-xl font-bold mb-2 text-white">
                        {{ $camera->titolo }}
                    </h3>
                    <p class="text-sm text-white/80">
                        {{ $camera->tipo->nome }}
                    </p>
                    <br>

                    @if (request()->has(['arrivo', 'partenza']))
                        @auth
                            @role('admin')
                                <x-a-personalizzato
                                    href="{{ url('/dashboard') }}"
                                    class="px-4 py-2 hover:border-gray-400 transition-all duration-300 text-xs">
                                    Dashboard Admin
                                </x-a-personalizzato>
                            @endrole
                            @role('user')
                                <x-a-personalizzato href="#"
                                    onclick="apriModaleConPrenotazione({{ $camera->id }})"
                                    class="px-4 py-1 text-xs">
                                    Prenota
                                    <x-slot name="span">
                                        <span class="ml-2 text-xl inline-block animate-arrow-slide"> &rsaquo;</span>
                                    </x-slot>
                                </x-a-personalizzato>
                            @endrole
                        @else
                            <x-a-personalizzato href="#"
                                onclick="apriModaleConPrenotazioneGuest({{ $camera->id }})"
                                class="px-4 py-1 text-xs">
                                Prenota
                                <x-slot name="span">
                                    <span class="ml-2 text-xl inline-block animate-arrow-slide">&rsaquo;</span>
                                </x-slot>
                            </x-a-personalizzato>
                        @endauth
                    @else
                        <a href="{{ route('camera', ['id' => $camera->id]) }}"
                           class="text-xs tracking-wide uppercase text-white/60 hover:text-white hover:underline transition inline-flex items-center gap-1">
                            Scopri di più <span class="text-base animate-arrow-slide">&rsaquo;</span>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
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




