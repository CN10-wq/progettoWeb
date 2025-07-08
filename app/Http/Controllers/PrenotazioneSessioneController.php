<?php

//Controller per la gestione dei dati di sessione nel caso in cui un utente non loggato intenda prenotare: fa il login/si registra e verrà reindirizzato subito 
//alla sua scelta di prenotazione se è un user, altrimenti verrà reindirizzato alla dashboard admin

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PrenotazioneSessioneController extends Controller
{
    //salva i dati di prenotazione (id della camera, data di arrivo e data di partenza) nella sessione solo in caso un utente sia un user, così da poterli usare in seguito al login/registrazione
    //si tratta di una chiamata AJAX con una risposta in formato JSON
        public function salva(Request $request)
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            session()->forget([
                'prenotazione_camera_id',
                'prenotazione_data_inizio',
                'prenotazione_data_fine',
            ]);

            return response()->json([
                'success' => false,
                'redirect' => route('dashboard'),
                'message' => 'Gli admin non possono effettuare prenotazioni.',
            ]);
        }

        session([
            'prenotazione_camera_id' => $request->camera_id,
            'prenotazione_data_inizio' => $request->arrivo,
            'prenotazione_data_fine' => $request->partenza,
        ]);

        return response()->json(['success' => true]);
    }

    //reindirizza gli utenti in base al ruolo e ai dati di sessione: se admin -> dashboard admin, se user con dati di sessione salvati ->  pagina di prenotazione, altrimenti -> pagina welcome
        public function redirectAfterLogin()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return app(UserController::class)->dashboardAdmin();
        }

        if (
            $user->hasRole('user') &&
            session()->has('prenotazione_camera_id') &&
            session()->has('prenotazione_data_inizio') &&
            session()->has('prenotazione_data_fine')
        ) {
            return redirect()->route('prenotazione', [
                'id' => session('prenotazione_camera_id'),
                'arrivo' => session('prenotazione_data_inizio'),
                'partenza' => session('prenotazione_data_fine'),
            ]);
        }

        return view('welcome');
    }

}
