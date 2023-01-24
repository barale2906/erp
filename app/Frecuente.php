<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frecuente extends Model
{
   protected $fillable = [
      'destinatario', 'sucursal', 'area', 'direccion', 'ciudad', 'horario', 'observaciones', 'estado',
   ];

   public function sucursales()
   {
      return $this->belongsTo('App\Sucursale');
   }

   public function areas()
   {
      return $this->belongsTo('App\Area');
   }

}
