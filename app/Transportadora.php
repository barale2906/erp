<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportadora extends Model
{
    protected $fillable = [
        'nombre', 'contacto', 'direccion', 'telefono', 'email', 'empresa', 'estado',
    ];

    public function fueras(){

        return $this->hasMany('App\Fuera');

    }
}

