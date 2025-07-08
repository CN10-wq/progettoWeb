<?php

//Controller per la gestione delle camere(visualizzazione, modifica, eliminazione, restore, aggiunta) 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;
use App\Models\TipoCamera;
use Carbon\Carbon;
use App\Models\Prenotazione;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\View;

class CameraController extends Controller
{
    /**
     * Display a listing of the resource. ->mostra le camere disponibili all'utente(sia loggato che non), con la possibilità di filtrarle per tipo e per disponibilità
     */
    public function index(Request $request)
    {
        $tipo = $request->input('tipo');
        $check_in_format = $this->sistemaFormatoData($request->input('arrivo'));
        $check_out_format = $this->sistemaFormatoData($request->input('partenza'));

        $camere = Camera::with(['tipo', 'immagini'])
            ->when($tipo, fn($query) => $this->filtraPerTipo($query, $tipo))
            ->when(
                $check_in_format && $check_out_format,
                fn($query) => $this->filtraPerDisponibilita($query, $check_in_format, $check_out_format)
            )
            ->get();

        $tipoCamera = $tipo ? TipoCamera::where('nome', $tipo)->first() : null;

        return view('pages.guest.camere-list')
            ->with('camere', $camere)
            ->with('tipoCamera', $tipoCamera)
            ->with('check_in', $check_in_format)
            ->with('check_out', $check_out_format);
    }

