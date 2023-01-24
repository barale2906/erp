<?php

namespace App\Http\Livewire\Correspondencia;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Devolucion extends Component
{
   public $motivo;

   public function submit()
   {
      $this->validate([
         "motivo"    => 'required',
      ]);

      DB::table('devoluciones')
         ->insert([
            'motivo' =>  $this->motivo,
         ]);

      session()->flash('message', $this->motivo.' fue creado correctamente.');

      $this->motivo  ="";
   }
   public function render()
   {
      return view('livewire.correspondencia.devolucion', [
         'motivos' => DB::table('devoluciones')
                           ->where('estado', 1)
                           ->orderBy('motivo', 'ASC')
                           ->get(),
      ]);
   }
}
