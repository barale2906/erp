<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dotaentrega extends Model
{
    protected $fillable = [
        'elemento_id', 'user_id', 'talla', 'cantidad', 'fechaEntrega', 'carta', 'valor', 'estado',
    ];

    public function dotacion()
    {
        return $this->belongsTo('App\Dotacion');
    }
}


