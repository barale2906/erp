<?php

namespace App\Http\Livewire\Correspondencia;

use App\Correspondencia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dilitengo extends Component
{
   public $ingresa;
   public $busquedas;
   public $actual;
   public $actualiza;
   public $entregado;
   public $entregar;

/*
   public function mount()
   {
      $this->buscar = "";
      $this->busquedas = [];

   }
*/
   // protected $listeners = ['buscar'];

   public function detalle($id)
   {
      $this->actual = $id;
      /* */
   }

   public function estadoentrega()
   {
      $this->entregar=$this->entregado;
   }

   public function borrarentregar()
   {
      $this->entregar= "";
   }


   public function observ()
   {
      $now = Carbon::now();
      $obse = $this->obse = Correspondencia::where('id', $this->actual)
            ->select('observaciones')
            ->first();

      $nueva=' ---- '.$now.' '.Auth::user()->name.' '.$this->actualiza.' ---- '.$obse->observaciones;

      // Actualizar envío
      Correspondencia::where('id', $this->actual)
                        ->update(['observaciones' => $nueva]);

      $this->actualiza = '';

      session()->flash('message', $this->actual.' ha sido actualizado correctamente.');

   }

   public function render()
   {
      return view('livewire.correspondencia.dilitengo', [
         'actual' => $this->actual,
         'ingresa'=> $this->ingresa,
         'dilitengo' => DB::table('correspondencias')
                                    ->join('recorridos', 'recorridos.correspondencia_id', '=', 'correspondencias.id')
                                    ->where('recorridos.operador', Auth::user()->id)
                                    ->where('recorridos.estado', 1)
                                    //->orWhere('correspondencia.id', 'like' , $this->ingresa)
                                    ->select('correspondencias.id', 'correspondencias.nombredestinatario',
                                    'correspondencias.nombresede', 'correspondencias.nombreubicacion',
                                    'correspondencias.descripcion', 'correspondencias.observaciones')
                                    ->orderBy('correspondencias.id', 'ASC')
                                    ->get(),
         'motivos' => DB::table('devoluciones')
                                    ->where('estado', 1)
                                    ->orderBy('motivo', 'ASC')
                                    ->get(),

         'entregar'=> $this->entregar,

      ]);
   }
}
