<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Camera;

class TipoCamera extends Model
{
    protected $table = 'tipi_camere';

    protected $fillable = ['nome', 'descrizione'];

    public function camere()
    {
        return $this->hasMany(Camera::class, 'tipo_id');
    }
}
