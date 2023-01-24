<?php

namespace App\Http\Livewire\Correspondencia;

use App\Asignacione;
use App\Correspondencia;
use App\Empresa;
use App\EmpresaUser;
use App\Ruta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Ordenaruta extends Component
{

   public $ciu=[];
   public $ruta;
   public $empr=[];
   public $ord;
   public $orga;

   use WithPagination;

   public function organiza($id)
   {
      $maximo = Asignacione::where('planilla_id', $this->ruta)
                           ->max('orden');

         $this->orga = $maximo+1;

      Asignacione::where('correspondencia_id', $id)
                  ->update([
                     'orden' => $this->orga,
                  ]);

         $this->orga=$this->orga+1;
   }

   public function ordena($id)
   {
      if($this->ord != ""){

         Asignacione::where('correspondencia_id', $id)
                  ->update([
                     'orden' => $this->ord,
                  ]);

         $this->ord = '';
      }

   }

   public function mostrar($id)
   {
      $this->ruta = $id;
   }

   public function asignar($id)
   {
      if($this->ruta != ""){
         //Asignar ruta al envío
      Correspondencia::where('id', $id)
      ->update([
         'planilla' => $this->ruta,
      ]);

      Asignacione::create([
      'planilla_id' => $this->ruta,
      'correspondencia_id' => $id,
      ]);
      }

   }

   public function eliminar($id)
   {

      Correspondencia::where('id', $id)
                     ->update([
                           'planilla' => NULL,
                     ]);

      Asignacione::where('correspondencia_id', $id)
                     ->delete();
   }

   public function planillar($id)
   {
      $this->emit('planilla', $id);
   }

   public function render()
   {
      return view('livewire.correspondencia.ordenaruta', [

         'rutas' =>Ruta::select('id', 'nombre')
                                             ->where('empresa_id', Auth::user()->empresa)
                                             ->orderBy('nombre', 'ASC')
                                             ->get(),
         'rutaeleg' => Ruta::select('id', 'nombre')
                                             ->where('id', $this->ruta)
                                             ->first(),
         'numeracion'=> Asignacione::where('planilla_id', $this->ruta)
                                             ->where('orden', '>=', 1)
                                             ->count(),
         'empresas' => Empresa::where('estado', 1)
                                             ->select('id', 'nombre')
                                             ->orderBy('nombre', 'ASC')
                                             ->get(),
         'empresactual' => Empresa::where('id', Auth::user()->empresa)
                                             ->select('id', 'nombre')
                                             ->first(),
         'ciudades' => Correspondencia::select('nombreubicacion')
                                             ->where('horario', '!=', NULL)
                                             ->where('destinatario', NULL)
                                             ->where('planilla', NULL)
                                             ->groupBy('nombreubicacion')
                                             ->orderBy('nombreubicacion', 'ASC')
                                             ->get(),
         'solicitudes' => Correspondencia::select('id', 'nombresede', 'nombreubicacion', 'descripcion')
                                             ->where('horario', '!=', NULL)
                                             ->where('destinatario', NULL)
                                             ->where('planilla', NULL)
                                             ->where('estado', '!=', '6')
                                             ->where('estado', '!=', '7')
                                             ->where('estado', '!=', '3')
                                             ->whereIn('empresa_id', $this->empr)
                                             ->whereIn('nombreubicacion', $this->ciu)
                                             ->orderBy('nombreubicacion', 'ASC')
                                             ->orderBy('nombresede', 'ASC')
                                             ->get(),
         'solisel' =>  DB::table('correspondencias')
                                             ->join('asignaciones', 'asignaciones.correspondencia_id', '=', 'correspondencias.id')
                                             ->select(
                                                   'correspondencias.id',
                                                   'correspondencias.nombresede',
                                                   'correspondencias.nombreubicacion',
                                                   'correspondencias.descripcion',
                                                   'asignaciones.orden')
                                             ->where('correspondencias.planilla', $this->ruta)
                                             ->where('asignaciones.planilla_id', $this->ruta)
                                             ->where('asignaciones.estado', 1)
                                             ->orderBy('correspondencias.descripcion', 'DESC')
                                             ->orderBy('asignaciones.orden', 'DESC')
                                             ->orderBy('asignaciones.id', 'DESC')
                                             ->get(),
         'rutsels' =>  DB::table('rutas')
                                             ->join('asignaciones', 'asignaciones.planilla_id', '=', 'rutas.id')
                                             ->where('asignaciones.estado', 1)
                                             ->whereIn('rutas.empresa_id', $this->empr)
                                             ->select('rutas.nombre', 'rutas.id')
                                             ->groupBy('rutas.id', 'rutas.nombre')
                                             ->orderBy('rutas.nombre', 'ASC')
                                             ->get(),
      ]);
   }
}

//1 construcción, 2 recorrido, 3 No entregado 4 cerrada Estados adicional
// 1 creado, 2 dev 3 fuera 4 alertado 5 ruta 6 cerrado 7 entregado Correspondencia
