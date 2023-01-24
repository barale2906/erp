<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacione extends Model
{
    protected $fillable = [
        'planilla_id', 'correspondencia_id', 'orden', 'estado',
    ];

    public function correspondencias(){

        return $this->belongsToMany('App\Correspondencia');

    }
}
