<?php

namespace App\Http\Livewire\Diligencias;

use App\Diligencia;
use App\Dilioperador;
use App\EmpresaUser;
use App\Prepago;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Gestiondiligencia extends Component
{
   use WithPagination;

   public $ordena='id';
   public $ordenado='ASC';
   public $porpagina=10;
   public $buscar='';

   public $operadorid;
   public $diligenciaid;
   public $prepa;
   public $guias;
   public $observaciones;
   public $imag;
   public $control=0;

   // CONTROLES DE BUSQUEDAS
   public function ordena($campo)
   {
      if($this->ordenado == 'ASC')
      {
         $this->ordenado = 'DESC';
      }else{
         $this->ordenado = 'ASC';
      }
      return $this->ordena = $campo;

      $this->listasig();

   }

   // resetear numeración
   public function updatingbuscar()
   {
         $this->resetPage();
   }

   public function updatingporpagina()
   {
         $this->resetPage();
   }

   // resetear busqueda
   public function limpiar()
   {
      $this->reset();
   }

   // asignar operador
   public function asigna($id)
   {
      if($this->operadorid)
      {
         $operadorname = User::where('id', $this->operadorid)->select('name')->first();
         $obser = Diligencia::where('id', $id)->select('observaciones')->first();
         $now = Carbon::now();
         $observa = "---".$now." ".Auth::user()->name." le ASIGNO a: ".$operadorname->name." --".$obser->observaciones;

         Diligencia::where('id', $id)
                     ->update([
                        'observaciones'   => $observa,
                        'estado'          => 2,
                     ]);

         Dilioperador::create([
            'usuario_id'      => $this->operadorid,
            'diligencia_id'   => $id,
         ]);
      }
   }

   // reasignar operador
   public function reasigna($id)
   {
      if($this->operadorid)
      {
         $operadorname = User::where('id', $this->operadorid)->select('name')->first();
         $obser = Diligencia::where('id', $id)->select('observaciones')->first();
         $now = Carbon::now();
         $observa = "---".$now." ".Auth::user()->name." le REASIGNO a: ".$operadorname->name." --".$obser->observaciones;

         Diligencia::where('id', $id)
                     ->update([
                        'observaciones'   => $observa,
                     ]);

         $maxid = Dilioperador::where('diligencia_id', $id)->max('id');

         Dilioperador::where('id', $maxid)
                     ->update([
                        'estado' => 3,
                     ]);

         Dilioperador::create([
            'usuario_id'      => $this->operadorid,
            'diligencia_id'   => $id,
         ]);
      }
   }

   // Registra observaciones
   public function observa()
   {
      $obser = Diligencia::where('id', $this->diligenciaid)->select('observaciones')->first();
      $now = Carbon::now();
      $observa = "---".$now." ".Auth::user()->name.": ".$this->observaciones." --".$obser->observaciones;

      Diligencia::where('id', $this->diligenciaid)
                  ->update([
                     'observaciones'   => $observa,
                  ]);

      $this->cancelar();
   }

   // Modal cierre
   public function modalcierre($id)
   {
      $this->diligenciaid = $id;
      $empresa = Diligencia::where('id', $id)->select('empresa_id')->first();

      $usa = Prepago::where('empresa_id', $empresa->empresa_id)
                     ->count();

      if($usa>=1){
         $this->prepa = Prepago::where('empresa_id', $empresa->empresa_id)
                                 ->sum('cantidad');
      }


   }

   // Modal Cierra diligencia
   public function cierra($id)
   {
      $obser = Diligencia::where('id', $id)->select('observaciones', 'empresa_id')->first();
      $now = Carbon::now();

      // Asignar guías
      if($this->prepa)
      {
         $salida=$this->guias*-1;
         Prepago::create([
            'empresa_id'   => $obser->empresa_id,
            'documento'    => 'diligencia',
            'documento_id' => $id,
            'cantidad'     => $salida,
         ]);

         $observa = "---".$now." ".Auth::user()->name." aplico: ".$this->guias." guía(s) y CONCLUYO LA SOLICITUD  ----- ".$this->observaciones." --".$obser->observaciones;
         $estado = 7;
      } else {
         $observa = "---".$now." ".Auth::user()->name." fue (ron): ".$this->guias." diligencia(s) y CONCLUYO LA SOLICITUD  ----- ".$this->observaciones." --".$obser->observaciones;
         $estado = 5;
      }

      // Cierra diligencia
      Diligencia::where('id', $id)
                  ->update([
                     'observaciones'   => $observa,
                     'guias'           => $this->guias,
                     'estado'          => $estado,
                  ]);

      // Selecciona operador
      $maxid = Dilioperador::where('diligencia_id', $id)->max('id');

      // Actualiza operador
      Dilioperador::where('id', $maxid)
                  ->update([
                     'estado' => 2,
                  ]);

      // Emitir información
      session()->flash('suceso', 'Cerro correctamente la diligencia N°: '. $id);

      $this->cancelar();

   }

   // Diligencia Cancelada
   public function cancelada($id)
   {
      $obser = Diligencia::where('id', $id)->select('observaciones', 'empresa_id')->first();
      $now = Carbon::now();

      $observa = "---".$now." ".Auth::user()->name." CANCELO LA SOLICITUD, por: ".$this->observaciones."  --".$obser->observaciones;

      // Cancelar diligencia
      Diligencia::where('id', $id)
                  ->update([
                     'observaciones'   => $observa,
                     'estado'          => 8,
                  ]);

      // Descargar operador
      Dilioperador::where('diligencia_id', $id)
                  ->whereIn('estado', [1,2])
                  ->update([
                     'estado' => 5,
                  ]);

      // Emitir información
      session()->flash('suceso', 'CANCELO correctamente la diligencia N°: '. $id);

      $this->cancelar();

   }

   // Cerrar el modal
   public function cancelar()
   {
      $this->reset(['operadorid', 'diligenciaid', 'prepa', 'guias', 'observaciones', 'imag' ]);
   }

   // Ver imagenes
   public function imagenes($id)
   {
      $this->cancelar();
      $this->imag = $id;
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

   // listar solicitudes sin asignar
   private function listado()
   {
      return Diligencia::join('empresas', 'diligencias.empresa_id', '=', 'empresas.id')
                        ->where('diligencias.estado', '<=', 1)
                        ->select('diligencias.*', 'empresas.nombre')
                        ->orderBy('diligencias.estado', 'ASC')
                        ->get();
   }

   // listar solicitudes asignadas
   private function listasig()
   {
      $listado = Diligencia::query()
                     ->Buscar($this->buscar)               // Asi llama al scope 
                     ->whereIn('diligencias.estado', [2, 3, 4, 6, 9])
                     ->orderBy($this->ordena, $this->ordenado)
                     ->paginate($this->porpagina);

      return $listado;
   }

   //Listar operadores
   private function operadores()
   {
      return EmpresaUser::join('users', 'empresa_users.user_id', '=', 'users.id')
                           ->where('users.estado', 2)
                           ->whereIn('empresa_users.role_id', [2,3,5])
                           ->select('users.name', 'users.id')
                           ->groupBy('users.name',  'users.id')
                           ->orderBy('users.name', 'ASC')
                           ->get();
   }

   // Diligencia actual
   private function diliactual()
   {
      if($this->diligenciaid)
      {
         return Diligencia::where('id', $this->diligenciaid)
                           ->first();
      }
   }

   public function render()
   {
      return view('livewire.diligencias.gestiondiligencia', [
         'listado'         => $this->listado(),
         'listasig'        => $this->listasig(),
         'operadores'      => $this->operadores(),
         'diliactual'      => $this->diliactual(),
         'imagenesta'      => $this->imagenesta(),
      ]);
   }
}
