<?php

namespace App\Http\Livewire\Correspondencia;

use App\Asignacione;
use App\Correspondencia;
use App\Planilla;
use App\Recorrido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Planillafinal extends Component
{
   public $idplanilla;
   public $idenvio;
   public $operador;
   public $nueplani;

   protected $listeners = ['edita'];

   public function edita($id)
   {
      $this->idplanilla = $id;

   }

   private function envios()
   {
      return DB::table('correspondencias')
               ->join('asignaciones', 'asignaciones.correspondencia_id', '=', 'correspondencias.id')
               ->where('asignaciones.planilla_id', $this->idplanilla)
               //->where('correspondencias.planilla', $this->idplanilla)
               //->where('asignaciones.estado', '<=', 2)
               ->select('correspondencias.id', 'correspondencias.nombredestinatario',
                        'correspondencias.nombresede', 'correspondencias.nombreubicacion', 'correspondencias.descripcion',
                        'correspondencias.observaciones', 'correspondencias.cobro',
                        'correspondencias.cobrocliente', 'asignaciones.estado as control')
               ->orderBy('correspondencias.id', 'ASC')
               ->get();
   }

   private function planillabier()
   {
      if($this->idplanilla!=""){
         $planiactiva = Planilla::where('id', $this->idplanilla)
                              ->select('estado')
                              ->first();

         if($planiactiva->estado<3){
            return Planilla::where('empresa_id', Auth::user()->empresa)
                                             ->where('estado', '<=', 2)
                                             ->select('id')
                                             ->orderby('id', 'ASC')
                                             ->get();
         }
      }
   }

   public function imagen($id)
   {
      $this->idenvio = $id;
   }

   public function recibir($id)
   {
      Gate::authorize('haveaccess','corres.edit');

      // Actualizar quien lo tiene
      $tenia = Recorrido::where('correspondencia_id', $id)
                           ->orderBy('id', 'desc')
                           ->select('id')
                           ->first();
      if(!empty($tenia)){
         Recorrido::where('id', $tenia->id)
                     ->update(['estado' => '3']);
      } else {

         Recorrido::create([
            'correspondencia_id' =>$id,
            'operador'           =>Auth::user()->id,
            ]);
      }

      $datos  = Correspondencia::where('id',$id)
                                 ->select('observaciones', 'planilla')
                                 ->first();
      $now = Carbon::now();
      //$now = $now->format('Y-m-d');

      $observaciones = " ---- ".$now." ".Auth::user()->name.", recibio el envío. ---- ".$datos->observaciones;

      Correspondencia::where('id',$id)
                           ->update([
                              'observaciones' => $observaciones
                              ]);

      // Descargar la diligencia de la planilla
      Asignacione::where('correspondencia_id', $id)
      ->where('planilla_id', $datos->planilla)
      ->update([
         'estado'=>4,
      ]);



      //Verificar cierre de la planilla
      $todas = Asignacione::where('planilla_id', $datos->planilla)->count();
      $entregadas = Asignacione::where('planilla_id', $datos->planilla)->where('estado', '>=', 3)->count();

      if($todas==$entregadas)
      {
         Planilla::where('id', $datos->planilla)
                  ->update([
                     'estado' => 3,
                  ]);

         //Enviar mensaje de confirmación
      session()->flash('cierre','Fue cerrada en la planilla N°: '.$datos->planilla);
      }

      //Enviar mensaje de confirmación
      session()->flash('message','Le fue registrada a su nombre la diligencia: '.$id.' y fue cerrada en la planilla: '.$datos->planilla);
   }

   public function cerrar($id)
   {
      Gate::authorize('haveaccess','corres.edit');

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

      $observaciones = " ---- ".$now." ".Auth::user()->name." CERRO EL ENVÍO. ----".$datos->observaciones;

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

      if($todas==$entregadas)
      {
         Planilla::where('id', $datos->planilla)
                  ->update([
                     'estado' => 3,
                  ]);

         //Enviar mensaje de confirmación
      session()->flash('cierre','Fue cerrada en la planilla N°: '.$datos->planilla);
      }

      //Enviar mensaje de confirmación
      session()->flash('message','Se registro el CIERRE de la diligencia: '.$id.' y fue cerrada en la planilla: '.$datos->planilla);
   }

   public function devolver($id)
   {
      Gate::authorize('haveaccess','corres.edit');

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
                  'correspondencia_id' =>$id,
                  'operador'           =>Auth::user()->id,

      ]);

      $datos  = Correspondencia::where('id',$id)
                                 ->first();
      $now = Carbon::now();
      //$now = $now->format('Y-m-d');

      $observaciones = " ---- ".$now." ".Auth::user()->name.", recibio el envío para enrutarlo de nuevo. ---- ".$datos->observaciones;

      Correspondencia::where('id',$id)
                           ->update([
                              'observaciones'   => $observaciones,
                              'planilla'        => NULL,
                              'estado'          => 5,
                              ]);

       // Descargar la diligencia de la planilla
      Asignacione::where('correspondencia_id', $id)
      ->where('planilla_id', $datos->planilla)
      ->update([
         'estado'=>3,
      ]);


      //Verificar cierre de la planilla
      $todas = Asignacione::where('planilla_id', $datos->planilla)->count();
      $entregadas = Asignacione::where('planilla_id', $datos->planilla)->where('estado', '>=', 3)->count();

      if($todas==$entregadas)
      {
         Planilla::where('id', $datos->planilla)
                  ->update([
                     'estado' => 3,
                  ]);

         //Enviar mensaje de confirmación
      session()->flash('cierre','Fue cerrada en la planilla N°: '.$datos->planilla);
      }

      //Enviar mensaje de confirmación
      session()->flash('message','Le fue registrada a su nombre la diligencia: '.$id.' y fue cerrada en la planilla: '.$datos->planilla);
   }

   public function cambiaopera()
   {
      $planilla=Planilla::where('id', $this->idplanilla)
                        ->select('observaciones')
                        ->first();

      $now = Carbon::now();

      $observaciones = " ---- ".$now." ".Auth::user()->name.", Reasigno la planilla. ---- ".$planilla->observaciones;

         //Actualizar operador en la planilla
         Planilla::where('id', $this->idplanilla)
                  ->update([
                     'operador'        =>$this->operador,
                     'observaciones'   => $observaciones,
                     'estado'          =>1,
                  ]);

         //Liberar las diligencias
         Asignacione::where('planilla_id', $this->idplanilla)
                     ->update([
                        'estado' =>1,
                     ]);

         session()->flash('message', 'La planilla: '.$this->idplanilla.' fue reasignada correctamente.');

         $this->operador='';

   }

   public function cambiaplani($id)
   {
      $estadoid = Asignacione::where('correspondencia_id', $id)
                              ->where('planilla_id', $this->idplanilla)
                              ->select('estado')
                              ->first();

      if($estadoid->estado<3){

         $planillactual=Planilla::where('id', $this->idplanilla)
         ->select('observaciones')
         ->first();

         $planillacambia=Planilla::where('id', $this->nueplani)
                  ->select('observaciones')
                  ->first();
         // REgistrar cambio en las planillas
         $now = Carbon::now();

         $observactual = " ---- ".$now." ".Auth::user()->name.", Retiro de esta planilla la diligencia N°: "
                  .$id." hacia la planilla: ".$this->nueplani." ---- ".$planillactual->observaciones;
         $observacambia = " ---- ".$now." ".Auth::user()->name.", Asigno a esta planilla la diligencia N°: "
                  .$id." desde la planilla: ".$this->idplanilla." ---- ".$planillacambia->observaciones;

         Planilla::where('id', $this->idplanilla)
            ->update([
               'observaciones'=>$observactual,
            ]);

         Planilla::where('id', $this->nueplani)
            ->update([
               'observaciones'=>$observacambia,
               'estado'       =>1,
            ]);

         // Reasignar la diligencia
         Asignacione::where('planilla_id', $this->idplanilla)
            ->where('correspondencia_id', $id)
            ->update([
               'planilla_id'  => $this->nueplani,
            ]);

         Correspondencia::where('id', $id)
               ->update([
                  'planilla'  => $this->nueplani,
               ]);

         // Liberar variable
         $this->nueplani='';
         $id='';
      }

   }

   public function render()
   {
      return view('livewire.correspondencia.planillafinal',[
         'idplanilla' => $this->idplanilla,
         'envios'   => $this->envios(),
         'planillabier' => $this->planillabier(),
         'operadores' => DB::table('users')
                                             ->join('empresa_users', 'empresa_users.user_id', '=', 'users.id')
                                             ->select('users.id', 'users.name')
                                             ->where('empresa_users.empresa_id', Auth::user()->empresa)
                                             ->where('empresa_users.role_id', '!=', 4)
                                             ->where('empresa_users.role_id', '!=', 1)
                                             ->where('users.estado', 2)
                                             ->orderBy('users.name', 'ASC')
                                             ->get(),
         'planilla' => DB::table('empresas')
                                             ->join('planillas', 'planillas.empresa_id', '=', 'empresas.id')
                                             ->join('rutas', 'rutas.id', '=', 'planillas.ruta_id')
                                             ->join('users', 'users.id', '=', 'planillas.operador')
                                             ->where('planillas.id', $this->idplanilla)
                                             ->select('planillas.id', 'planillas.fecha', 'planillas.observaciones',
                                                      'planillas.estado', 'rutas.nombre as ruta', 'users.id as iduser', 'users.name', 'empresas.nombre')
                                             ->first(),
         'idenvio' => $this->idenvio,
         'imagenes' => DB::table('soportents')
                                          ->join('users', 'users.id', '=', 'soportents.usuario')
                                          ->where('soportents.correspondencia_id', $this->idenvio)
                                          ->select('soportents.ruta', 'users.name')
                                          ->get(),

      ]);
   }


}

//1 construcción, 2 recorrido, 3 No entregado 4 cerrada //ASIGNACIONES
//1 ruta, 2 fuera de la ciudad, 3 entregado a otro operador 4 Cerrado //RECORRIDOS
// 1 creado, 2 dev 3 fuera 4 alertado 5 ruta 6 Cerrado 7 Entregado //CORRESPONDENCIAS
//1 construcción, 2 recorrido, 3 cerrada //PLANILLAS

