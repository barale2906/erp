<?php

namespace App\Http\Livewire\Financiero;

use App\Financiero;
use Livewire\Component;

class Financierocrea extends Component
{
   public $tipo;
   public $nombre;
   public $numero;


   // limpiar campos
   public function cerrar()
   {
      $this->reset();
   }

   // Crear producto
   public function crear()
   {
      $this->validate([
         'tipo'      => 'required',
         'nombre'    => 'required',
         'numero'    => 'required',
      ]);

      $producto = Financiero::create([
         'tipo'      => $this->tipo,
         'nombre'    => $this->nombre,
         'numero'    => $this->numero,
      ]);

      // Emitir información
      session()->flash('suceso', 'Se creo correctamente el producto: '. $producto->nombre);

      // Limpiar campos
      $this->cerrar();

      // Actualizar productos
      $this->emit('recargar');

   }

   public function render()
   {
      return view('livewire.financiero.financierocrea');
   }
}
