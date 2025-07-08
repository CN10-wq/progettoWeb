{{-- Navbar per gli admin:
     - A sinistra mostra il logo del sito e diverse voci: Dashboard, Prenotazioni, Modifica camere, Servizi, Account clienti, Nuovi admin;
     - A destra visualizza l'immagine del profilo dell'admin, da cui è possibile accedere al profilo o effettuare il logout;
     La navbar è responsive: in tal caso sarà costituita da un hamburger menu che mostra le stesse voci in un menu a comparsa. 
     Navbar per gli user: 
     - A sinistra mostra il logo del sito;
     - A destra visualizza l'immagine del profilo dell'user, da cui è possibile accedere al profilo o effettuare il logout;
    La navbar è responsive: in tal caso sarà costituita da un hamburger menu che mostra le stesse voci in un menu a comparsa. 
--}}
<nav x-data="{ open: false }" id="navbarApp" class="fixed w-full top-0 z-50 transition-colors duration-2000 text-white font-testo bg-transparent font-bold">
    <div class="px-4 py-1">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-x-8">
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-14 w-auto" />
                    </a>
                </div>

                @auth
                    @role('admin')
                        <div class="hidden xl:flex space-x-6">
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.prenotazioni') }}" :active="request()->routeIs('admin.prenotazioni')">
                                {{ __('Prenotazioni') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.camere') }}" :active="request()->routeIs('admin.camere')">
                                {{ __('Modifica camere') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('servizi-extra') }}" :active="request()->routeIs('servizi-extra')">
                                {{ __('Servizi') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.eliminaAccount') }}" :active="request()->routeIs('admin.eliminaAccount')">
                                {{ __('Account clienti') }}
                            </x-nav-link>
                            <x-nav-link href="{{ route('nuovo-admin') }}" :active="request()->routeIs('nuovo-admin')">
                                {{ __('Nuovi admin') }}
                            </x-nav-link>
                        </div>
                    @endrole
                @endauth
            </div>

            <div class="hidden xl:flex xl:items-center gap-6">
                @auth
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
                @endauth
            </div>

            <div class="-me-2 flex items-center xl:hidden">
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
        class="hidden xl:hidden flex-col bg-[#3a3a3a]/90 backdrop-blur-xl border border-white/10 shadow-2xl px-6 py-8 space-y-5 rounded-3xl mx-4 mt-4"
    >
        @auth
            @role('admin')
                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}" @click="open = false"
                       class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white text-center">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.prenotazioni') }}" @click="open = false"
                       class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white text-center">
                        Prenotazioni
                    </a>
                    <a href="{{ route('admin.camere') }}" @click="open = false"
                       class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white text-center">
                        Modifica camere
                    </a>
                    <a href="{{ route('servizi-extra') }}" @click="open = false"
                       class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white text-center">
                        Servizi
                    </a>
                    <a href="{{ route('admin.eliminaAccount') }}" @click="open = false"
                       class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white text-center">
                        Account clienti
                    </a>
                    <a href="{{ route('nuovo-admin') }}" @click="open = false"
                       class="block px-4 py-3 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 text-white text-center">
                        Nuovi admin
                    </a>
                </div>
            @endrole
        @endauth

        <div class="pt-4 border-t border-white/10">
            @auth
                <div class="flex items-center justify-center px-4 mt-4">
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
                </div>

                <div class="mt-4 space-y-2 px-4">
                    <a href="{{ route('profile.show') }}" @click="open = false"
                       class="block w-full text-sm px-4 py-2.5 rounded-xl border border-white/10 hover:bg-white/10 transition duration-300 text-white text-center">
                        Profilo
                    </a>

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button @click.prevent="$root.submit();"
                                class="w-full text-sm px-4 py-2.5 rounded-xl border border-white/10 hover:bg-white/10 transition duration-300 text-white text-center">
                            Log Out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>
