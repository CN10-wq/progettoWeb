<?php

//Controller per la gestione dell'autenticazione utenti

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    //pagina di login
    public function create()
    {
        return view('auth.login');
    }

    //gestione autenticazione con redirect personalizzato
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $cameraId = session('prenotazione_camera_id');
        $dataInizio = session('prenotazione_data_inizio');
        $dataFine = session('prenotazione_data_fine');

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        session()->forget(['prenotazione_camera_id', 'prenotazione_data_inizio', 'prenotazione_data_fine']);

        if ($cameraId && $dataInizio && $dataFine && Auth::user()->hasRole('user')) {
            session()->forget(['prenotazione_camera_id', 'prenotazione_data_inizio', 'prenotazione_data_fine']);

            return redirect()->route('prenotazione', [
                'id' => $cameraId,
                'arrivo' => $dataInizio,
                'partenza' => $dataFine,
            ]);
        }

        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        return redirect()->intended('/dashboard');
    }

    //gestione logout
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
