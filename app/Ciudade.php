<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudade extends Model
{

    protected $fillable = [
        'ciudad', 'departamento',
    ];

    public function sucursales()
    {
        return $this->hasMany('App\Sucursale');
    }
}
