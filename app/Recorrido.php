<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recorrido extends Model
{
    protected $fillable = [
        'correspondencia_id', 'operador', 'estado',
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function correspondencias(){
        return $this->belongsToMany('App\Correspondencia');
    }
}
