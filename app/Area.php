<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'area', 'empresa_id', 'estado',
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    public function frecuentes()
    {
        return $this->hasMany('App\Frecuente');
    }

}
