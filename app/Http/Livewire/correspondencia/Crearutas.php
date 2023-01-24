<?php

namespace App\Http\Livewire\Correspondencia;

use App\Ruta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Crearutas extends Component
{
   public $nombre;
   public $descripcion;
   public $user_id;
   public $empresa;

   public function submit()
   {
      $this->validate([
         "nombre"    => 'required',
         "descripcion" => 'required',

      ]);
      $this->empresa = Auth::user()->empresa;
      $this->user_id = Auth::user()->id;

      Ruta::create([
         "nombre"        => $this->nombre,
         "descripcion"   => $this->descripcion,
         "user_id"       => $this->user_id,
         "empresa_id"    => $this->empresa,
      ]);


      session()->flash('message', $this->nombre.' fue creada correctamente.');

      $this->nombre       ="";
      $this->descripcion  ="";

   }

   public function render()
   {
      return view('livewire.correspondencia.crearutas', [

         'rutas' => Ruta::where('empresa_id', Auth::user()->empresa)
                                             ->orderBy('nombre', 'ASC')
                                             ->get()
      ]);
   }
}
