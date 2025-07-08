<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Prenotazione extends Model
{
    protected $table = 'prenotazioni';

    protected $fillable = [
        'user_id',
        'camera_id',
        'stato_id',
        'data_inizio',
        'data_fine',
        'ora_check_in',
        'ora_check_out',
        'eventuali_richieste_cliente',
        'prezzo_totale_camera',
        'numero_persone',
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

        public function camera()
    {
        return $this->belongsTo(Camera::class, 'camera_id')->withTrashed();
    }

        public function stato()
    {
        return $this->belongsTo(Stato::class, 'stato_id');
    }

        public function serviziExtra()
    {
        return $this->belongsToMany(ServizioExtra::class, 'servizi_extra_prenotazioni', 'prenotazione_id', 'servizio_extra_id')
                    ->withPivot('quantita', 'prezzo_unitario')
                    ->withTimestamps()
                    ->withTrashed();
    }

        public function calcolaTotale(): float
    {
        $totaleCamera = $this->prezzo_totale_camera ?? 0;

        $totaleServizi = $this->serviziExtra->sum(function ($servizio) {
            return $servizio->pivot->quantita * $servizio->pivot->prezzo_unitario;
        });

        return $totaleCamera + $totaleServizi;
    }


}

