<?php

namespace App\Http\Livewire\Correspondencia;

use App\Asignacione;
use App\Correspondencia;
use App\Planilla;
use App\Ruta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Creaplanillas extends Component
{
   public $fecha;
   public $ruta_id;
   public $operador;
   public $observaciones;
   public $idplani;
   public $mostrar;
   public $rutaelegida;
   public $cantidad;
   public $minimo;


   protected $listeners = ['planilla', 'abrir'];

   public function abrir()
   {
      $this->mostrar = 1;
   }

   public function planilla($id)
   {
      $this->ruta_id = $id;
      $this->mostrar = 1;
      //  $this->rutaelegida = $nombreruta;
   }

   public function crear()
   {
      $this->validate([
         "fecha"     => 'required',
         "cantidad"  => 'required',
         "operador"  => 'required',

      ]);

      // Determinar el menor
      $minimoact = Asignacione::where('planilla_id', $this->ruta_id)
                                             ->where('orden', '>=', 1)
                                             ->min('orden');

      $this->minimo = $minimoact;

      // crear planilla
      $planillanueva = Planilla::create([
                              "fecha"         => $this->fecha,
                              "empresa_id"    => Auth::user()->empresa,
                              "ruta_id"       => $this->ruta_id,
                              "operador"      => $this->operador,
                              "asigno"        => Auth::user()->id,
                              "observaciones" => $this->observaciones,
                              ]);


      //Actualizar planilla en correspondencia y en asignaciones
      DB::table('correspondencias')
                  ->join('asignaciones', 'asignaciones.correspondencia_id', '=', 'correspondencias.id')
                  ->where('correspondencias.planilla', $this->ruta_id)
                  ->where('asignaciones.estado', 1)
                  ->whereBetween('asignaciones.orden', [$this->minimo, $this->cantidad])
                  //->where('orden', '<=', $this->cantidad)
                  ->update([
                     'asignaciones.planilla_id' => $planillanueva->id,
                     'correspondencias.planilla' => $planillanueva->id,
                  ]);



      session()->flash('message', 'La planilla fue creada correctamente, con fecha: '.$this->fecha );

      $this->fecha            ="";
      $this->observaciones    ="";
      $this->cantidad         ="";

   }

   public function editar($id)
   {
      $this->idplani = $id;
   }

   public function cerrar()
   {
      $this->idplani = '';
   }

   public function modificar()
   {
      Planilla::where('id', $this->idplani)
                  ->update([
                     'operador'=> $this->operador,
                  ]);

                  session()->flash('modifico', 'La planilla fue actualizada correctamente' );
      $this->operador = '';
   }

   public function eliminar($id)
   {
      //Seleccionar datos
      $planelim = Planilla::where('id', $id)
                           ->select('ruta_id')
                           ->first();

      //Actualizar correspondencia
      Correspondencia::where('planilla', $id)
                     ->update([
                           'planilla' => $planelim->ruta_id,
                     ]);
      //Actualizar asignaciones
      Asignacione::where('planilla_id', $id)
                     ->update([
                           'planilla_id' => $planelim->ruta_id,
                     ]);

      //Eliminar plantilla
      Planilla::where('id', $id)
               ->delete();

      // Liberar id
      $this->idplani = '';

                  session()->flash('eliminar', 'La planilla fue eliminada correctamente' );
   }

   public function render()
   {
      return view('livewire.correspondencia.creaplanillas', [

         'numeracion'=> Asignacione::where('planilla_id', $this->ruta_id)
                                             ->where('orden', '>=', 1)
                                             ->select('orden')
                                             ->orderBy('orden', 'ASC')
                                             ->get(),
         'nombreruta'=> Ruta::where('id', $this->ruta_id)
                                             ->select('nombre')
                                             ->first(),
         'operadores' => DB::table('users')
                                             ->join('empresa_users', 'empresa_users.user_id', '=', 'users.id')
                                             ->select('users.id', 'users.name')
                                             ->where('empresa_users.empresa_id', Auth::user()->empresa)
                                             ->where('empresa_users.role_id', '!=', 4)
                                             ->where('empresa_users.role_id', '!=', 1)
                                             ->where('users.estado', 2)
                                             ->orderBy('users.name', 'ASC')
                                             ->get(),
         'planillasabiertas' => DB::table('users')
                                             ->join('planillas', 'planillas.operador', '=', 'users.id')
                                             ->join('rutas', 'rutas.id', '=', 'planillas.ruta_id')
                                             ->select('users.name', 'rutas.nombre', 'planillas.fecha', 'planillas.observaciones',
                                                      'planillas.id as planid')
                                             ->where('planillas.estado', 1)
                                             ->orderBy('planillas.fecha', 'ASC')
                                             ->get(),
         'solicitudesexternas' => Correspondencia::where('empresa_id', Auth::user()->empresa)
                                             ->where('estado', '!=', '6')
                                             ->where('estado', '!=', '7')
                                             ->where('estado', '!=', '3')
                                             ->where('destinatario', '!=', NULL)
                                             ->orderBy('id', 'ASC')
                                             ->get(),
         'idplani'   => $this->idplani,
         'mostrar'   => $this->mostrar,
         'planillactual' => DB::table('users')
                                             ->join('planillas', 'planillas.operador', '=', 'users.id')
                                             ->join('rutas', 'rutas.id', '=', 'planillas.ruta_id')
                                             ->select('users.name', 'users.id', 'rutas.id as rutid', 'rutas.nombre',
                                                         'planillas.fecha', 'planillas.observaciones', 'planillas.id as planid')
                                             ->where('planillas.id', $this->idplani )
                                             ->first(),
      ]);
   }
}

//1 construcción, 2 recorrido, 3 cerrada planillas
// 1 creado, 2 dev 3 fuera 4 alertado 5 ruta 6 cerrado 7 entregado Correspondencia
