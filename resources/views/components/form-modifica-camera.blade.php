@props(['camera', 'listaTipi'])

@php
    $id = $camera['id'];
@endphp

<form id="form-modifica-{{ $id }}" class="text-white space-y-6" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="grid md:grid-cols-2 gap-6">
        <div class="col-span-2">
            <x-label>Titolo</x-label>
            <x-input type="text" name="titolo" :value="$camera['titolo']" required />
        </div>

        <div>
            <x-label>Tipo camera</x-label>
            <select name="tipo_id" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl" required>
                <option value="" disabled {{ $camera['tipo_id'] ? '' : 'selected' }}>-- Seleziona tipo --</option>
                @foreach ($listaTipi as $tipo)
                    <option value="{{ $tipo['id'] }}" @selected($tipo['id'] == $camera['tipo_id'])>
                        {{ $tipo['nome'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-label>Prezzo a notte (€)</x-label>
            <x-input type="number" step="0.01" name="prezzo_a_notte" :value="$camera['prezzo']" required />
        </div>

        <div>
            <x-label>Capienza massima</x-label>
            <x-input type="number" name="capienza" :value="$camera['capienza']" min="1" required />
        </div>

        <div class="col-span-2">
            <x-label>Descrizione</x-label>
            <textarea name="descrizione" rows="4"
                      class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl">{{ $camera['descrizione'] ?? '' }}</textarea>
        </div>
    </div>

    <div>
        <x-label class="mb-2">Immagini attuali</x-label>
        <div id="immagini-esistenti-{{ $id }}" class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($camera['immagini'] as $img)
                <div class="relative group rounded-xl overflow-hidden border border-white/20">
                    <img src="{{ $img['path'] }}" class="w-full h-48 object-cover">
                    <button type="button" data-id="{{ $img['id'] }}"
                        class="btn-rimuovi-immagine absolute top-2 right-2 text-white text-lg leading-none bg-white/10 hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center shadow border border-white/20 backdrop-blur-md transition">
                        &times;
                    </button>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="immagini_da_rimuovere" id="rimuovi-{{ $id }}">
    </div>

    <div>
        <x-label class="mb-2">Nuove immagini</x-label>
        <div id="container-upload-{{ $id }}" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
        <button type="button" id="btn-add-upload-{{ $id }}"
            class="mt-3 text-sm text-white bg-white/10 border border-white/20 px-4 py-2 rounded-xl hover:bg-white/20">
            + Aggiungi immagine
        </button>
    </div>

    <div class="flex justify-end gap-4 pt-4">
        <button type="button" onclick="gestioneCamere_attive()"
            class="text-sm text-white/60 hover:text-white underline">Annulla</button>
        <button type="submit"
            class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/30 rounded-2xl font-medium">
            Salva modifiche
        </button>
    </div>
</form>
