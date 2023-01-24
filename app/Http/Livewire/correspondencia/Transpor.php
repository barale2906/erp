<?php

namespace App\Http\Livewire\Correspondencia;

use App\Transportadora;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Transpor extends Component
{
   public $nombre;
   public $direccion;
   public $contacto;
   public $telefono;
   public $email;
   public $mensaje;
   public $empresa;

   public function submit()
   {
      $this->validate([
         "nombre"    => 'required',
         "direccion" => 'required',
         "contacto"  => 'required',
         "telefono"  => 'required',
         "email"     => 'required',
      ]);
      $this->empresa = Auth::user()->empresa;

      Transportadora::create([
         "nombre"    => $this->nombre,
         "direccion" => $this->direccion,
         "contacto"  => $this->contacto,
         "telefono"  => $this->telefono,
         "email"     => $this->email,
         "empresa"   => $this->empresa,
      ]);


      session()->flash('message', $this->nombre.' fue creada correctamente.');

      $this->nombre       ="";
      $this->direccion    ="";
      $this->contacto     ="";
      $this->telefono     ="";
      $this->email        ="";
   }

   public function render()
   {
      return view('livewire.correspondencia.transpor', [

         'transportadoras' => Transportadora::where('empresa', Auth::user()->empresa)
                                             ->orderBy('nombre', 'ASC')
                                             ->get(),
      ]);
   }
}
