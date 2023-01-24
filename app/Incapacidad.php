<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incapacidad extends Model
{
    protected $fillable = [
        'usu_id', 'motivo', 'inicia', 'finaliza', 'valor', 'paga', 'fechaPago', 'observacion', 'estado',
   ];
}

