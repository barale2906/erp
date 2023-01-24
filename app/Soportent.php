<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soportent extends Model
{
    protected $fillable = [
        'correspondencia_id', 'usuario', 'ruta',
    ];

    public function correspondencias(){

        return $this->belongsToMany('App\Correspondencia');

    }
}
