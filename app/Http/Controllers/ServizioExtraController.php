<?php

//Controller per la gestione(creazione, visualizzazione, modifica ed eliminazione) dei servizi-extra da parte dell'admin (tutto in un'unica pagina)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServizioExtra;

class ServizioExtraController extends Controller
{
    /**
     * Display a listing of the resource. -> visualizzazione di tutti i servizi-extra nella pagina dell'admin
     */
    public function index()
    {
        $servizi = ServizioExtra::all();
        return view('pages.admin.servizi')->with('servizi', $servizi);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. -> creazione di un nuovo servizio-extra da parte dell'admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string|max:500',
            'prezzo' => 'required|numeric|min:0',
            'prezzo_unita' => 'required|string|max:50',
        ]);

        ServizioExtra::create($request->only('nome', 'descrizione', 'prezzo', 'prezzo_unita'));

        return redirect()->route('servizi-extra')->with('success', 'Servizio extra creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage. ->modifica di un servizio-extra esistente da parte dell'admin
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'descrizione' => 'nullable|string|max:500',
            'prezzo' => 'required|numeric|min:0',
            'prezzo_unita' => 'required|string|max:50',
        ]);

        $servizioExtra = ServizioExtra::findOrFail($id);

        $servizioExtra->update($request->only('nome', 'descrizione', 'prezzo', 'prezzo_unita'));

        return redirect()->route('servizi-extra')->with('success', 'Servizio aggiornato con successo.');
    }

    /**
     * Remove the specified resource from storage. -> eliminazione di un servizio-extra(soft-delete)  da parte dell'admin (può eliminare un servizio solo se ne esistono almeno 3)
     */
    public function destroy(string $id)
    {
        $servizioExtra = ServizioExtra::findOrFail($id);

        if (ServizioExtra::whereNull('deleted_at')->count() <= 3) {
            return redirect()->back()->with('error', 'Devi mantenere almeno 3 servizi attivi.');
        }

        $servizioExtra->delete();

        return redirect()->route('servizi-extra')->with('success', 'Servizio eliminato con successo.');
    }
    
}
