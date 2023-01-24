<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dilioperador extends Model
{
   protected $fillable = [
      'usuario_id', 'diligencia_id', 'estado',
   ];

   public function diligencia()
   {
      return $this->belongsTo('App\Diligencia');
   }

   public function operador()
   {
      return $this->belongsTo('App\User');
   }
}
