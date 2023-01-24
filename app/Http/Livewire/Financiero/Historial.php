<?php

namespace App\Http\Livewire\Financiero;

use App\Obligacione;
use Livewire\Component;
use Livewire\WithPagination;

class Historial extends Component
{
    use WithPagination;

   public $ordena='id';
   public $ordenado='ASC';
   public $porpagina=20;
   public $buscar='';
   public $fechaini;
   public $fechafin;

   public function ordena($campo)
   {
      if($this->ordenado == 'ASC')
      {
         $this->ordenado = 'DESC';
      }else{
         $this->ordenado = 'ASC';
      }
      return $this->ordena = $campo;

   }

   // 

   // Listado de obligaciones
   private function obligaciones()
   {

      return Obligacione::query()                  
                  ->Buscar($this->buscar)
                  ->whereBetween('fecha', [$this->fechaini, $this->fechafin])
                  ->orderBy($this->ordena, $this->ordenado)
                  ->paginate($this->porpagina);
   }

    public function render()
    {
        return view('livewire.financiero.historial',[
            'obligaciones'          => $this->obligaciones(),
        ]);
    }
}
