<?php

namespace App\Http\Livewire\Humana;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Esquemacosto extends Component
{
   public $esquema;
   public $inicio;
   public $fin;
   public $idesquema;
   public $valor;
   public $val;



   // Crear Esquema
   public function submit()
   {
      $this->validate([
         "esquema"=> 'required',
         "inicio" => 'required',
         "fin"    => 'required',

      ]);


      DB::table('pagoesquema')
         ->insert([
            "esquema"=> $this->esquema,
            "inicio" => $this->inicio,
            "fin"    => $this->fin,
            "creo"   => Auth::user()->id,
         ]);

         // Selecciona recien creado
         $nuevo = DB::table('pagoesquema')
                     ->where('creo', Auth::user()->id)
                     ->select('id')
                     ->orderBy('id', 'DESC')
                     ->first();


      session()->flash('message', $this->esquema.' fue creado correctamente.');

      $this->esquema ="";
      $this->inicio  ="";
      $this->fin     ="";
      $this->idesquema = $nuevo->id;

   }

   // Seleccionar esquema
   public function ver($id)
   {
      $this->idesquema = $id;
   }

   // Liberar Esquema
   public function liberar()
   {
      $this->idesquema = "";
   }

   // Esquemas existentes
   private function esquemas()
   {
      return DB::table('pagoesquema')
               ->where('estado', '<=', 2)
               ->orderbY('estado', 'ASC')
               ->orderbY('esquema', 'ASC')
               ->get();
   }
   // Esquema seleccionado
   private function esquemaseleccionado()
   {
      if(!empty($this->idesquema)){
         return DB::table('pagoesquema')
               ->where('id', $this->idesquema)
               ->first();
      }
   }

   // Pagos Existentes
   private function pagosexistentes()
   {
      if(!empty($this->idesquema)){
         return DB::table('pagoperador')
               ->where('estado', 1)
               ->orderBy('cargo', 'ASC')
               ->get();
      }
   }

   // Asignar pago al esquema
   public function incluye($id)
   {
      if($this->valor>0)
      {
         // Verificar si ya existe el pago en el esquema
         $esta= DB::table('pagoesquedeta')
                  ->where('pago_id', $id)
                  ->where('esquema_id', $this->idesquema)
                  ->first();

         if($esta)
         {
            session()->flash('messaelim', 'Ya esta asignado el tipo de pago.');
            $this->valor="";
         } else {
            DB::table('pagoesquedeta')
            ->insert([
               "esquema_id"   => $this->idesquema,
               "pago_id"      => $id,
               "valor"        => $this->valor,
               "creo"         => Auth::user()->id,
            ]);

            session()->flash('messadet', $this->valor.' se asigno correctamente.');

            $this->valor="";
         }

      }
   }

   // Modificar valor del pago
   public function modval($id)
   {
      if($this->val>0)
      {
         DB::table('pagoesquedeta')
            ->where('id', $id)
            ->update([
               "valor"  => $this->val,
            ]);

            session()->flash('messavalor', '¡Se actualizo el valor a: '.$this->val.'!');
            $this->val= "";
      }
   }

   // Eliminar pago del esquema
   public function eliminar($id)
   {
      DB::table('pagoesquedeta')
         ->where("id", $id)
         ->delete();

         session()->flash('messaelim', '¡Se elimino corectamente el item!.');
   }

   // Pagos asignados al esquema actual
   private function pagosignado()
   {
      if(!empty($this->idesquema)){
         return DB::table('pagoesquedeta')
                  ->join('pagoperador', 'pagoperador.id', '=', 'pagoesquedeta.pago_id')
                  ->select('pagoesquedeta.valor', 'pagoesquedeta.id', 'pagoperador.cargo', 'pagoperador.descripcion', 'pagoperador.tipo')
                  ->where('pagoesquedeta.esquema_id', $this->idesquema)
                  ->where('pagoesquedeta.estado', 1)
                  ->orderBy('cargo', 'ASC')
                  ->get();
      }
   }

   // Finalizar Esquema
   public function finalizar()
   {
      DB::table('pagoesquema')
         ->where('id', $this->idesquema)
         ->update([
            'estado' => 2,
         ]);

         session()->flash('message', '¡Se activo correctamente el esquema!.');
   }

   public function render()
   {
      return view('livewire.humana.esquemacosto', [
         'esquemas' => $this->esquemas(),
         'esquemaseleccionado'  => $this->esquemaseleccionado(),
         'pagos'  => $this->pagosexistentes(),
         'pagosignados'  => $this->pagosignado(),
      ]);
   }
}