    /**
     * Show the form for creating a new resource. ->serve per mostrare dinamicamente il form di aggiunta camera (chiamata AJAX con risposta in formato AJAX)
     */
    public function create()
    {
        $tipi = TipoCamera::all(['id', 'nome']);

        $html = View::make('components.form-nuova-camera', [
            'tipi' => $tipi
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    /**
     * Store a newly created resource in storage. -> creazione da parte dell'admin di una nuova camera (che abbia un minimo di 3 immagini)
     */
    public function store(Request $request)
    {
        $request->validate([
            'titolo' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'prezzo_a_notte' => 'required|numeric|min:0',
            'tipo_camera_id' => 'required|exists:tipi_camere,id',
            'immagini' => 'required|array|min:3',
            'immagini.*' => 'image|max:2048',
            'capienza' => 'required|integer|min:1',
        ]);

        $camera = Camera::create([
            'titolo' => $request->titolo,
            'descrizione' => $request->descrizione,
            'prezzo_a_notte' => $request->prezzo_a_notte,
            'tipo_id' => $request->tipo_camera_id,
            'capienza' => $request->capienza,
        ]);

        foreach ($request->file('immagini') as $immagine) {
            $nomeFile = $immagine->hashName();
            $immagine->storeAs('immagini', $nomeFile, 'public');

            $camera->immagini()->create([
                'path' => $nomeFile
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource. ->mostra una singola camera (visibile sia ai guest che agli user)
     */
    public function show(string $id)
    {
        $camera = Camera::with(['tipo', 'immagini'])->findOrFail($id);
        $prenotazioni = $this->getDateOccupate($camera);

        return view('pages.guest.camera-details')
            ->with('camera', $camera)
            ->with('prenotazioni', $prenotazioni)
            ->with('imgs', $camera->immagini);
    }

    /**
     * Show the form for editing the specified resource. ->serve per mostrare i dati per la modifica di una camera da parte dell'admin (chiamata AJAX con risposta in formato JSON)
     */
    public function edit(string $id)
    {
        $camera = Camera::with('immagini')->findOrFail($id);
        $tipi = TipoCamera::all();

        return response()->json([
            'success' => true,
            'camera' => $camera,
            'tipi' => $tipi,
        ]);
    }

    /**
     * Update the specified resource in storage. ->serve per salvare le modifiche di una camera da parte dell'admin (con gestione anche delle immagini, minimo 3)(chiamata AJAX con risposta in formato JSON)
     */
    public function update(Request $request, string $id)
    {
        $camera = Camera::with('immagini')->findOrFail($id);

        //decodifica immagini
        if ($request->has('immagini_da_rimuovere') && is_string($request->immagini_da_rimuovere)) {
            $decoded = json_decode($request->immagini_da_rimuovere, true);
            if (is_array($decoded)) {
                $request->merge(['immagini_da_rimuovere' => $decoded]);
            }
        }

        $request->validate([
            'titolo' => 'required|string|max:255',
            'tipo_id' => 'required|exists:tipi_camere,id',
            'prezzo_a_notte' => 'required|numeric|min:0',
            'descrizione' => 'nullable|string',
            'immagini_da_rimuovere' => 'array',
            'immagini_da_rimuovere.*' => 'integer|exists:immagini_camere,id',
            'immagini_nuove.*' => 'image|max:2048',
            'capienza' => 'required|integer|min:1',
        ]);

        $camera->update($request->only([
            'titolo',
            'tipo_id',
            'prezzo_a_notte',
            'descrizione',
            'capienza'
        ]));

        //rimozione delle immagini
        $daRimuovere = $request->input('immagini_da_rimuovere', []);
        if (!empty($daRimuovere)) {
            $immaginiAttuali = $camera->immagini;

            if (($immaginiAttuali->count() - count($daRimuovere)) < 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ogni camera deve avere almeno 3 immagini.',
                ], 422);
            }

            foreach ($daRimuovere as $imgId) {
                $img = $immaginiAttuali->firstWhere('id', $imgId);
                if ($img) {
                    \Storage::disk('public')->delete('immagini/' . $img->path);
                    $img->delete();
                }
            }
        }

        //caricamento nuove immagini
        if ($request->hasFile('immagini_nuove')) {
            foreach ($request->file('immagini_nuove') as $file) {
                $nomeFile = $file->hashName();
                $file->storeAs('immagini', $nomeFile, 'public');

                $camera->immagini()->create([
                    'path' => $nomeFile,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Camera aggiornata con successo.'
        ]);
    }

    /**
     * Remove the specified resource from storage. ->serve per eliminare(soft delete) una camera da parte dell'admin (solo se ci sono almeno 4 camere attive) (chiamata AJAX con risposta in formato JSON)
     */
    public function destroy($id)
    {
        $camereAttive = Camera::whereNull('deleted_at')->count();

        if ($camereAttive <= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Devono esserci almeno un minimo di 3 camere attive.'
            ], 400);
        }

        $camera = Camera::find($id);
        if (!$camera) {
            return response()->json(['success' => false, 'message' => 'Camera non trovata.'], 404);
        }
        $camera->delete();

        return response()->json(['success' => true]);
    }

    //adatta il formato della data in anno-mese-giorno, se valida
    private function sistemaFormatoData(?string $data, string $formatoInput = 'Y-m-d'): ?string
    {
        if ($data) {
            try {
                return Carbon::createFromFormat($formatoInput, $data)->format('Y-m-d');
            } catch (\Exception $e) {
                \Log::warning('Data non valida: ' . $data);
            }
        }

        return null;
    }

    //serve per filtrare le camere a seconda del tipo
    private function filtraPerTipo($query, string $tipo)
    {
        return $query->whereHas('tipo', function ($q) use ($tipo) {
            $q->where('nome', $tipo);
        });
    }

    //serve per filtrare le camere a seconda della disponibilità in un certo periodo con condizione: data_inizio < check_out_format && data_fine > check_in_format (escludendo le prenotazioni annullate)
    private function filtraPerDisponibilita($query, string $check_in_format, string $check_out_format)
    {
        return $query->whereDoesntHave('prenotazioni', function ($q) use ($check_in_format, $check_out_format) {
            $q->where('stato_id', '!=', '1')
              ->where(function ($sub) use ($check_in_format, $check_out_format) {
                  $sub->where('data_inizio', '<', $check_out_format)
                      ->where('data_fine', '>', $check_in_format);
              });
        });
    }

    //serve per ottenere le date in cui una camera è occupata (senza contare le prenotazioni annullate)
    private function getDateOccupate(Camera $camera)
    {
        return $camera->prenotazioni()
            ->where('stato_id', '!=', '1')
            ->select('data_inizio', 'data_fine')
            ->get()
            ->map(fn($p) => [
                'from' => Carbon::parse($p->data_inizio)->format('Y-m-d'),
                'to' => Carbon::parse($p->data_fine)->format('Y-m-d'),
            ]);
    }

    //restituisce tutte le camere che non hanno prenotazioni per oggi (NON in stato annullata/attesa di conferma) (chiamata AJAX con risposta JSON)
    public function camereDisponibiliOggi()
    {
        $oggi = Carbon::today()->format('Y-m-d');

        $camereOccupateOggi = Prenotazione::where('data_inizio', '<=', $oggi)
            ->where('data_fine', '>=', $oggi)
            ->whereNotIn('stato_id', [1, 3])
            ->pluck('camera_id')
            ->toArray();

        $camere = Camera::whereNull('deleted_at')
            ->whereNotIn('id', $camereOccupateOggi)
            ->with(['immagini', 'tipo'])
            ->get()
            ->map(function ($camera) {
                return [
                    'id' => $camera->id,
                    'titolo' => $camera->titolo,
                    'prezzo' => $camera->prezzo_a_notte,
                    'descrizione' => $camera->descrizione,
                    'capienza' => $camera->capienza,
                    'tipo' => $camera->tipo?->nome,
                    'immagini' => $camera->immagini->map(fn($img) => [
                    'path' => asset('storage/immagini/' . $img->path),
                    ]),
                ];
            });

        return response()->json($camere);
    }

    //serve per recuperare tutte le camere soft deletes per l'admin (chiamata AJAX con risposta in formato JSON)
    public function eliminate()
    {
        $camere = Camera::onlyTrashed()
            ->with(['tipo', 'immagini'])
            ->get()
            ->map(function ($camera) {
                return [
                    'id' => $camera->id,
                    'titolo' => $camera->titolo,
                    'prezzo' => $camera->prezzo_a_notte,
                    'descrizione' => $camera->descrizione,
                    'capienza' => $camera->capienza,
                    'tipo_id' => $camera->tipo_id,
                    'tipo' => $camera->tipo?->nome,
                    'immagini' => $camera->immagini->map(fn($img) => [
                        'id' => $img->id,
                        'path' => asset('storage/immagini/' . $img->path),
                    ]),
                ];
            });

        $tipi = TipoCamera::select('id', 'nome')->get();

        return response()->json([
            'camere' => $camere,
            'tipi' => $tipi,
        ]);
    }

    //permette il ripristino all'admin di una camera che era stata precedentemente eliminata (soft deletes) (chiamata AJAX con risposta in formato JSON)
    public function ripristina(string $id)
    {
        $camera = Camera::withTrashed()->findOrFail($id);

        $camera->restore();

        return response()->json(['success' => true]);
    }

    //restituisce tutte le camere attive visibili all'admin (chiamata AJAX con risposta in formato JSON)
    public function attive()
    {
        $camere = Camera::with('immagini', 'tipo')
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($camera) {
                return [
                    'id' => $camera->id,
                    'titolo' => $camera->titolo,
                    'prezzo' => $camera->prezzo_a_notte,
                    'descrizione' => $camera->descrizione,
                    'capienza' => $camera->capienza,
                    'tipo_id' => $camera->tipo_id,
                    'tipo' => $camera->tipo?->nome,
                    'immagini' => $camera->immagini->map(fn($img) => [
                        'id' => $img->id,
                        'path' => asset('storage/immagini/' . $img->path),
                    ]),
                ];
            });

        $tipi = TipoCamera::select('id', 'nome')->get();

        return response()->json([
            'camere' => $camere,
            'tipi' => $tipi,
        ]);
    }
}





