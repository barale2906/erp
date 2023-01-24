<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuera extends Model
{
    protected $fillable = [
        'guia', 'transportadora_id', 'correspondencia_id', 'envio', 'empresa', 'estado',
    ];

    public function correspondencias(){

        return $this->belongsToMany('App\Correspondencia');

    }

    public function transportadoras(){

        return $this->belongsToMany('App\Transportadora');

    }
}
