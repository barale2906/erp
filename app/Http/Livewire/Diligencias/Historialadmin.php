<?php

namespace App\Http\Livewire\Diligencias;

use App\Diligencia;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Historialadmin extends Component
{
   use WithPagination;

   public $ordena='id';
   public $ordenado='ASC';
   public $porpagina=5;
   public $buscar='';

   public $imag;
   public $control=0;

   // orden de la tabla
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

   // Cerrar el modal
   public function cancelar()
   {
      $this->reset();
   }

   // Ver imagenes
   public function imagenes($id)
   {
      $this->reset(['imag']);
      $this->imag = $id;
   }

   // Imagenes de cada envío
   private function imagenesta()
   {
      if($this->imag)
      {
         $imagenes = DB::table('dilifoto')
                        ->where('diligencia_id', $this->imag)
                        ->get();

         if($imagenes->count()){
            $this->control=1;
            return $imagenes;
         }
      }
   }

   // Listado de Diligencias
   private function diligencias()
   {
      return Diligencia::query()
                  ->Buscar($this->buscar)
                  ->orderBy($this->ordena, $this->ordenado)
                  ->paginate($this->porpagina);
   }

   public function render()
   {
      return view('livewire.diligencias.historialadmin', [
         'diligencias'     => $this->diligencias(),
         'imagenesta'      => $this->imagenesta(),
      ]);
   }
}
