<?php

namespace App\Http\Livewire\Diligencias;

use App\Diligencia;
use App\Empresa;
use App\EmpresaUser;
use App\Frecuente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Detalledili extends Component
{
   public $sitio=0;
   public $recoleccion;
   public $entrega=0;
   public $direntrega;
   public $uen;
   public $centro;
   public $proyecto;
   public $fecha;
   public $comentario;
   public $consultafrecuentes=0;
   public $periodica;


   // Seleccionar mi propia dirección
   private function sitioasig()
   {
      if($this->sitio == 1 or $this->entrega == 1)
      {
         $mia = EmpresaUser::join('sucursales', 'empresa_users.sucursal_id', 'sucursales.id')
                              ->join('ciudades', 'sucursales.ciudad_id', 'ciudades.id')
                              ->where('empresa_users.user_id', Auth::user()->id)
                              ->where('empresa_users.empresa_id', Auth::user()->empresa)
                              ->select('sucursales.direccion', 'ciudades.ciudad')
                              ->first();
         if($this->sitio == 1)
         {
            $this->recoleccion = $mia->direccion." - ".$mia->ciudad;
         }

         if($this->entrega == 1)
         {
            $this->direntrega = $mia->direccion." - ".$mia->ciudad;
         }

      }
   }

   // Seleccionar frecuente
   private function recolprovee()
   {
      if($this->sitio == 2 or $this->entrega == 2)
      {
         //ubicación del usuario
         $ubica = EmpresaUser::where('user_id', Auth::user()->id)
                              ->where('empresa_id', Auth::user()->empresa)
                              ->select('sucursal_id', 'area_id')
                              ->first();

         $recol = Frecuente::where('sucursal', $ubica->sucursal_id)
                           ->where('area', $ubica->area_id)
                           ->count();

         if($recol > 0)
         {
            $this->consultafrecuentes = 1;
            return Frecuente::where('sucursal', $ubica->sucursal_id)
                           ->where('area', $ubica->area_id)
                           ->select('direccion', 'ciudad', 'destinatario')
                           ->orderBy('destinatario', 'ASC')
                           ->get();
         }
      }
   }

   // Seleccionar periodica
   private function periodili()
   {
      if($this->periodica==2)
      {
         return Diligencia::where('empresa_id', Auth::user()->empresa)
                        ->where('estado', 10)
                        ->orderBy('id', 'DESC')
                        ->get();
      }
   }

   // Cerrar modal
   public function cerrar()
   {
      $this->reset();
   }

   // Crear Diligencia
   public function crear()
   {
      $now = Carbon::now();
      $empresa = Empresa::where('id', Auth::user()->empresa)->select('nombre')->first();

      $observa = "---".$now." ".Auth::user()->name." creo la diligencia, de la empresa: ".$empresa->nombre." --";
      $diligencia = Diligencia::create([
                     'usuario_id'   => Auth::user()->id,
                     'empresa_id'   => Auth::user()->empresa,
                     'recoge'       => $this->recoleccion,
                     'entrega'      => $this->direntrega,
                     'uen'          => $this->uen,
                     'centro'       => $this->centro,
                     'proyecto'     => $this->proyecto,
                     'fecha'        => $this->fecha,
                     'comentarios'  => $this->comentario,
                     'observaciones'=> $observa,
                  ]);

      if($this->periodica==1)
      {
         Diligencia::create([
            'usuario_id'   => Auth::user()->id,
            'empresa_id'   => Auth::user()->empresa,
            'recoge'       => $this->recoleccion,
            'entrega'      => $this->direntrega,
            'uen'          => $this->uen,
            'centro'       => $this->centro,
            'proyecto'     => $this->proyecto,
            'fecha'        => $this->fecha,
            'comentarios'  => $this->comentario,
            'observaciones'=> $observa,
            'estado'       => 10,
         ]);
      }

      $this->reset();

      session()->flash('messagelim', 'Se creo satisfactoriamente la diligencia N°: '.$diligencia->id );

      $this->emit('recargar');

   }

   // Mostrar diligencias periodicas
   public function periomuestra()
   {
      $this->periodica = 2;
   }

   // Cargar datos de la selección
   public function selecdili($id)
   {
      $actual = Diligencia::where('id', $id)->first();

      $this->sitio         = 3;
      $this->recoleccion   = $actual->recoge;
      $this->entrega       = 3;
      $this->direntrega    = $actual->entrega;
      $this->uen           = $actual->uen;
      $this->centro        = $actual->centro;
      $this->proyecto      = $actual->proyecto;
      $this->comentario    = $actual->comentarios;
   }

   public function render()
   {
      return view('livewire.diligencias.detalledili',[
         'sitioasig'       => $this->sitioasig(),
         'recolprovee'     => $this->recolprovee(),
         'periodili'       => $this->periodili(),
      ]);
   }
}
