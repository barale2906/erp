<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
   protected $fillable = [
      'producto', 'descripcion', 'tipo', 'estado',
   ];

}
