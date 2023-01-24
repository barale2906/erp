<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salario extends Model
{
    protected $fillable = [
        'user_id', 'salario', 'rodamiento', 'bono', 'comision', 'estado',
    ];

    public function user()
    {
        return $this->belongsto('App\User');
    }
}
