<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obligacione extends Model
{
   protected $guarded = ['id', 'created_at', 'update_at'];

   // Relación muchos a muchos
   public function cajas()
   {
      return $this->hasMany(Caja::class);
   }

   // Buscar obligaciones
   public function scopeBuscar($query, $val)
   {
      return $query
         ->where('nombre','like','%'.$val.'%')
         ->Orwhere('id','like','%'.$val.'%')
         ->Orwhere('identificacion','like','%'.$val.'%')
         ->Orwhere('banco','like','%'.$val.'%')
         ->Orwhere('cuenta','like','%'.$val.'%')
         ->Orwhere('tipocuenta','like','%'.$val.'%')
         ->Orwhere('tipo','like','%'.$val.'%')
         ->Orwhere('numerotipo','like','%'.$val.'%')
         ->Orwhere('fecha','like','%'.$val.'%')
         ->Orwhere('pago','like','%'.$val.'%')
         ->Orwhere('observaciones','like','%'.$val.'%')
      ;
   }
}
