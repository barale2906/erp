<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Diligencia extends Model
{
   protected $fillable = [
      'usuario_id', 'empresa_id', 'uen', 'centro', 'proyecto', 'fecha', 'recoge', 'entrega', 'comentarios', 'observaciones', 'guias', 'estado',
   ];

   public function empresas()
   {
      return $this->belongsTo(Empresa::class);
   }

   public function dilioperadores()
   {
      return $this->hasMany('App\Dilioperador');
   }

   public function solicito()
   {
      return $this->belongsTo('App\User');
   }

   // usuario final
   public function scopeBuscar($query, $val)
   {
      return $query
         ->where('recoge','like','%'.$val.'%')
         ->Orwhere('id','like','%'.$val.'%')
         ->Orwhere('uen','like','%'.$val.'%')
         ->Orwhere('centro','like','%'.$val.'%')
         ->Orwhere('proyecto','like','%'.$val.'%')
         ->Orwhere('entrega','like','%'.$val.'%')
         ->Orwhere('fecha','like','%'.$val.'%')
         ->Orwhere('comentarios','like','%'.$val.'%')
         ->Orwhere('observaciones','like','%'.$val.'%')
      ;
   }
}
