<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
   protected $fillable = [
      'nit', 'nombre', 'direccion', 'telefono', 'email',
      'logo', 'tipo', 'metodopago', 'contrabd', 'estado',
   ];

   public function sucursales()
   {
      return $this->hasMany('App\Sucursale');
   }

   public function areas()
   {
      return $this->hasMany('App\Area');
   }

   public function rutas()
   {
      return $this->hasMany('App\Ruta');
   }

   public function diligencias()
   {
      return $this->hasMany('App\Diligencia');
   }

   public function prepagos()
   {
      return $this->hasMany('App\Prepago');
   }


}
