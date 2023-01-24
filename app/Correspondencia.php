<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correspondencia extends Model
{
   protected $fillable = [
      'solicita', 'name', 'empresa_id', 'sucursal', 'nombresucursal', 'area', 'nombrearea', 'clase',
      'destinatario', 'nombredestinatario', 'sede', 'nombresede', 'ubicacion', 'nombreubicacion',
      'horario', 'descripcion', 'detalle', 'recepcion',
      'recibe', 'observaciones', 'planilla', 'cobrocliente', 'cobro', 'estado',
   ];

   public function users(){

      return $this->belongsToMany('App\User')->withTimesTamps();

   }


   public function clases(){

      return $this->belongsToMany('App\TipoEnvio');

   }

   public function Recorridos(){

      return $this->belongsToMany('App\Recorrido');

   }

   public function Fueras(){

      return $this->belongsToMany('App\Fuera');

   }

   public function asignaciones(){

      return $this->belongsToMany('App\Asignacione');

   }

   public function soportents(){

      return $this->hasMany('App\Soportent');

   }

   public function scopeBuscar($query, $val)
   {
   return $query
   ->where('name','like','%'.$val.'%')
   ->Orwhere('nombresucursal','like','%'.$val.'%')
   ->Orwhere('nombrearea','like','%'.$val.'%')
   ->Orwhere('nombredestinatario','like','%'.$val.'%')
   ->Orwhere('nombresede','like','%'.$val.'%')
   ->Orwhere('nombreubicacion','like','%'.$val.'%')
   ->Orwhere('horario','like','%'.$val.'%')
   ->Orwhere('descripcion','like','%'.$val.'%')
   ->Orwhere('detalle','like','%'.$val.'%')
   ->Orwhere('observaciones','like','%'.$val.'%')
   ->Orwhere('planilla','like','%'.$val.'%')
   ;

   }
}
