<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    protected $fillable = [
        'user_id', 'documento', 'ruta', 'expedicion', 'vencimiento', 'carga', 'usucarga', 'estado',
    ];

    public function user()
    {
        return $this->belongsto('App\User');
    }
}
