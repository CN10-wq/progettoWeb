<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Camera;

class ImmagineCamera extends Model
{
    protected $table = 'immagini_camere';

    protected $fillable = [
        'camera_id',
        'path',
        'descrizione',
    ];

    public function camera()
    {
        return $this->belongsTo(Camera::class, 'camera_id')->withTrashed();
    }
}

