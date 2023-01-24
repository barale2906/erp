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

class Recibir extends Component
{

   public $transportadora;
   public $guia;

   // mostrar las diligencias que estan registradas en esta guía
   public function recibir($id)
   {
      $buscarlo = Fuera::find($id);

      // Actualizar estado de la solicitud
      $detalle = Correspondencia::where('id', $buscarlo->correspondencia_id)
                     ->select('observaciones')
                     ->first();

      $now = Carbon::now();

      $this->observaciones=' ---- '.$now.' '.Auth::user()->name.' recibio este envío de la guía: '.$buscarlo->guia.' ---- '.$detalle->observaciones;

      // Actualizar envío
      Correspondencia::where('id', $buscarlo->correspondencia_id)
      ->update([
         'observaciones' => $this->observaciones,
         'estado'        => '5',
         ]);

      // Liberar Mensajero
      $tenia = Recorrido::where('correspondencia_id', $buscarlo->correspondencia_id)
                     ->where('estado', 2)
                     ->select('id')
                     ->first();

      if(!empty($tenia)){

         Recorrido::where('id', $tenia->id)
         ->update(['estado' => '3']);
      }

      // Asignar diligencia a quien lo recibio
      Recorrido::create([

         "correspondencia_id"    => $buscarlo->correspondencia_id,
         "operador"              => Auth::user()->id,

      ]);

      // Registrar llegada del elemento
      Fuera::where('id', $id)
      ->update(['estado' => '3']);



      session()->flash('message', $buscarlo->correspondencia_id.' ha sido recibida correctamente.');


   }

   public function render()
   {
      return view('livewire.correspondencia.recibir', [

         'transportadoras' => Transportadora::where('empresa', Auth::user()->empresa)
                           ->select('id', 'nombre')
                           ->orderBy('nombre', 'ASC')
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
