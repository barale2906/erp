<?php

namespace App\Http\Livewire\Diligencias;

use App\Dilioperador;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Mensajero extends Component
{
   public $cantidad=0;

   // Diligencias asignadas a este operador
   private function diligencias()
   {
      $cuantas = Dilioperador::where('usuario_id', Auth::user()->id)
                              ->where('estado', 1)
                              ->count();

      if($cuantas>0)
      {
         $this->cantidad = $cuantas;
      }
   }

   public function render()
   {
      return view('livewire.diligencias.mensajero', [
         'diligencias'        => $this->diligencias(),
      ]);
   }
}
