{{-- 
    Componente per il form di modifica di un servizio-extra
--}}
@props(['servizio', 'id', 'prefix' => ''])

<form method="POST" action="{{ route('servizi-extra.update', $servizio->id) }}"
      class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-md shadow">
    @csrf
    @method('PUT')

    <div class="sm:col-span-2">
        <label for="nome-{{ $prefix }}{{ $id }}" class="block text-sm text-white/70 mb-1">Nome servizio</label>
        <input type="text" name="nome" id="nome-{{ $prefix }}{{ $id }}" value="{{ $servizio->nome }}" required
               class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2" />
    </div>

    <div>
        <label for="prezzo-{{ $prefix }}{{ $id }}" class="block text-sm text-white/70 mb-1">Prezzo (€)</label>
        <input type="number" name="prezzo" id="prezzo-{{ $prefix }}{{ $id }}" value="{{ $servizio->prezzo }}" step="0.01" required
               class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2" />
    </div>

    <div>
        <label for="prezzo_unita-{{ $prefix }}{{ $id }}" class="block text-sm text-white/70 mb-1">Unità di prezzo</label>
        <input type="text" name="prezzo_unita" id="prezzo_unita-{{ $prefix }}{{ $id }}" value="{{ $servizio->prezzo_unita }}" required
               class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2" />
    </div>

    <div class="sm:col-span-2">
        <label for="descrizione-{{ $prefix }}{{ $id }}" class="block text-sm text-white/70 mb-1">Descrizione</label>
        <textarea name="descrizione" id="descrizione-{{ $prefix }}{{ $id }}" rows="3"
                  class="w-full rounded-xl bg-white/10 text-white border border-white/20 p-2">{{ $servizio->descrizione ?? '' }}</textarea>
    </div>

    <div class="sm:col-span-2 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-2 mt-2">
        <button type="button"
                onclick="document.getElementById('formModificaRow-{{ $prefix }}{{ $id }}').classList.add('hidden'); document.getElementById('azione-servizio-{{ $prefix }}{{ $id }}').classList.remove('hidden')"
                class="w-full sm:w-auto text-xs px-4 py-2 rounded-xl border border-white/30 text-white/80 hover:bg-white/10 transition backdrop-blur-md text-center">
            ✕ Annulla modifica
        </button>

        <button type="submit"
                class="w-full sm:w-auto text-sm px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl border border-white/30 text-white text-center">
            Salva modifiche
        </button>
    </div>
</form>
