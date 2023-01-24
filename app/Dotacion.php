<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dotacion extends Model
{
   protected $fillable = [
      'elemento', 'descripcion', 'estado',
   ];

   public function dotaentregas()
   {
      return $this->hasMany('App\Dotaentrega');
   }

}
