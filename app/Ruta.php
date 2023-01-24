<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'empresa_id', 'user_id', 'estado',
    ];

    public function empresas(){
        return $this->belongsToMany('App\Empresa');
    }

    public function planillas(){
        return $this->belongsToMany('App\Planilla');
    }


}
