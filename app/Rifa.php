<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rifa extends Model
{
   protected $fillable = [
      'fecha', 'premio', 'boletas', 'numeros', 'responsable', 'valor', 'metodo', 'estado',
  ];
}
