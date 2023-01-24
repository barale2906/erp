<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Festivos extends Component
{
   use WithPagination;
   public $fecha;
   public $descripcion;

   public function guardar()
   {
      DB::table('festivos')->insert([
            'fecha'        => $this->fecha,
            'descripcion'  => $this->descripcion,
         ]);

         session()->flash('message', 'Fue creada correctamente la fecha festiva.');
   }
   public function render()
   {
      return view('livewire.festivos',[
         'festivos' => DB::table('festivos')
                           ->orderBy('fecha', 'ASC')
                           ->paginate(5),
      ]);
   }
}
