{{-- 
    Pagina di eliminazione degli account clienti: permette la visualizzazione di tutti 
    i clienti registrati all'interno di una tabella e permette all’admin di eliminarli 
    tramite un modale di conferma. Viene gestita anche la versione responsitive della tabella.
--}}
<x-app-layout :title="'Elimina Account Clienti'">
    <div class="max-w-full mx-auto py-12 px-10 text-white space-y-8">
        <br>
        <h1 class="text-3xl font-bold italic text-center">Gestione Clienti Registrati</h1>

        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition.duration.500ms
                class="max-w-4xl mx-auto bg-white/10 text-white/80 border border-white/30 rounded-xl px-4 py-3 backdrop-blur-md shadow-md text-center">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="hidden sm:block w-full px-4">
        <div class="w-full rounded-xl shadow border border-white/10 backdrop-blur-md">
            <table class="w-full table-auto text-sm">
                <thead class="bg-white/5 text-white/60">
                    <tr>
                        <th class="px-4 py-3 text-left">Nome</th>
                        <th class="px-4 py-3 text-left">Cognome</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="text-white/90">
                    @foreach ($clienti as $cliente)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 break-words">{{ $cliente->name }}</td>
                            <td class="px-4 py-3 break-words">{{ $cliente->surname }}</td>
                            <td class="px-4 py-3 break-words">{{ $cliente->email }}</td>
                            <td class="px-4 py-3">
                                <button
                                    onclick="apriModaleEliminazioneCliente('{{ $cliente->id }}', '{{ $cliente->name }} {{ $cliente->surname }}')"
                                    class="inline-flex items-center gap-1 px-3 py-1 border border-white/30 bg-white/5 text-white/70 text-xs font-semibold rounded-lg transition duration-200 hover:bg-red-500/20 hover:text-red-400 hover:border-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Elimina
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="block sm:hidden px-4 space-y-4">
        @foreach ($clienti as $cliente)
            <div class="rounded-2xl border border-white/10 backdrop-blur-md shadow px-4 py-3 space-y-2 text-white text-sm">
                <div><span class="font-semibold text-white/60">Nome:</span> {{ $cliente->name }}</div>
                <div><span class="font-semibold text-white/60">Cognome:</span> {{ $cliente->surname }}</div>
                <div><span class="font-semibold text-white/60">Email:</span> {{ $cliente->email }}</div>
                <div class="text-right">
                    <button
                        onclick="apriModaleEliminazioneCliente('{{ $cliente->id }}', '{{ $cliente->name }} {{ $cliente->surname }}')"
                        class="inline-flex items-center gap-1 px-3 py-1 border border-white/30 bg-white/5 text-white/70 text-xs font-semibold rounded-lg transition duration-200 hover:bg-red-500/20 hover:text-red-400 hover:border-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Elimina
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>

{{-- Modale di conferma per l'eliminazione definitiva di un cliente --}}
<x-modale-personalizzato id="modaleConfermaEliminazioneCliente" maxWidth="md">
    <div class="text-center space-y-5 text-white px-2">
        <h2 class="text-xl font-semibold tracking-wide text-white">
            Confermare l'eliminazione?
        </h2>
        <p id="testoConfermaEliminazione" class="text-white/60 text-sm leading-relaxed max-w-md mx-auto"></p>
        <form id="formEliminaCliente" method="POST" action="" class="space-y-4">
            @csrf
            @method('DELETE')
            <div class="flex justify-center">
                <x-button class="px-5 py-1.5 text-sm bg-white/10 hover:bg-white/20 border border-white/30 text-white">
                    Elimina definitivamente
                </x-button>
            </div>
            <div class="text-center">
                <button type="button"
                        onclick="chiudiModale('modaleConfermaEliminazioneCliente')"
                        class="text-xs text-white/60 hover:text-white transition tracking-wide uppercase">
                    Annulla
                </button>
            </div>
        </form>
    </div>
</x-modale-personalizzato>
