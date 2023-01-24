<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursale extends Model
{
    protected $fillable = [
        'nombre', 'direccion', 'empresa_id', 'ciudad_id', 'estado',
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    public function ciudad()
    {
        return $this->belongsTo('App\Ciudade');
    }

    public function frecuentes()
    {
        return $this->hasMany('App\Frecuente');
    }

}
