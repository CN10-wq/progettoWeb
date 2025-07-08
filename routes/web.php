<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\PrenotazioneController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServizioExtraController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PrenotazioneSessioneController;


//guest
Route::get('/', function () { return view('welcome'); });
Route::get('/camere', action: [CameraController::class, 'index'])->name('camere');
Route::get('/camere/{id}', [CameraController::class, 'show'])->name('camera');



//user-cliente
Route::middleware(    ['auth:sanctum',
    config('jetstream.auth_session'),
    'verified',])->group(function () {

    Route::get('/prenotazione/{id}', function (Request $request, $id) {
        if (!auth()->user()->hasRole('user')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->create($request, $id);
    })->name('prenotazione');

    Route::post('/cliente/prenotazione', function (Request $request) {
        if (!auth()->user()->hasRole('user')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->store($request);
    })->name('prenotazione.successo');

    Route::get('/cliente/prenotazioni', function () {
        if (!auth()->user()->hasRole('user')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->index();
    })->name('areaPersonale');

    Route::delete('/prenotazioni/{id}', function ($id) {
        if (!auth()->user()->hasRole('user')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->destroy($id);
    })->name('prenotazione.cancellata');

    Route::get('/cliente/archivio-prenotazioni', function (Request $request) {
        if (!auth()->user()->hasRole('user')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->archivioCliente($request);
    })->name('cliente.archivio');

});



//admin
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/admin/nuovo-admin', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return view('pages.admin.nuovo-admin');
    })->name('nuovo-admin');

    Route::post('/admin/store', function (Request $request) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(UserController::class)->store($request);
    })->name('admin.store');

    Route::get('/admin/elimina-account', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(UserController::class)->index();
    })->name('admin.eliminaAccount');

    Route::delete('/admin/elimina-cliente/{id}', function ($id) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(UserController::class)->destroy($id);
    })->name('admin.elimina-cliente');

    // Gestione prenotazioni
    Route::get('/admin/prenotazioni', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return view('pages.admin.prenotazioni');
    })->name('admin.prenotazioni');

    Route::get('/admin/prenotazioni/attesa', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->prenotazioniAttesa();
    });

    Route::get('/admin/prenotazioni/oggi', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->prenotazioniOggi();
    });

    Route::get('/admin/prenotazioni/archivio', function (Request $request) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->archivio($request);
    });

    Route::post('/admin/prenotazioni/{id}/conferma', function ($id) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->conferma($id);
    })->name('admin.prenotazioni.conferma');

    Route::post('/admin/prenotazioni/{id}/annulla', function ($id) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(PrenotazioneController::class)->annulla($id);
    })->name('admin.prenotazioni.annulla');

    // Gestione servizi-extra
    Route::get('/admin/servizi-extra', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(ServizioExtraController::class)->index();
    })->name('servizi-extra');

    Route::post('/admin/servizi-extra', function (Request $request) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(ServizioExtraController::class)->store($request);
    })->name('servizi-extra.store');

    Route::get('/admin/servizi-extra/{id}/edit', function ($id) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(ServizioExtraController::class)->edit($id);
    })->name('servizi-extra.edit');

    Route::put('/admin/servizi-extra/{id}', function (Request $request, $id) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(ServizioExtraController::class)->update($request, $id);
    })->name('servizi-extra.update');

    Route::delete('/admin/servizi-extra/{id}', function ($id) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(ServizioExtraController::class)->destroy($id);
    })->name('servizi-extra.destroy');

    // Gestione camere
    Route::get('/admin/camere', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return view('pages.admin.camere');
    })->name('admin.camere');

    Route::get('/admin/camere/disponibili-oggi', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->camereDisponibiliOggi();
    })->name('admin.camere.disponibili-oggi');

    Route::post('/admin/camere', function (Request $request) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->store($request);
    })->name('admin.camere.store');

    Route::get('/admin/camere/create', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->create();
    })->name('admin.camere.create');

    Route::get('/admin/camere/eliminate', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->eliminate();
    })->name('admin.camere.eliminate');

    Route::post('/admin/camere/{id}/ripristina', function ($id) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->ripristina($id);
    })->name('admin.camere.ripristina');

    Route::get('/admin/camere/attive', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->attive();
    })->name('admin.camere.attive');

    Route::delete('/admin/camere/{camera}', function ($camera) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->destroy($camera);
    })->name('admin.camere.destroy');

    Route::get('/admin/camere/{camera}/edit', function ($camera) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->edit($camera);
    })->name('admin.camere.edit');

    Route::post('/admin/camere/{camera}/update', function (Request $request, $camera) {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return app(CameraController::class)->update($request, $camera);
    })->name('admin.camere.update');
    

});




//servono quando un utente non loggato vuole prenotare: vengono salvati i dati di sessione, fa il login/si registra come user e poi viene reindirizzato alla pagina di prenotazione; 
//in qualsiasi altro caso gli utenti dopo il login vengono reindirizzati alla rispettiva dashboard
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [PrenotazioneSessioneController::class, 'redirectAfterLogin'])->name('dashboard');
});

Route::post('/salva-prenotazione-sessione', [PrenotazioneSessioneController::class, 'salva']);



//login e logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');









