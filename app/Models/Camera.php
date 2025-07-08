<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoCamera;
use App\Models\ImmagineCamera;  
use App\Models\Prenotazione;
use Illuminate\Database\Eloquent\SoftDeletes;


class Camera extends Model
{
    use SoftDeletes;
    protected $table = 'camere';

    protected $fillable = [
        'titolo',
        'tipo_id',
        'prezzo_a_notte',
        'descrizione',
        'capienza',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoCamera::class, 'tipo_id');
    }

    public function immagini() {
        return $this->hasMany(ImmagineCamera::class, 'camera_id');
    }

    public function prenotazioni()
    {
        return $this->hasMany(Prenotazione::class, 'camera_id');
    }
}


