<?php

namespace App\Http\Livewire\Correspondencia;

use App\Correspondencia;
use App\EmpresaUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Misentregas extends Component
{
   public $fechaini;
   public $fechafin;
   public $operador;
   public $serviciocrt;

   // Seleccionar movimientos en un período
   private function seleccionados()
   {
      if(!empty($this->fechaini))
      {
         if($this->fechaini<=$this->fechafin)
         {
            $this->serviciocrt=2;
            if($this->operador == "")
            {
               $this->operador = Auth::user()->id;
            }
            return Correspondencia::join('recorridos', 'recorridos.correspondencia_id', '=', 'correspondencias.id')
                                    ->join('users', 'users.id', '=', 'recorridos.operador')
                                    ->join('empresas', 'empresas.id', '=', 'correspondencias.empresa_id')
                                    ->select(
                                       'correspondencias.nombresede', 'correspondencias.nombreubicacion',
                                       'correspondencias.detalle', 'correspondencias.descripcion',
                                       'correspondencias.id as envio', 'correspondencias.created_at',
                                       'correspondencias.observaciones','recorridos.id', 'recorridos.entregado',
                                       'users.name', 'empresas.nombre'
                                       )
                                    ->whereNotNull('recorridos.entregado')
                                    ->whereDate('correspondencias.created_at', '>=', $this->fechaini)
                                    ->whereDate('correspondencias.created_at', '<=', $this->fechafin)
                                    ->where('recorridos.operador', $this->operador)
                                    ->orderBy('correspondencias.created_at', 'ASC')
                                    ->orderBy('correspondencias.detalle', 'ASC')
                                    ->get();
         } else {
            $this->serviciocrt=1;
            session()->flash('periodo', 'Revise las fechas');
         }
      }
   }

   // muestra listado de operadores
   private function operadores()
   {
      return EmpresaUser::whereIn('role_id', [1,2,3,5])
                        ->select('user_id', 'name')
                        ->groupBy('name', 'user_id')
                        ->orderBy('name', 'ASC')
                        ->get();
   }

   public function render()
   {
      return view('livewire.correspondencia.misentregas',[
         'seleccionados'   => $this->seleccionados(),
         'operadores'      => $this->operadores(),
      ]);
   }
}
