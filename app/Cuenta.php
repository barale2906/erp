<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
   protected $fillable = [
      'genero', 'operador_id', 'numero', 'valor', 'fecha', 'observaciones', 'fechapago',
      'valorpagado', 'observacionespago', 'estado',
   ];
}
