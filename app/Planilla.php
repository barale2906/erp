<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $fillable = [
        'fecha', 'empresa_id', 'ruta_id', 'operador', 'asigno', 'observaciones', 'estado',
    ];

    public function rutas(){
        return $this->belongsToMany('App\Ruta');
    }
}
