<?php

namespace App\Http\Livewire\Correspondencia;

use App\Planilla;
use Livewire\Component;

class Planilladmon extends Component
{
   public function render()
   {
      return view('livewire.correspondencia.planilladmon', [

         'planillas' => Planilla::where('estado', '!=', '3')
                                 ->count('id'),

      ]);
   }
}

//1 construcción, 2 recorrido, 3 cerrada
