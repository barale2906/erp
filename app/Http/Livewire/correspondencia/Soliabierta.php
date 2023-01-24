<?php

namespace App\Http\Livewire\Correspondencia;

use App\Asignacione;
use App\Correspondencia;
use App\Recorrido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Soliabierta extends Component
{
   use WithPagination;

   public $ordena='id';
   public $ordenado='ASC';
   public $porpagina=10;
   public $buscar='';


   public function ordena($campo)
   {
      if($this->ordenado == 'ASC')
      {
         $this->ordenado = 'DESC';
      }else{
         $this->ordenado = 'ASC';
      }
      return $this->ordena = $campo;

   }

   public function cerrar($id)
   {
      Gate::authorize('haveaccess','configcorres');

      // Actualizar quien lo tiene
      $tenia = Recorrido::where('correspondencia_id', $id)
                           ->orderBy('id', 'desc')
                           ->select('id')
                           ->first();

         Recorrido::where('id', $tenia->id)
                     ->update(['estado' => '3']);


      $datos  = Correspondencia::where('id',$id)
                                 ->select('observaciones', 'planilla')
                                 ->first();
      $now = Carbon::now();
      //$now = $now->format('Y-m-d');

      $observaciones = " ---- ".$now." ".Auth::user()->name." CERRO EL ENVÍO COMO ADMINISTRADOR. ----".$datos->observaciones;

      Correspondencia::where('id',$id)
                           ->update([
                              'observaciones' => $observaciones,
                              'recepcion'     => $now,
                              'recibe'        => Auth::user()->id,
                              'estado'        => '6'
                              ]);

      // Descargar la diligencia de la planilla
      Asignacione::where('correspondencia_id', $id)
      ->where('planilla_id', $datos->planilla)
      ->update([
         'estado'=>4,
      ]);

      // Calcular tiempo de entrega
      $indienvio = DB::table('inditiempos')
                     ->where('correspondencia_id', $id)
                     ->select('fecha', 'festivos')
                     ->first();


      //Determinar los festivos
      $festivoperiodo = DB::table('festivos')
      ->whereDate('fecha', '>=', $indienvio->fecha)
      ->whereDate('fecha', '<=', $now)
      ->count('id');

      $horasfestivas = $festivoperiodo*24;

      $diferenciam = $now->diffInHours($indienvio->fecha);
      $diff = $diferenciam-$horasfestivas; // Diferencia en horas

      //Actualizar tabla
      DB::table('inditiempos')
               ->where('correspondencia_id', $id)
               ->update([
                  'recibe'    =>$now,
                  'festivos'  =>$festivoperiodo,
                  'diferencia'=>$diff,
               ]);



      //Verificar cierre de la planilla
      $todas = Asignacione::where('planilla_id', $datos->planilla)->count();
      $entregadas = Asignacione::where('planilla_id', $datos->planilla)->where('estado', '>=', 3)->count();

      //Enviar mensaje de confirmación
      session()->flash('message','Se registro el CIERRE POR ADMINISTRADOR de la diligencia: '.$id);
   }

   // Esta funcion actualiza el numero de paginas cuando se hace una busqueda.
   public function updatingbuscar()
   {
      $this->resetPage();
   }


   public function render()
   {
      return view('livewire.correspondencia.soliabierta',[
         'abiertas'  => Correspondencia::query()
                                       ->where('estado', '!=', 6)
                                       ->where('empresa_id', Auth::user()->empresa)
                                       ->Buscar($this->buscar)
                                       ->orderBy($this->ordena, $this->ordenado)
                                       ->paginate($this->porpagina),
      ]);
   }
}
