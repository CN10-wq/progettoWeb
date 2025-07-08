<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServizioExtraPrenotazione extends Model
{
    protected $table = 'servizi_extra_prenotazioni';

    protected $fillable = [
        'prenotazione_id',
        'servizio_extra_id',
        'quantita',
        'prezzo_unitario',
    ];
}
