<?php

namespace App\Http\Livewire\Facturacion;

use App\Empresa;
use App\Prepago;
use Livewire\Component;

class Prepasigna extends Component
{
   public $clienteid;
   public $facturaid;
   public $cantidad;

   // Seleccionar cliente
   private function clientes()
   {
      return Empresa::where('estado', 1)
                     ->select('id', 'nombre')
                     ->orderBy('nombre', 'ASC')
                     ->get();
   }
   // Asigna guías
   public function asignar()
   {
      Prepago::create([
         'empresa_id'   => $this->clienteid,
         'documento'    => 'factura',
         'documento_id' => $this->facturaid,
         'cantidad'     => $this->cantidad,
      ]);

      $this->reset();
      session()->flash('messagelim', 'Se asignarón correctamente las guías' );
   }

   // Cerrar modal
   public function cerrar()
   {
      $this->reset();
   }

   public function render()
   {
      return view('livewire.facturacion.prepasigna', [
         'clientes'        => $this->clientes(),
      ]);
   }
}
