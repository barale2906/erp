<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacacione extends Model
{
    protected $fillable = [
         'usu_id', 'SalidaProgram', 'LlegadaProgram', 'Salida', 'Llegada', 'estado',
    ];


}
