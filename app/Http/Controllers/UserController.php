<?php

//Controller per la gestione utenti da parte degli admin (+dashboard admin)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Prenotazione;
use App\Models\Camera;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //serve per la creazione dell'admin dashboard in cui compariranno il numero delle prenotazioni odierne, il numero di camere disponibili oggi e il numero di clienti registrati
    public function dashboardAdmin()
    {
        $clientiRegistrati = User::role('user')->count();

        $oggi = Carbon::today();

        $prenotazioniOggi = Prenotazione::where('data_inizio', '<=', $oggi)
            ->where('data_fine', '>', $oggi)
            ->whereIn('stato_id', [2, 4])
            ->count();

        $totaleCamere = Camera::count();

        $camereDisponibili = $totaleCamere - $prenotazioniOggi;

        return view('admin-dashboard')
            ->with('clientiRegistrati', $clientiRegistrati)
            ->with('prenotazioniOggi', $prenotazioniOggi)
            ->with('camereDisponibili', $camereDisponibili);
    }

    /**
     * Display a listing of the resource. -> lista di tutti i clienti registrati visibili solo agli admin
     */
    public function index()
    {
        $clienti = User::role('user')->get();
        return view('pages.admin.elimina-account')->with('clienti', $clienti);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. -> creazione di un nuovo admin da parte di un altro admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'surname'  => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'surname'  => $request->surname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        return redirect()->back()->with('success', 'Nuovo admin creato con successo.');
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage. -> eliminare(soft delete) un cliente da parte di un admin 
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('user')) {
            $user->delete();
            return back()->with('success', 'Cliente eliminato con successo.');
        }

        return redirect()->back()->with('error', 'Non puoi eliminare questo utente!');
    }
}
