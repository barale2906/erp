<?php

namespace App\Http\Livewire\Financiero;

use App\Caja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Efectivo extends Component
{
   use WithFileUploads;
   use WithPagination;

   public $porpagina=5;
   public $valor;
   public $descripcion;
   public $movimiento;
   public $usude=1;
   public $foto;


   private function movimientos()
   {
      return Caja::where('user_id', Auth::user()->id)
                  ->where('financiero_id', 1)
                  ->orderBy('created_at', 'DESC')
                  ->paginate($this->porpagina);
   }

   private function total()
   {
      return Caja::where('user_id', Auth::user()->id)
                  ->where('financiero_id', 1)
                  ->sum('valor');
   }

   private function poseen()
   {
      $eso = Caja::where('financiero_id', 1)
                  ->select('user_id', 'usuario')
                  ->addSelect(DB::raw('SUM(valor) as saldo'))
                  ->groupBy('user_id', 'usuario')
                  ->orderBy('usuario', 'ASC')
                  ->get();

      return $eso;

      //dd($eso);
   }

   public function cargar()
   {
      switch ($this->movimiento) {
         case 1:
               $tipo    = 'e';
               $valor   = $this->valor;
               $movim   = 'Recibí en efectivo';
               $this->validate([
                  'descripcion'   => 'required',
                  'valor'         => 'required',
               ]);
               $rutafoto = "../caja/billete10.jpg";
               $mensaje = "Se cargarón: $ ".number_format($this->valor, 0, ',', ' ')." a sus registros.";
               break;
         case 2:
               $tipo    = 's';
               $valor   = $this->valor*-1;
               $movim   = 'Entregué efectivo';
               $this->validate([
                  'descripcion'   => 'required',
                  'valor'         => 'required',
                  'foto'          => 'required',
               ]);

               //mayor numero
               $ididen = Caja::max('id'); 

               $ididen = $ididen+1;

               // Envía imagen al servidor
               $fotonom = Auth::user()->id.'-'.$ididen.'.'.$this->foto->getClientOriginalExtension();
               $this->foto->storeAs('caja', $fotonom, 'public_soportes');
               $rutafoto = "../caja/".$fotonom;
               $mensaje = "Se retirarón: $ ".number_format($this->valor, 0, ',', ' ')." de sus registros.";
               break;
      }

      Caja::create([
         'movimiento'      => $movim,
         'tipo'            => $tipo,
         'valor'           => $valor,
         'descripcion'     => $this->descripcion,
         "imagen"          => $rutafoto,
         "usuario"         => Auth::user()->name,
         "user_id"         => Auth::user()->id,
         "financiero_id"   => 1,
      ]);

      // Descargar otro usuario
      if($this->usude != 1)
      {
         $valorm        = $this->valor*-1;
         $descripcion   = "Le entregue el dinero a: ".Auth::user()->name;
         $entrego       =  explode('-', $this->usude);

         Caja::create([
            'movimiento'      => 'Entregué efectivo',
            'tipo'            => 's',
            'valor'           => $valorm,
            'descripcion'     => $descripcion,
            "imagen"          => $rutafoto,
            "usuario"         => $entrego[1],
            "user_id"         => $entrego[0],
            "financiero_id"   => 1,

         ]);
      }

      // Emitir información
      session()->flash('suceso', $mensaje);

      // Limpirar variables
      $this->reset();

   }

   public function render()
   {
      return view('livewire.financiero.efectivo', [
         'movimientos'        => $this->movimientos(),
         'total'              => $this->total(),
         'poseen'             => $this->poseen(),
      ]);
   }
}
