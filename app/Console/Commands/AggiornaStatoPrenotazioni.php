<?php

//serve per aggiornare automaticamente lo stato delle prenotazioni in base alla data corrente (tramite command php artisan aggiornamento-stato-prenotazioni)

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prenotazione;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AggiornaStatoPrenotazioni extends Command
{
    protected $signature = 'aggiornamento-stato-prenotazioni';

    protected $description = 'Aggiorna automaticamente lo stato delle prenotazioni in base alla data corrente';

    public function handle()
    {
        $oggi = Carbon::today();

        $prenotazioniConfermate = Prenotazione::where('stato_id', 2)
            ->where('data_inizio', '<', $oggi)
            ->get();

        $prenotazioniInAttesa = Prenotazione::where('stato_id', 3)
            ->where('data_inizio', '<=', $oggi)
            ->whereDate('created_at', '<', $oggi)
            ->get();

        //aggiorna tutte le prenotazioni confermate ad effettuate al giorno successivo della data di arrivo
        foreach ($prenotazioniConfermate as $prenotazione) {
            $prenotazione->stato_id = 4;
            $prenotazione->save();
        }

        //aggiorna tutte le prenotazioni in attesa di conferma ad annullate la cui data di arrivo è oggi o precedente (ad eccezione delle prenotazioni in attesa create lo stesso giorno della data di arrivo)
        foreach ($prenotazioniInAttesa as $prenotazione) {
            $prenotazione->stato_id = 1;
            $prenotazione->save();
        }
    }
}
