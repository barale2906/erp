<?php

namespace App\Http\Livewire\Humana;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Itemsalario extends Component
{
   public $cargo;
   public $descripcion;
   public $tipo;

   public function submit()
   {
      $this->validate([
         "cargo"        => 'required',
         "descripcion"  => 'required',
         "tipo"         => 'required',

      ]);


      DB::table('pagoperador')
         ->insert([
            "cargo"         => $this->cargo,
            "descripcion"   => $this->descripcion,
            "tipo"          => $this->tipo,
         ]);


      session()->flash('message', $this->cargo.' fue creado correctamente.');

      $this->cargo         ="";
      $this->descripcion   ="";
      $this->tipo          ="";

   }

   public function render()
   {
      return view('livewire.humana.itemsalario',[
         'items' => DB::table('pagoperador')
                        ->where('estado', 1)
                        ->orderbY('cargo', 'ASC')
                        ->get(),
      ]);
   }
}
