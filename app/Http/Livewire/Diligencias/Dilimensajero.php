<?php

namespace App\Http\Livewire\Diligencias;

use App\Caja;
use App\Diligencia;
use App\Dilioperador;
use App\Prepago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
//use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;

class Dilimensajero extends Component
{
   use WithFileUploads;
   use WithPagination;
   

   public $diliactual;
   public $estadoactual;
   public $observacionesactual;   
   public $observaciones;
   public $fotico;
   public $imagentrega;
   public $entrego;
   public $imag;
   public $control;
   public $pago;


   public $ordena='id';
   public $ordenado='ASC';
   public $porpagina=2;
   public $inicio;
   public $fin;

   // CONTROLES DE BUSQUEDAS
   public function ordena($campo)
   {
      if($this->ordenado == 'ASC')
      {
         $this->ordenado = 'DESC';
      }else{
         $this->ordenado = 'ASC';
      }
      return $this->ordena = $campo;

      $this->misdiligencias();

   }

   // Diligencias asignadas a este operador
   private function diligencias()
   {
      return Dilioperador::where('usuario_id', Auth::user()->id)
                           ->where('estado', 1)
                           ->get();
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

   // Listado de diligencias en un período
   private function misdiligencias()
   {
      if(!empty($this->inicio) && !empty($this->fin))
      {
         return Diligencia::join('dilioperadors', 'diligencias.id', '=', 'dilioperadors.diligencia_id')
                           ->where('dilioperadors.usuario_id', Auth::user()->id)
                           ->whereBetween('diligencias.fecha', [$this->inicio, $this->fin])
                           ->select('diligencias.id', 'diligencias.recoge', 'diligencias.entrega', 'diligencias.fecha',
                                    'diligencias.comentarios', 'diligencias.observaciones', 'diligencias.guias', 'dilioperadors.estado')
                           ->orderBy($this->ordena, $this->ordenado)
                           ->paginate($this->porpagina);
      }
   }

   // Diligencia actual
   private function diligenciactual()
   {
      if(!empty($this->diliactual)){
         $actual =  Diligencia::where('id', $this->diliactual)->first();
         $this->diliactual = $actual->id;
         $this->estadoactual = $actual->estado;
         $this->observacionesactual = $actual->observaciones;
         return $actual;
      }
   }

   // Ver imagenes
   public function imagenes($id)
   {
      $this->reset();
      $this->imag = $id;
      $this->control=1;
      $this->diliactual;
      $this->imagenesta();
   }

   // Recibir diligencia
   public function recibir($id)
   {
      $this->diliactual = Diligencia::where('id', $id)->first();
      // Cargar observación
      

      $now = Carbon::now();

      $observa = "---".$now." ".Auth::user()->name.": RECIBIO LA DILIGENCIA. --".$this->diliactual->observaciones;

      Diligencia::where('id', $id)
                  ->update([
                     'estado'          => 3,
                     'observaciones'   => $observa,
                  ]);

      // Emitir información
      session()->flash('suceso', 'Se cargo la diligencia: '. $id.' a su poder.');

      $this->reset();
   }

   // Modal cierre
   public function modalcierre($id, $control)
   {
      $this->reset();
      $this->diliactual = $id;
      $this->control = $control;
      $this->diligenciactual();
   }
   public function modalcierre1($id, $control)
   {
      $this->reset();

      $this->diliactual = Diligencia::where('id', $id)->first();

      $usa = Prepago::where('empresa_id', $this->diliactual->empresa_id)
                     ->count();

      if($usa>=1){
         $this->prepa = $usa;
      }

      $this->control = $control;

   }


    // Cerrar el modal
   public function cancelar()
   {
      $this->reset();
   }

   // Cargar foto y observaciones
   public function cargaimagenobser()
   {
 
      $this->validate([
         'observaciones'   => 'required',
         'entrego'         => 'required',
         //'fotico'          => 'required|image',
         'imagentrega'     => 'required|image',
      ]);

      // Cerro el envío
      if($this->entrego==1)
      {
         $estado = 4;
         $this->observaciones = "¡¡ENTREGO!! ".$this->observaciones;

      }else{
         $estado = $this->estadoactual;
      }

      $now = Carbon::now();

      $observa = "---".$now." ".Auth::user()->name.": ".$this->observaciones." --".$this->observacionesactual;

      // Cargar imagen
         //mayor numero
         $ididen = DB::table('dilifoto')
         ->max('id');

         $ididen = $ididen+1;

         $iddiligencia = $this->diliactual; 

         // Envía imagen al servidor
         $fotonom = $iddiligencia.'-'.Auth::user()->id.'-'.$ididen.'.'.$this->imagentrega->getClientOriginalExtension();     
         //$fotonom = $this->fotico->hashName();
         $this->imagentrega->storeAs('diligencias', $fotonom, 'public_soportes');
         $rutafoto = "../diligencias/".$fotonom;

         // REdimensionar la imagen
         Image::make($this->imagentrega)
               ->resize(600,600)
               ->save('diligencias/'.$fotonom);

         // Cargar ruta al sitema
         DB::table('dilifoto')
         ->insert([
         'usuario_id'      => Auth::user()->id,
         'diligencia_id'   => $iddiligencia,
         'ruta'            => $rutafoto,
         'created_at'      => $now,
         'updated_at'      => $now,
         ]);
      
      Diligencia::where('id', $this->diliactual)
                  ->update([
                     'observaciones'   => $observa,
                     'estado'          => $estado,
                  ]);

      


      // Emitir información
      session()->flash('suceso', 'Se cargo correctamente la imagen y observación para la diligencia: '. $iddiligencia);

      $this->reset();
   }

   // Finalizar diligencia
   public function finalizar()
   {
      $this->validate([
         'observaciones'   => 'required',
      ]);

      $now = Carbon::now();

      $observa = " --- ".$now." ".Auth::user()->name.": LEGALIZO/FINALIZO. ".$this->observaciones." -- ".$this->observacionesactual;

      Diligencia::where('id', $this->diliactual)
                  ->update([
                     'observaciones'   => $observa,
                     'estado'          => 9,
                  ]);

      $mensaje = "Se finalizo correctamente la diligencia N°: ".$this->diliactual;

      // Cargar pago
      if(!empty($this->pago))
      {
         $movimiento = "Pago de la diligencia N°: ".$this->diliactual;

         $obspago = "Se recibio pago por: ".$this->pago;

         $observa = " --- ".$now." ".Auth::user()->name.": "."RECIBIO PAGO POR: $".$this->pago." -- ".$observa;

         $rutafoto = "../caja/billete10.jpg";

         Caja::create([
            "movimiento"      => $movimiento,
            "tipo"            => "e",
            "valor"           => $this->pago,
            "descripcion"     => $obspago,
            "imagen"          => $rutafoto,
            "usuario"         => Auth::user()->name,
            "user_id"         => Auth::user()->id,
            "financiero_id"   => 1,
         ]);

         Diligencia::where('id', $this->diliactual)
                  ->update([
                     'observaciones'   => $observa,
                  ]);

         $mensaje = "Se cargarón: $ ".number_format($this->pago, 0, ',', ' ')." a sus registros. ".$mensaje;
      }


      // Emitir información
      session()->flash('suceso', $mensaje);

      $this->reset();
   }

   // Activar busquedas
   public function busca()
   {
      $this->control = 4;
   }

   // resetear busqueda
   public function limpiar()
   {
      $this->reset();
      $this->control=4;
   }
   public function render()
   {
      return view('livewire.diligencias.dilimensajero', [
         'diligencias'           => $this->diligencias(),
         'imagenesta'            => $this->imagenesta(),
         'misdiligencias'        => $this->misdiligencias(),
         'diligenciactual'       => $this->diligenciactual(),

      ]);
   }
}
