<?php

namespace App\Http\Livewire\Diligencias;

use App\Diligencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Historial extends Component
{
   use WithPagination;

   public $ordena='id';
   public $ordenado='ASC';
   public $porpagina=5;
   public $buscar='';

   public $diligenciaid;
   public $control;

   // Asignar control
   public function buscarfotos($id)
   {
      $this->diligenciaid = $id;
      $this->control='';
   }

   // Cerrar modal
   public function cerrarmodal()
   {
      $this->reset();
   }

   // Seleccionar las imagenes
   private function fotosdili()
   {
      if($this->diligenciaid)
      {
         $hay = DB::table('dilifoto')->count();

         if($hay>0){
            $this->control=1;

            return DB::table('dilifoto')
                     ->where('diligencia_id', $this->diligenciaid)
                     ->get();
         }
      }
   }

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

   // Listado de Diligencias
   private function diligencias()
   {

      return Diligencia::query()
                  ->where('empresa_id', Auth::user()->empresa)
                  ->Buscar($this->buscar)
                  ->orderBy($this->ordena, $this->ordenado)
                  ->paginate($this->porpagina);
   }

   public function render()
   {
      return view('livewire.diligencias.historial', [
         'diligencias'     => $this->diligencias(),
         'fotosdili'       => $this->fotosdili(),
      ]);
   }
}
