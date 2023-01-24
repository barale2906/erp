<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lp extends Model
{
   protected $fillable = [
      'lista', 'inicio', 'fin', 'creo', 'estado',
   ];


}
