<?php

namespace App\Http\Livewire\Facturacion;

use App\Producto;
use Livewire\Component;

class Productos extends Component
{
   public $producto;
   public $descripcion;
   public $tipo;

   public function submit()
   {
      $this->validate([
         "producto"     => 'required',
         "descripcion"  => 'required',
         "tipo"         => 'required',

      ]);


      Producto::create([
         "producto"      => $this->producto,
         "descripcion"   => $this->descripcion,
         "tipo"          => $this->tipo,
      ]);


      session()->flash('message', $this->producto.' fue creado correctamente.');

      $this->producto      ="";
      $this->descripcion   ="";
      $this->tipo          ="";

   }

   public function render()
   {
      return view('livewire.facturacion.productos',[
         'productos' => Producto::where('estado', 1)
                                 ->orderbY('producto', 'ASC')
                                 ->get(),
      ]);
   }
}
