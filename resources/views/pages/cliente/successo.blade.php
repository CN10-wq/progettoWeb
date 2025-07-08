{{-- Pagina di conferma in seguito ad una prenotazione, con possibilità di tornare alle camere o andare alla propria area personale --}}
<x-app-layout :title="'Prenotazione completata'">
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-white text-center px-6 space-y-6">
        <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-xl p-8 max-w-xl w-full shadow-xl">
            <h1 class="text-3xl font-bold mb-2 italic">Prenotazione completata!</h1>
            <p class="text-white/70 text-sm mb-6">
                Grazie per aver scelto il nostro Back To Beauty Hotel. Puoi gestire le tue prenotazioni dalla tua area personale.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('camere') }}"
                   class="inline-block px-6 py-3 text-sm font-semibold bg-white/10 text-white border border-white/20 rounded-full hover:bg-white/20 transition">
                    Torna alle camere
                </a>
                <a href="{{ route('areaPersonale') }}"
                   class="inline-block px-6 py-3 text-sm font-semibold bg-white/10 text-white border border-white/20 rounded-full hover:bg-white/20 transition">
                    Vai all’area personale
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
