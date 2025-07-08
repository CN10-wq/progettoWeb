<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServizioExtra extends Model
{
    use SoftDeletes;
    protected $table = 'servizi_extra'; 
    protected $fillable = [
        'nome',
        'descrizione',
        'prezzo',
        'prezzo_unita',
    ];

    public function prenotazioni()
    {
        return $this->belongsToMany(Prenotazione::class, 'servizi_extra_prenotazioni', 'servizio_extra_id', 'prenotazione_id')
                    ->withPivot('quantita', 'prezzo_unitario')
                    ->withTimestamps();
    }
    
}
