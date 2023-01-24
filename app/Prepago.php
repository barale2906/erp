<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prepago extends Model
{
   protected $fillable = [
      'empresa_id', 'documento', 'documento_id', 'cantidad'
   ];

   public function empresas()
   {
      return $this->belongsTo('App\Empresa');
   }
}
