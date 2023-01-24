<?php

namespace App\Http\Livewire\Financiero;

use App\Financiero;
use Livewire\Component;

class Financierolista extends Component
{
   // Recibir variables de otros componentes
   protected $listeners = ['recargar' => 'recargar'];

   // Recargar listado
   public function recargar()
   {
      $this->listado();
   }

   // Listado de productos
   private function listado()
   {
      return Financiero::orderBy('tipo', 'ASC')->orderBy('nombre', 'ASC')->get();
   }

   public function render()
   {
      return view('livewire.financiero.financierolista', [
         'listado'       => $this->listado(),
      ]);
   }
}
