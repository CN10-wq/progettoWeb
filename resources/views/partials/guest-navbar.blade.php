{{-- Navbar che cambia dinamicamente in base al tipo di utente:
     - Il logo a sinistra è sempre presente per tutti (guest e user);
     - Se l'utente è un guest: a destra ci sarà Log in e Registrati;
     - Se l'utente è un user: a destra verrà mostrato il messaggio "Benvenuto Nome!" con l'immagine del profilo (cliccando 
     sull'immagine si apre un menu con Profilo e Log out) e l'area Le mie prenotazioni;
     - La navbar è responsive: in tal caso sarà costituita da un hamburger menu che mostra le stesse voci in un menu a comparsa.
--}}
<nav x-data="{ open: false }" id="navbarGuest" class="fixed w-full top-0 z-50 transition-colors duration-2000 text-white font-testo bg-transparent font-bold">
    <div class="px-4 py-1">
        <div class="flex justify-between items-center h-16">
            <div class="shrink-0">
                <a href="{{ url('/') }}">
                    <x-application-logo class="h-14 w-auto" />
                </a>
            </div>

            <div class="hidden sm:flex items-center gap-4">
                @auth
                    @role('admin')
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded border border-white hover:border-gray-400 transition-all duration-300">
                            Dashboard Admin
                        </a>
                    @endrole

                    @role('user')
                        <span class="text-white/80 text-sm">Benvenuto {{ Auth::user()->name }}!</span>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-3 text-sm rounded-full focus:outline-none transition duration-200 text-white">
                                    @if(Auth::user()->profile_photo_path !== null)
                                        <img class="size-8 rounded-full object-cover shadow-md" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    @else
                                        <div class="size-8 rounded-full bg-white/80 text-sfondo font-corsivo flex items-center justify-center font-semibold shadow-md">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profilo') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>

                        <a href="{{ route('areaPersonale') }}" class="text-white/80 bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full text-sm hover:text-white hover:border-white/30 transition duration-300 shadow-md">
                            Le mie prenotazioni
                        </a>
                    @endrole
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded border border-transparent hover:border-white transition-all duration-300">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded border border-white hover:border-gray-400 transition-all duration-300">Registrati</a>
                    @endif
                @endguest
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/10 backdrop-blur-md border border-white/10 focus:outline-none focus:ring-2 focus:ring-white/20 transition duration-200 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-6 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-6 scale-95"
        :class="{ 'flex': open, 'hidden': !open }"
        class="hidden sm:hidden flex-col bg-[#3a3a3a]/90 backdrop-blur-xl border border-white/10 shadow-2xl px-6 py-8 space-y-5 rounded-3xl mx-4 mt-4"
    >

        @auth
            @role('admin')
                <a href="{{ url('/dashboard') }}"
                   @click="open = false"
                   class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white tracking-wide text-center">
                    Dashboard Admin
                </a>
            @endrole

            @role('user')
                <div class="flex items-center justify-center px-4 mt-4 gap-x-3 border-b border-white/10 pb-3">
                    <a href="{{ route('profile.show') }}"
                       class="inline-flex items-center justify-center size-10 rounded-full border border-white/20 bg-white/10 hover:bg-white/20 transition-all duration-300 shadow-md">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            @if(Auth::user()->profile_photo_path)
                                <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            @else
                                <div class="size-10 rounded-full bg-white/80 text-sfondo font-corsivo flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif
                    </a>

                    <div class="text-white/70 text-sm italic">
                        Benvenuto {{ Auth::user()->name }}!
                    </div>
                </div>

                <a href="{{ route('profile.show') }}"
                   @click="open = false"
                   class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white tracking-wide text-center">
                    Profilo
                </a>

                <a href="{{ route('areaPersonale') }}"
                   @click="open = false"
                   class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white tracking-wide text-center">
                    Le mie prenotazioni
                </a>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button
                        @click.prevent="$root.submit();"
                        class="w-full px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white tracking-wide text-center">
                        Log Out
                    </button>
                </form>
            @endrole
        @endauth

        @guest
            <a href="{{ route('login') }}"
               class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white tracking-wide text-center">
                Log in
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white tracking-wide text-center">
                    Registrati
                </a>
            @endif
        @endguest

    </div>
</nav>
