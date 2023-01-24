<?php

namespace App\Http\Livewire\Correspondencia;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Navvueltas extends Component
{
   public function render()
   {
      return view('livewire.correspondencia.navvueltas',[
         'dilitengo' => DB::table('correspondencias')
                                       ->join('recorridos', 'recorridos.correspondencia_id', '=', 'correspondencias.id')
                                       ->where('recorridos.operador', Auth::user()->id)
                                       ->where('recorridos.estado', 1)
                                       ->count('recorridos.id'),
      ]);
   }
}
