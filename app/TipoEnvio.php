<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
    protected $fillable = [
        'nombre', 'estado',
    ];

    public function correspondencias(){

        return $this->belongsToMany('App\Correspondencia');

    }
}
