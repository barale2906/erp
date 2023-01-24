<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
   protected $guarded = ['id', 'created_at', 'update_at'];

   // Relación muchos a muchos
   public function cajas()
   {
      return $this->hasMany(Caja::class);
   }
}
