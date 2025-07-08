<?php

//Controller per la gestione delle prenotazioni(visualizzazione, creazione, cambio stato) sia dal punto di vista dell'admin che del cliente

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;
use App\Models\ServizioExtra;
use App\Models\Prenotazione;
use App\Models\ServizioExtraPrenotazione;
use Carbon\Carbon;
use App\Models\User;
Carbon::setLocale('it');
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
class PrenotazioneController extends Controller
{
    /**
     * Display a listing of the resource. ->mostra all'user le prenotazioni che sono in attesa di conferma o confermate nella sua area personale
     */
    public function index()
    {
        $prenotazioni = Prenotazione::with(['camera.immagini', 'serviziExtra', 'stato'])
            ->where('user_id', auth()->id())
            ->where('stato_id', '!=', 1)
            ->where('stato_id', '!=', 4)
            ->latest()
            ->get();

        $oggi = Carbon::today();

        foreach ($prenotazioni as $prenotazione) {
            $prenotazione->dataInizio = Carbon::parse($prenotazione->data_inizio);
            $prenotazione->notti = Carbon::parse($prenotazione->data_inizio)->diffInDays($prenotazione->data_fine);
            $prenotazione->totale_spesa = $prenotazione->calcolaTotale();
        }

        return view('pages.cliente.area-personale')
            ->with('prenotazioni', $prenotazioni)
            ->with('oggi', $oggi);
    }

    /**
     * Show the form for creating a new resource. ->mostra la pagina di prenotazione di una camera all'user che potrà confermare o no (mostrando la data di partenza, la data di ritorno,
     *                                             i servizi-extra da scegliere, la camera)
     */
    public function create(Request $request, String $id)
    {
        $camera = Camera::findOrFail($id);
        $check_in = $request->query('arrivo');
        $check_out = $request->query('partenza');
        $servizi = ServizioExtra::all();

        $notti = Carbon::parse($check_in)->diffInDays(Carbon::parse($check_out));
        $totale = $camera->prezzo_a_notte * $notti;

        $prezziServiziExtra = $servizi->pluck('prezzo', 'id');

        session()->forget([
            'prenotazione_camera_id',
            'prenotazione_data_inizio',
            'prenotazione_data_fine'
        ]);

        return view('pages.cliente.prenotazione')
            ->with('camera', $camera)
            ->with('data_inizio', $check_in)
            ->with('data_fine', $check_out)
            ->with('servizi_extra', $servizi)
            ->with('notti', $notti)
            ->with('totale', $totale)
            ->with('prezziServiziExtra', $prezziServiziExtra);
    }

    /**
     * Store a newly created resource in storage. -> salva la prenotazione di un utente avvenuta con successo con le diverse informazioni
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'camera_id' => 'required|exists:camere,id',
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date|after_or_equal:data_inizio',
            'richieste' => 'nullable|string',
            'numero_persone' => 'required|integer|min:1',
            'prezzo_totale_camera' => 'required|numeric|min:0',
            'servizi_extra' => 'array',
            'servizi_extra.*.quantita' => 'nullable|integer|min:1',
            'servizi_extra.*.prezzo_unitario' => 'nullable|numeric|min:0',
        ]);

        $prenotazione = Prenotazione::create([
            'user_id' => auth()->id(),
            'camera_id' => $validated['camera_id'],
            'data_inizio' => $validated['data_inizio'],
            'data_fine' => $validated['data_fine'],
            'eventuali_richieste_cliente' => $validated['richieste'] ?? null,
            'numero_persone' => $validated['numero_persone'],
            'prezzo_totale_camera' => $validated['prezzo_totale_camera'],
        ]);

        //aggiunta dei servizi-extra solo se selezionati correttamente nella check-box
        if ($request->has('servizi_extra')) {
            foreach ($request->input('servizi_extra') as $servizioId => $dati) {
                if (isset($dati['attivo']) && $dati['attivo'] == '1' && !empty($dati['quantita'])) {
                    ServizioExtraPrenotazione::create([
                        'prenotazione_id' => $prenotazione->id,
                        'servizio_extra_id' => $servizioId,
                        'quantita' => $dati['quantita'],
                        'prezzo_unitario' => $dati['prezzo_unitario'] ?? 0,
                    ]);
                }
            }
        }

        return view('pages.cliente.successo')->with('success', 'Prenotazione effettuata con successo! ');
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
     * Remove the specified resource from storage. ->serve per annullare una prenotazione da parte dell'user-cliente
     */
    public function destroy(string $id)
    {
        $prenotazione = Prenotazione::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $prenotazione->stato_id = 1;
        $prenotazione->save();

        return redirect()->back()->with('success', 'Prenotazione annullata con successo!');
    }

