<?php

namespace App\Http\Livewire\Correspondencia;

use App\Asignacione;
use App\Correspondencia;
use App\Planilla;
use App\Recorrido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Misplanillas extends Component
{
   public $mostrar;
   public $detalle;

   public function mostrar()
   {
      $this->mostrar = 1;

   }

   public function ocultar()
   {
      $this->mostrar = '';

   }

   public function detalle($id)
   {
      $this->detalle = $id;
   }
   public function recibir($id)
   {
      // Actualizar quien lo tiene
      $tenia = Recorrido::where('correspondencia_id', $id)
                           ->orderBy('id', 'desc')
                           ->select('id')
                           ->first();
      if(!empty($tenia)){
         Recorrido::where('id', $tenia->id)
                     ->update(['estado' => '3']);
      }

         Recorrido::create([
                     "correspondencia_id"    => $id,
                     "operador"              => Auth::user()->id,

      ]);
               // Actualizar observaciones
      $datos  = Correspondencia::where('id', $id)
                                 ->select('observaciones', 'planilla')
                                 ->first();
      $now = Carbon::now();
      //$now = $now->format('Y-m-d');

      $observaciones = " ---- ".$now." ".Auth::user()->name.", recogio el envío. ---- ".$datos->observaciones;

      Correspondencia::where('id', $id)
                           ->update([
                              'estado' => '5',
                              'observaciones' => $observaciones
                              ]);

      // ACtualizar estado en asignaciones
      Asignacione::where('correspondencia_id', $id)
                           ->where('planilla_id', $datos->planilla)
                           ->update([
                              'estado' => '2',
                              ]);

      // Actualizar estado planilla
      $estadoplanilla = Asignacione::where('planilla_id', $datos->planilla)
                           ->where('estado', 1)
                           ->count('estado');
      if($estadoplanilla==0){
         Planilla::where('id', $datos->planilla)
         ->update([
               'estado' => '2',
               ]);

         session()->flash('message', 'La planilla: '.$datos->planilla.' fue recibida correctamente.');
      }


   }

   public function imprimir($id)
   {
      $this->emit('edita', $id);
   }

   public function render()
   {
      return view('livewire.correspondencia.misplanillas', [
         'misplanillas' => DB::table('planillas')
                                       ->join('empresas', 'empresas.id', '=', 'planillas.empresa_id')
                                       ->where('planillas.operador', Auth::user()->id)
                                       ->where('planillas.estado', 1)
                                       ->select('planillas.fecha', 'planillas.observaciones', 'planillas.id', 'empresas.nombre')
                                       ->get(),
         'planimprimir' => DB::table('planillas')
                                       ->join('empresas', 'empresas.id', '=', 'planillas.empresa_id')
                                       ->where('planillas.operador', Auth::user()->id)
                                       ->where('planillas.estado', 2)
                                       ->select('planillas.id', 'planillas.fecha', 'empresas.nombre')
                                       ->orderBy('planillas.id', 'ASC')
                                       ->get(),
         'detalles' => DB::table('correspondencias')
                                       ->join('asignaciones', 'asignaciones.correspondencia_id', 'correspondencias.id')
                                       ->where('correspondencias.planilla', $this->detalle)
                                       ->where('asignaciones.estado', 1)
                                       ->select('correspondencias.id',
                                          'correspondencias.nombredestinatario',
                                          'correspondencias.nombresede',
                                          'correspondencias.nombreubicacion')
                                       ->orderBy('correspondencias.id', 'ASC')
                                       ->get(),
         'detallenca' => Planilla::find($this->detalle),
         'mostrar' => $this->mostrar,

      ]);
   }
}

//1 construcción, 2 recorrido, 3 No entregado 4 cerrada ASIGNACIONES
//1 construcción, 2 recorrido, 3 cerrada PLANILLAS
