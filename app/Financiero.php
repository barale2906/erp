<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financiero extends Model
{
   protected $guarded = ['id', 'created_at', 'update_at'];

   // Relación uno a muchos
   public function cajas()
   {
      return $this->hasMany(Caja::class);
   }
}
