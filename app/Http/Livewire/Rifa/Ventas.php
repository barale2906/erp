<?php

namespace App\Http\Livewire\Rifa;

use App\Rifa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Ventas extends Component
{
   public $fecha;
   public $premio;
   public $boletas;
   public $numeros;
   public $cantidadboletas;
   public $responsable;
   public $valor;
   public $totalventa;
   public $metodo;
   public $idrifa='';

   public function seleccionar($id)
   {
      $seleccion=Rifa::Where('id', $id)
                     ->first();

       // Cargar id y premio
      $this->idrifa           =$id;
      $this->fecha            =$seleccion->fecha;
      $this->premio           =$seleccion->premio;
      $this->boletas          =$seleccion->boletas;
      $this->numeros          =$seleccion->numeros;
      $this->responsable      =$seleccion->responsable;
      $this->valor            =$seleccion->valor;
      $this->metodo           =$seleccion->metodo;
      $this->rifastado        =$seleccion->estado;
   }

   public function render()
   {
      return view('livewire.rifa.ventas', [
         'rifas'     => Rifa::where('estado', 2)
                              ->select('id', 'fecha', 'premio', 'valor')
                              ->orderBy('fecha', 'ASC')
                              ->get(),

         'boletasel'    =>  DB::table('numeros')
                              ->select('idboleta', 'numero')
                              ->where('idrifa', $this->idrifa)
                              ->orderBY('idboleta')
                              ->get(),
      ]);
   }
}
