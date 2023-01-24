<?php

namespace App\Http\Livewire\Rifa;

use App\Boleta;
use App\Rifa;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Intervention\Image\Facades\Image;

class Gestion extends Component
{
   public $fecha;
   public $premio;
   public $boletas;
   public $numeros;
   public $cantidadboletas;
   public $responsable;
   public $valor;
   public $totalventa;
   public $metodo;
   public $idrifa='';
   public $rifastado='';
   public $foto;
   public $orga;
   public $usuarioven;
   public $cant;
   public $ganador;



   public function crear()
   {
      // Validar datos
      $this->validate([
         "fecha"         => 'required',
         "premio"        => 'required',
         "boletas"       => 'required',
         "numeros"       => 'required',
         "responsable"   => 'required',
         "valor"         => 'required',
         "metodo"        => 'required'

      ]);
      // crear Rifa
      $detallerifa = Rifa::create([
                     "fecha"         => $this->fecha,
                     "premio"        => $this->premio,
                     "boletas"       => $this->boletas,
                     "numeros"       => $this->numeros,
                     "responsable"   => $this->responsable,
                     "valor"         => $this->valor,
                     "metodo"        => $this->metodo
                  ]);
      // Cargar id
      $this->idrifa     =$detallerifa->id;
      $this->rifastado  =$detallerifa->estado;

      // Crear boletas y numeración

         for ($i=1; $i <= $this->cantidadboletas; $i++) {
            $creaboletas = Boleta::create([
               "idrifa"    => $this->idrifa,
               "vendedor"  => Auth::user()->id,
            ]);

            DB::table('numeros')->insert([
               "idboleta"    => $creaboletas->id,
               "idrifa"      => $this->idrifa,
               "numero"      => $i-1,
            ]);


         }



      session()->flash('message', 'Se creo la rifa con premio: '.$this->premio.' y fecha: '.$this->fecha );

      // liberar variables
      $this->fecha         = "";
      $this->premio        = "";
      $this->boletas       = "";
      $this->numeros       = "";
      $this->responsable   = "";
      $this->valor         = "";
      $this->metodo        = "";
      $this->orga          = "";
   }

   public function organiza($id)
   {
      $maximo = DB::table('numeros')
                  ->where('idrifa', $this->idrifa)
                  ->max('numero');

         $this->orga = $maximo+1;

         DB::table('numeros')->insert([
            "idboleta"    => $id,
            "idrifa"      => $this->idrifa,
            "numero"      => $this->orga,
         ]);
   }

   public function seleccionar($id)
   {
      $seleccion=Rifa::Where('id', $id)
                     ->first();

       // Cargar id y premio

      $this->idrifa           =$id;
      $this->fecha            =$seleccion->fecha;
      $this->premio           =$seleccion->premio;
      $this->boletas          =$seleccion->boletas;
      $this->numeros          =$seleccion->numeros;
      $this->responsable      =$seleccion->responsable;
      $this->valor            =$seleccion->valor;
      $this->metodo           =$seleccion->metodo;
      $this->rifastado        =$seleccion->estado;


   }

   public function asignaboletas()
   {
      // Validar datos
      $this->validate([
         "cant"         => 'required',
         "usuarioven"   => 'required'
      ]);

      // Asignar boletas
      // Selecciona boletas
      $asignarlas = Boleta::where('vendedor', Auth::user()->id)
                           ->where('idrifa', $this->idrifa)
                           ->select('id')
                           ->inRandomOrder()
                           ->limit($this->cant)
                           ->get();

      // Asigna recorrido
      foreach ($asignarlas as $asignarla) {

         Boleta::where('idrifa', $this->idrifa)
               ->where('id', $asignarla->id)
               ->update([
                  'vendedor' => $this->usuarioven,
               ]);
      }

      session()->flash('cant', 'Se asignaron: '.$this->cant.' boletas');

      $this->usuarioven = '';
      $this->cant       = '';

   }

   public function fin()
   {
      Rifa::where('id', $this->idrifa)
            ->update([
               'estado' => 2,
            ]);

      $this->rifastado = 2;
   }

   public function foto()
   {
      /*
      // Validar datos
      $this->validate([
            'foto'   => 'image|mimes:jpg,jpeg,png'
      ]);
      if($this->foto)
      {
         $idsig = DB::table('fotos')->max('id');

         $foto = $request->file('foto');
         $archivo = $request->correspondencia_id.'-'.$idsig.'.'.$foto->getClientOriginalExtension();
         $destino = public_path('entregas');

         // $request->foto->move($destino, $archivo); //este era el código anterior
         // Usando libreria intervention image
         Image::make($request->file('foto'))
               ->resize(600,450)
               ->save('entregas/'.$archivo);

         $ruta="../entregas/".$archivo;

         // Cargar la ruta en la BD
         Soportent::create([
            'correspondencia_id' => $request->correspondencia_id,
            'usuario'            => Auth::user()->id,
            'ruta'               => $ruta,
         ]);
      } */


   }

   public function fingana()
   {
      $ganadorifa = Boleta::join('numeros', 'numeros.idboleta', '=', 'boletas.id')
                           ->where('numeros.idrifa', $this->idrifa)
                           ->where('numeros.numero', $this->ganador)
                           ->select('boletas.comprador', 'boletas.telefono', 'boletas.email')
                           ->first();

      $actualiza = "Gano: ".$ganadorifa->comprador." Teléfono: ".$ganadorifa->telefono." Correo: ".$ganadorifa->email." ----"
                  .$this->premio;

      Rifa::Where('id', $this->idrifa)
            ->update([
               'premio' => $actualiza,
               'estado' => 3
            ]);

            session()->flash('mensajecierre', 'Se registro como ganador(a) a: '.$ganadorifa->comprador);

            $this->idrifa           ='';
            $this->fecha            ='';
            $this->premio           ='';
            $this->boletas          ='';
            $this->numeros          ='';
            $this->responsable      ='';
            $this->valor            ='';
            $this->metodo           ='';
            $this->rifastado        ='';
   }



   public function render()
   {
      if($this->numeros>0)
      {
         $this->cantidadboletas=$this->boletas/$this->numeros;
      }

      if($this->valor>0)
      {
         $this->totalventa=$this->valor*$this->cantidadboletas;
      }



      return view('livewire.rifa.gestion', [
         'rifasin'      => Rifa::orderBy('fecha', 'ASC')
                              ->get(),
         'boletasig'    =>  DB::table('numeros')
                           ->groupBy('idboleta')
                           ->select(DB::raw('count(numero) as asignados, idboleta'))
                           ->where('idrifa', $this->idrifa)
                           ->inRandomOrder()
                           //->orderBY('idboleta')
                           ->get(),
         'total'        =>  DB::table('numeros')
                              ->where('idrifa', $this->idrifa)
                              ->count('numero'),
         'usuarios'     => User::where('estado', 2)
                              ->where('empresa', 3)
                              ->select('name', 'id')
                              ->orderBy('name', 'ASC')
                              ->get(),

         'mias'         => DB::table('boletas')
                              ->where('vendedor', Auth::user()->id)
                              ->where('idrifa', $this->idrifa)
                              ->count(),
      ]);
   }
}
