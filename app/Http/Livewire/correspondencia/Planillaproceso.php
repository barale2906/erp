<?php

namespace App\Http\Livewire\Correspondencia;

use App\Empresa;
use App\Planilla;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Planillaproceso extends Component
{
   public $empr=[];

   use WithPagination;

   public function editar($id)
   {
      $this->emit('edita', $id);
   }

   public function render()
   {
      return view('livewire.correspondencia.planillaproceso', [

         'empresas' => Empresa::where('estado', 1)
                                             ->select('id', 'nombre')
                                             ->orderBy('nombre', 'ASC')
                                             ->get(),
         'planillas' => DB::table('empresas')
                                             ->join('planillas', 'planillas.empresa_id', '=', 'empresas.id')
                                             ->join('rutas', 'rutas.id', '=', 'planillas.ruta_id')
                                             ->join('users', 'users.id', '=', 'planillas.operador')
                                             //->where('planillas.estado', '!=', 3)
                                             ->whereIn('planillas.empresa_id', $this->empr)
                                             ->select('planillas.id', 'planillas.fecha', 'planillas.observaciones',
                                                      'planillas.estado', 'rutas.nombre as ruta', 'users.name', 'empresas.nombre')
                                             ->orderBy('planillas.fecha', 'DESC')
                                             ->orderBy('users.name', 'ASC')
                                             ->paginate(10),
      ]);
   }
}
//1 construcción, 2 recorrido, 3 cerrada
