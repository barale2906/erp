<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
   protected $guarded = ['id', 'created_at', 'update_at'];

   // Relación uno a muchos.
   public function financiero()
   {
      return $this->belongsTo(Financiero::class);
   }

   // Relación muchos a muchos
   public function prestamos()
   {
      return $this->belongsToMany(Prestamo::class);
   }

   public function obligaciones()
   {
      return $this->belongsToMany(Obligacione::class); 
   }

   public function facturas()
   {
      return $this->belongsToMany(Factura::class);
   }

   // Búsquedas
   public function scopeBuscar($query, $val)
   {
      return $query
         ->where('movimiento','like','%'.$val.'%')
         ->Orwhere('id','like','%'.$val.'%')
         ->Orwhere('valor','like','%'.$val.'%')
         ->Orwhere('descripcion','like','%'.$val.'%')
         ->Orwhere('documento','like','%'.$val.'%')
         ->Orwhere('usuario','like','%'.$val.'%')
         ->Orwhere('user_id','like','%'.$val.'%')         
         ->Orwhere('created_at','like','%'.$val.'%')
      ;
   }

}
