<?php

namespace App\Http\Livewire\Correspondencia;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Navplanilla extends Component
{
   public function render()
   {
      return view('livewire.correspondencia.navplanilla', [
         'misplanillas' => DB::table('planillas')
                                       ->join('empresas', 'empresas.id', '=', 'planillas.empresa_id')
                                       ->where('planillas.operador', Auth::user()->id)
                                       ->where('planillas.estado', 1)
                                       ->select('planillas.fecha', 'planillas.observaciones', 'planillas.id', 'empresas.nombre')
                                       ->get(),
      ]);
   }
}
