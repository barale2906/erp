<?php

namespace App\Http\Livewire\Usuarios;

use App\User;
use Illuminate\Http\Request;
use Livewire\Component;

class Activar extends Component
{
   public $idusuario;
   public $estado;
   public $estadocam;

   public function mount($userid)
   {
      $this->idusuario  = $userid->id;
      $this->estado     = $userid->estado;
   }

   public function submit()
   {
      User::where('id', $this->idusuario)
            ->update([
               'estado'    => $this->estadocam,
            ]);

      session()->flash('menestado', '¡Se actualizo el estado del usuario!.');

   }

   public function render()
   {
      return view('livewire.usuarios.activar');
   }
}
