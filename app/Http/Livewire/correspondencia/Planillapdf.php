<?php

namespace App\Http\Livewire\Correspondencia;

use App\Planilla;
use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;

class Planillapdf extends Component
{
   public $idplanilla;

   protected $listeners = ['edita'];

   public function edita($id)
   {
      $this->idplanilla = $id;
   }

   public function render()
   {
      return view('livewire.correspondencia.planillapdf', [
         'idplanilla' => $this->idplanilla,
      ]);
   }
}
