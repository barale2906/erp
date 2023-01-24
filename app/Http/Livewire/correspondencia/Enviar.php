<?php

namespace App\Http\Livewire\Correspondencia;

use App\Correspondencia;
use App\Fuera;
use App\Recorrido;
use App\Transportadora;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Enviar extends Component
{

   public $transportadora;
   public $guia;
   public $correspondencia;
   public $empresa;
   public $envio;
   public $observaciones;



   public function enviar()
   {
      $this->validate([
         "transportadora"    => 'required',
         "guia"              => 'required',
         "correspondencia"   => 'required',
      ]);

      $this->envio = Auth::user()->id;
      $this->empresa = Auth::user()->empresa;

      // Crear registro de envío.
      Fuera::create([
         "guia"                  => $this->guia,
         "transportadora_id"     => $this->transportadora,
         "correspondencia_id"    => $this->correspondencia,
         "empresa"               => $this->empresa,
         "envio"                 => $this->envio,
         "estado"                => '2',
      ]);

      // Seleccionar nombre de transportadora
      $nomtrans= Transportadora::where('id', $this->transportadora)
                                 ->select('nombre')
                                 ->first();

      // Actualizar estado de la solicitud
      $detalle = Correspondencia::where('id', $this->correspondencia)
                     ->select('observaciones')
                     ->first();

      $now = Carbon::now();

      $this->observaciones=' ---- '.$now.' '.Auth::user()->name.' envió la solicitud a otra ciudad con el numero de guía: '.
                              $this->guia.' de la transportadora: '.$nomtrans->nombre.' ---- '.$detalle->observaciones;

      // Actualizar envío
      Correspondencia::where('id', $this->correspondencia)
      ->update([
         'observaciones' => $this->observaciones,
         'estado'        => '3',
         ]);

      // Liberar Mensajero
      $tenia = Recorrido::where('correspondencia_id', $this->correspondencia)
      ->select('id')
      ->first();

      if(!empty($tenia)){
      Recorrido::where('id', $tenia->id)
      ->update(['estado' => '2']);
      }

      //Enviar mensaje de confirmación
      session()->flash('message', $this->correspondencia.' fue enviada con la guía N°: '.$this->guia.' de la transportadora: '.$nomtrans->nombre);

      //Liberar variable
      $this->correspondencia='';
   }

   // Eliminar envío de la guía actual
   public function eliminar($id)
   {
      $buscarlo = Fuera::find($id);

      // Actualizar estado de la solicitud
      $detalle = Correspondencia::where('id', $buscarlo->correspondencia_id)
                     ->select('observaciones')
                     ->first();

      $now = Carbon::now();

      $this->observaciones=' ---- '.$now.' '.Auth::user()->name.' elimino este envío de la guía: '.$buscarlo->guia.' ---- '.$detalle->observaciones;

      // Actualizar envío
      Correspondencia::where('id', $buscarlo->correspondencia_id)
      ->update([
         'observaciones' => $this->observaciones,
         'estado'        => '5',
         ]);

      // Liberar Mensajero
      $tenia = Recorrido::where('correspondencia_id', $buscarlo->correspondencia_id)
      ->select('id')
      ->first();

      if(!empty($tenia)){
      Recorrido::where('id', $tenia->id)
      ->update(['estado' => '1']);
      }

      // Eliminar registro
      Fuera::destroy($id);

      session()->flash('salida', $buscarlo->correspondencia_id.' ya no esta registrada en la guía N°: '.$buscarlo->guia);


   }

   public function render()
   {

      return view('livewire.correspondencia.enviar', [

         'transportadoras' => Transportadora::where('empresa', Auth::user()->empresa)
                                             ->select('id', 'nombre')
                                             ->orderBy('nombre', 'ASC')
                                             ->get(),

         'solicitudes' => Correspondencia::where('empresa_id', Auth::user()->empresa)
                                          ->where('estado', '!=', 2)
                                          ->where('estado', '!=', 3)
                                          ->where('estado', '!=', 6)
                                          ->select('id', 'nombredestinatario', 'nombresede', 'nombreubicacion')
                                          ->orderBy('id', 'ASC')
                                          ->get(),

         'seleccionadas' => DB::table('correspondencias')
                                 ->join('fueras', 'fueras.correspondencia_id', '=', 'correspondencias.id')
                                 ->join('transportadoras', 'transportadoras.id', '=', 'fueras.transportadora_id')
                                 ->select('correspondencias.id', 'correspondencias.nombredestinatario', 'correspondencias.nombresede',
                                             'correspondencias.nombreubicacion', 'correspondencias.descripcion',
                                             'fueras.guia', 'fueras.id as fuerid', 'transportadoras.nombre')
                                 ->where('fueras.empresa', Auth::user()->empresa)
                                 ->where('fueras.guia', $this->guia)
                                 ->where('fueras.transportadora_id', $this->transportadora)
                                 ->where('fueras.estado', '!=', 3)
                                 ->orderBy('correspondencias.id', 'ASC')
                                 ->get(),
      ]);
   }
}
