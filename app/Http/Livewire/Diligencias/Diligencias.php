<?php

namespace App\Http\Livewire\Diligencias;

use App\Diligencia;
use App\EmpresaUser;
use App\Prepago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Diligencias extends Component
{
   public $accion;
   public $diligenciaid;
   public $imag;
   public $control=0;


   // Recibir variables de otros componentes
   protected $listeners = ['recargar' => 'recargar'];

   // Recargar listado
   public function recargar()
   {
      $this->listado();
   }

   // listar solicitudes
   private function listado()
   {
      return Diligencia::where('empresa_id', Auth::user()->empresa)
                        ->where('estado', '<=', 4)
                        ->orderBy('id', 'DESC')
                        ->get();
   }

   // identificar Si tiene guías prepagadas.
   private function prepa()
   {
      $usa = Prepago::where('empresa_id', Auth::user()->empresa)
                     ->count();

      if($usa>=1){
         return Prepago::where('empresa_id', Auth::user()->empresa)
                  ->sum('cantidad');
      }


   }

   // Imagenes de cada envío
   private function imagenesta()
   {
      if($this->imag)
      {
         $imagenes = DB::table('dilifoto')
                        ->where('diligencia_id', $this->imag)
                        ->get();

         if($imagenes->count()){
            $this->control=1;
            return $imagenes;
         }
      }
   }

   // Ver imagenes
   public function imagenes($id)
   {
      $this->reset();
      $this->imag = $id;
   }

    // Cerrar el modal
   public function cancelar()
   {
      $this->reset();
   }

   //modal Cierra solicitud
   public function cierra($id)
   {
      //dd($diligencia);
      $this->accion = 1;
      $this->diligenciaid = $id;
   }

   //Cierra Solicitud
   public function cierrasol()
   {
      $now = Carbon::now();
      $diligen = Diligencia::where('id', $this->diligenciaid)->select('observaciones')->first();
      $observa = "---".$now." ".Auth::user()->name." Cerro la diligencia"."--".$diligen->observaciones;

      Diligencia::where('id', $this->diligenciaid)
                  ->update([
                     'observaciones'   => $observa,
                     'estado'          => 6,
                  ]);
                  session()->flash('messagecierre', 'Se cerro satisfactoriamente la diligencia');
                  $this->reset();

   }

   //modal Elimina solicitud
   public function elimina($id)
   {
      $this->accion = 2;
      $this->diligenciaid = $id;
   }

   // Elimina solicitud
   public function elimsol()
   {
      Diligencia::where('id', $this->diligenciaid)
                  ->delete();
                  session()->flash('messagecierre', 'Se ELIMINO la diligencia');
                  $this->reset();
   }

   //
   public function render()
   {
      return view('livewire.diligencias.diligencias', [
         'listado'       => $this->listado(),
         'prepa'         => $this->prepa(),
         'imagenesta'    => $this->imagenesta(),
      ]);
   }
}
