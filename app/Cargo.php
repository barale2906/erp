<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
   protected $fillable = [
      'cargo', 'descripcion', 'tipo', 'valor', 'factor', 'producto', 'creo', 'estado',
   ];
}
