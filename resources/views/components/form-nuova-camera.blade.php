{{-- 
    Componente form per la creazione di una nuova camera, con i vari campi.
--}}
@props(['tipi'])

<form id="form-nuova-camera" class="w-full max-w-full px-10 mx-auto space-y-6" enctype="multipart/form-data">
    <div>
        <label for="titolo" class="block text-white/80 mb-1">Titolo</label>
        <input id="titolo" name="titolo" required class="w-full bg-white/10 text-white px-4 py-2 rounded-md" />
    </div>

    <div>
        <label for="descrizione" class="block text-white/80 mb-1">Descrizione</label>
        <textarea id="descrizione" name="descrizione" class="w-full bg-white/10 text-white px-4 py-2 rounded-md"></textarea>
    </div>

    <div>
        <label for="prezzo" class="block text-white/80 mb-1">Prezzo a notte (€)</label>
        <input id="prezzo" type="number" name="prezzo_a_notte" step="0.01" required class="w-full bg-white/10 text-white px-4 py-2 rounded-md" />
    </div>

    <div>
        <label for="capienza" class="block text-white/80 mb-1">Capienza (numero di ospiti)</label>
        <input id="capienza" type="number" name="capienza" required min="1" class="w-full bg-white/10 text-white px-4 py-2 rounded-md" />
    </div>

    <div>
        <label for="tipo_camera" class="block text-white/80 mb-1">Tipo camera</label>
        <select id="tipo_camera" name="tipo_camera_id" required class="w-full bg-white/10 text-white px-4 py-2 rounded-md">
            <option value="" disabled selected class="text-white/40 italic">Scegli un tipo di camera</option>
            @foreach ($tipi as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
            @endforeach
        </select>
    </div>

    <br>

    <div class="mt-10 space-y-4">
        <h2 class="block text-white/80 mb-1">Inserisci immagini (minimo 3)</h2>
        <div id="contenitore-immagini" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>
        <button type="button" id="btn-aggiungi" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl border border-white/20 transition">
            + Aggiungi immagine
        </button>
    </div>

    <div class="flex justify-end gap-4 pt-4 border-t border-white/10 mt-6">
        <button type="button" onclick="gestioneCamere_deselezionaTutti()"
            class="px-5 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-white/70 hover:text-white transition shadow border border-transparent hover:border-white">
            ✖ Annulla
        </button>
        <button type="submit"
            class="px-5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold transition shadow border border-white">
            ✔ Salva
        </button>
    </div>
</form>
