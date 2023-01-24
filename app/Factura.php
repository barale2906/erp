<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
   protected $fillable = [
      'genero', 'numero', 'cliente_id', 'sucursal_id', 'valor', 'impuesto', 'fecha', 'fechavence', 'obserevacionesfactura',
      'fechapago', 'valorpagado', 'obserevacionespago', 'estado',
   ];

   // Relación muchos a muchos
   public function cajas()
   {
      return $this->belongsToMany(Caja::class);
   }
}
