<?php

namespace App\Http\Livewire\Correspondencia;

//use Carbon\Carbon;

use App\Asignacione;
use App\Correspondencia;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Inditiempo extends Component
{
   use WithPagination;

   public $fechaini;
   public $fechafin;
   public $hoy;
   public $idsel;


   protected $casts = [
         'hoy'=>'date:y/m/d',
      ];

   public function mount()
   {
      $this->hoy = \Carbon\Carbon::now()->add(1, 'day');
   }

   private function registros()
   {
      if(empty($this->fechaini) || empty($this->fechafin))
      {
         return Correspondencia::whereDate('created_at', '=', $this->hoy)
                                 ->first();
      } else {
         // Seleccionar diligencias
         return DB::table('inditiempos')
                                    ->join('correspondencias', 'correspondencias.id', '=', 'inditiempos.correspondencia_id')
                                    ->select('inditiempos.*', 'nombredestinatario', 'nombresede', 'nombreubicacion')
                                    ->where('empresa_id', Auth::user()->empresa)
                                    ->whereDate('fecha', '>=', $this->fechaini)
                                    ->whereDate('fecha', '<=', $this->fechafin)
                                    ->paginate(4);
      }
   }

   private function agrupados()
   {
      if(empty($this->fechaini) || empty($this->fechafin))
      {
         return Correspondencia::whereDate('created_at', '=', $this->hoy)
                                 ->first();
      } else {
         // Seleccionar diligencias
         return DB::table('inditiempos')
                                    ->join('correspondencias', 'correspondencias.id', '=', 'inditiempos.correspondencia_id')
                                    ->select('inditiempos.*')
                                    ->where('empresa_id', Auth::user()->empresa)
                                    ->whereDate('fecha', '>=', $this->fechaini)
                                    ->whereDate('fecha', '<=', $this->fechafin)
                                    ->get();
      }
   }

   private function mensajero()
   {
      if(empty($this->fechaini) || empty($this->fechafin))
      {
         return Correspondencia::whereDate('created_at', '=', $this->hoy)
                                 ->first();
      } else {
         // Seleccionar diligencias
         return DB::table('inditiempos')
                                    ->join('correspondencias', 'correspondencias.id', '=', 'inditiempos.correspondencia_id')
                                    ->select('inditiempos.diferem')
                                    ->where('empresa_id', Auth::user()->empresa)
                                    ->where('diferem', '!=', NULL)
                                    ->whereDate('fecha', '>=', $this->fechaini)
                                    ->whereDate('fecha', '<=', $this->fechafin)
                                    ->count();
      }
   }

   private function completo()
   {
      if(empty($this->fechaini) || empty($this->fechafin))
      {
         return Correspondencia::whereDate('created_at', '=', $this->hoy)
                                 ->first();
      } else {
         // Seleccionar diligencias
         return DB::table('inditiempos')
                                    ->join('correspondencias', 'correspondencias.id', '=', 'inditiempos.correspondencia_id')
                                    ->select('inditiempos.diferencia')
                                    ->where('empresa_id', Auth::user()->empresa)
                                    ->where('diferencia', '!=', NULL)
                                    ->whereDate('fecha', '>=', $this->fechaini)
                                    ->whereDate('fecha', '<=', $this->fechafin)
                                    ->count();
      }
   }

   private function noentregado()
   {
      if(empty($this->fechaini) || empty($this->fechafin))
      {
         return Correspondencia::whereDate('created_at', '=', $this->hoy)
                                 ->first();
      } else {
         // Seleccionar diligencias
         return DB::table('inditiempos')
                                    ->join('correspondencias', 'correspondencias.id', '=', 'inditiempos.correspondencia_id')
                                    ->select('inditiempos.diferencia')
                                    ->where('empresa_id', Auth::user()->empresa)
                                    ->where('diferencia', NULL)
                                    ->where('diferem', NULL)
                                    ->whereDate('fecha', '>=', $this->fechaini)
                                    ->whereDate('fecha', '<=', $this->fechafin)
                                    ->count();
      }
   }


   public function render()
   {
         return view('livewire.correspondencia.inditiempo',[
            'resultados'   => $this->registros(),
            'tiempos'   => $this->agrupados(),
            'mensajero'   => $this->mensajero(),
            'completo'   => $this->completo(),
            'noentregado'   => $this->noentregado(),
         ]);
   }
}
