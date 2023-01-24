<?php

namespace App\Http\Livewire\Usuarios;

use App\User;
use Livewire\Component;

class Contrasena extends Component
{
   public $contrasena;
   public $contra;
   public $idusuario;
   public $usuarioname;

   public function mount($userid)
   {
      $this->idusuario  = $userid->id;
      $this->usuarioname = $userid->name;
   }

   public function cambiar()
   {
      if($this->contrasena===$this->contra)
      {
         $contrase = bcrypt($this->contra);

         User::where('id', $this->idusuario)
               ->update([
                  'password'  => $contrase,
               ]);
      }

      $this->reset(['contrasena', 'contra']);

      session()->flash('contrasena', '¡Se modifico la contrasena para: '.$this->usuarioname);
   }


   public function render()
   {
      return view('livewire.usuarios.contrasena');
   }
}
