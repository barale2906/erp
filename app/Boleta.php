<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
   protected $fillable = [
      'idrifa', 'comprador', 'direccion', 'email', 'telefono', 'vendedor', 'estado',
];
}
