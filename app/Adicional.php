<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $fillable = [
        'user_id', 'direccion', 'telefono', 'eps', 'pension', 'cesantia', 'conductor', 'contrato',
        'ingreso', 'egreso', 'nacimiento', 'sanguineo', 'runt', 'estado',
    ];

    public function user()
    {
        return $this->belongsto('App\User');
    }
}
