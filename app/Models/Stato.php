<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stato extends Model
{
    protected $table = 'stati';

    protected $fillable = [
        'nome',
    ];

    public function prenotazioni()
{
    return $this->hasMany(Prenotazione::class, 'stato_id');
}


}