    //mostra le prenotazioni che sono in attesa di conferma da parte dell'admin (chiamata AJAX con risposta in formato JSON)
    public function prenotazioniAttesa()
    {
        $prenotazioni = Prenotazione::with(['user', 'camera', 'stato', 'serviziExtra'])
            ->where('stato_id', 3)
            ->orderBy('data_inizio')
            ->get();

        $prenotazioni->each(function ($p) {
            $p->totale_spesa = $p->calcolaTotale();
        });

        return response()->json($prenotazioni);
    }

    //serve per far passare una prenotazione da in attesa di conferma a confermata da parte dell'admin (chiamata AJAX con risposta in formato JSON)
    public function conferma(string $id)
    {
        $prenotazione = Prenotazione::find($id);

        if (!$prenotazione) {
            return response()->json(['success' => false, 'message' => 'Prenotazione non trovata.'], 404);
        }

        $prenotazione->stato_id = 2;
        $prenotazione->save();

        return response()->json(['success' => true]);
    }

     //serve per far passare una prenotazione da in attesa di conferma ad annullata da parte dell'admin (chiamata AJAX con risposta in formato JSON)
    public function annulla(string $id)
    {
        $prenotazione = Prenotazione::find($id);

        if (!$prenotazione) {
            return response()->json(['success' => false, 'message' => 'Prenotazione non trovata.'], 404);
        }

        $prenotazione->stato_id = 1;
        $prenotazione->save();

        return response()->json(['success' => true]);
    }

    //mostra le prenotazioni che sono attive nella data odierna in stato confermata/effettuata all'admin (chiamata AJAX con risposta in formato JSON)
    public function prenotazioniOggi()
    {
        $oggi = Carbon::today();

        $prenotazioni = Prenotazione::with(['user', 'camera', 'stato', 'serviziExtra'])
            ->whereIn('stato_id', [2, 4])
            ->whereDate('data_inizio', '<=', $oggi)
            ->whereDate('data_fine', '>', $oggi)
            ->orderBy('data_inizio')
            ->get();

        $prenotazioni->each(function ($p) {
            $p->totale_spesa = $p->calcolaTotale();
        });

        return response()->json($prenotazioni);
    }

    //serve per gestire un archivio delle prenotazioni sia per il cliente che per l'admin, con possibilità di filtrare a secondo dello stato della prenotazione
    private function getArchivioPrenotazioni(?User $utente = null, ?int $statoId = null)
    {
        $query = Prenotazione::with(['user', 'camera.immagini', 'stato', 'serviziExtra'])
            ->orderByDesc('data_inizio');

        if ($utente) {
            $query->where('user_id', $utente->id);
        }

        if (!is_null($statoId) && $statoId !== 'tutte') {
            $query->where('stato_id', (int) $statoId);
        }

        $prenotazioni = $query->get();

        $prenotazioni->each(function ($p) {
            $p->totale_spesa = $p->calcolaTotale();
        });

        return $prenotazioni;
    }

    //archivio di tutte le prenotazioni visualizzabile dall'admin (può anche filtrarle per stato) (chiamata AJAX con risposta in formato JSON)
    public function archivio(Request $request)
    {
        $statoId = $this->parseStatoId($request->input('stato_id'));
        $prenotazioni = $this->getArchivioPrenotazioni(null, $statoId);

        return response()->json($prenotazioni);
    }

    //archivio di tutte le prenotazioni personali visualizzabile dall'user (può anche filtrarle per stato) (chiamata AJAX con risposta in formato JSON)
    public function archivioCliente(Request $request)
    {
        $utente = auth()->user();
        $statoId = $this->parseStatoId($request->input('stato_id'));
        $labelFiltro = $request->input('label'); 

        $prenotazioni = $this->getArchivioPrenotazioni($utente, $statoId);

        if ($prenotazioni->isEmpty()) {
            return response()->json([
                'html' => '',
                'vuoto' => true,
                'label' => Str::lower($labelFiltro ?? '')
            ]);
        }

        $html = '';
        foreach ($prenotazioni as $prenotazione) {
            $html .= View::make('components.card-prenotazione-archivio', [
                'prenotazione' => $prenotazione
            ])->render();
        }

        return response()->json(['html' => $html]);
    }

    //trasforma lo stato in un intero, se numerico
    private function parseStatoId($statoId): ?int
    {
        return is_numeric($statoId) ? (int) $statoId : null;
    }
}

