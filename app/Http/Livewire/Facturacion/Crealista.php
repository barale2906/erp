<?php

namespace App\Http\Livewire\Facturacion;

use App\Empresa;
use App\Lp;
use App\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Crealista extends Component
{
   public $lista;
   public $inicio;
   public $fin;
   public $listar;
   public $inicior;
   public $finr;
   public $idlista;
   public $nombrelista;
   public $asigna;
   public $actfin;
   public $idemp;
   public $idproduct;
   public $alias;
   public $valor;
   public $alia;
   public $valo;
   public $accion;

   // Crea nueva lista
   public function submit()
   {
      $this->validate([
         "lista"     => 'required',
         "inicio"    => 'required',
         "fin"       => 'required',

      ]);


      $listanueva = Lp::create([
                        'lista'  => $this->lista,
                        'inicio' => $this->inicio,
                        'fin'    => $this->fin,
                        'creo'   => Auth::user()->id,
                     ]);

      session()->flash('message', $this->lista.' fue creada correctamente.');

      $this->lista   ="";
      $this->inicio  ="";
      $this->fin     ="";
      $this->idlista = $listanueva->id;
   }
   // Selecciona lista a ver
   public function ver($id)
   {
      $this->idlista = $id;
   }
   // Insertar clientes a la lista
   public function seleccionar($id)
   {
      DB::table('lpclies')->insert([
         'lp'        => $this->idlista,
         'cliente'   => $id,
         'creo'      => Auth::user()->id,
      ]);
   }
   // Elimina clientes de la lista
   public function eliminar($id)
   {
      DB::table('lpclies') ->where('cliente', $id)
                           ->where('lp', $this->idlista)
                           ->delete();
   }
   // Datos de la lista actual
   private function listasel()
   {
      $actual = Lp::where('id', $this->idlista)
                  ->select('id', 'lista', 'inicio', 'fin', 'estado')
                  ->first();

      return $actual;
   }
   // Listado de empresas
   private function empresa()
   {
      return Empresa::select('empresas.id', 'empresas.nombre')
                     ->where('empresas.estado', 1)
                     ->where('id', '>=', 2)
                     ->where('id', '!=', 3)
                     ->orderBy('nombre', 'ASC')
                     ->get();
   }
   // Selecciona id de empresa
   public function detalle($id)
   {
      $this->idemp = $id;
      $this->asigna = "";

   }
   // Selecciona id de producto
   public function selproduc($id)
   {
      $this->idproduct = $id;
   }
   // Selecciona datos de la empresa especifica
   private function empresaagreg()
   {
      /*
      if($this->idemp!=""){
         return Empresa::where('empresas.id', $this->idemp)
                           ->select('empresas.nombre', 'empresas.id')
                           ->get();
      }else{
         return Empresa::where('empresas.id', 1)
                           ->select('empresas.nombre', 'empresas.id')
                           ->get();
      } */

      return Empresa::where('empresas.id', $this->idemp)
      ->select('empresas.nombre', 'empresas.id')
      ->get();

   }
   // Verifica asignación a otras listas de la empresa actual
   private function detalles()
   {
      $listactual = $this->listasel();
      //$this->listaini = $listactual->inicio;
      $listasigs = Empresa::join('lpclies', 'lpclies.cliente', '=', 'empresas.id')
                           ->join('lps', 'lps.id', '=', 'lpclies.lp')
                           ->where('lps.estado', '<=', 2)
                           ->where('empresas.id', $this->idemp)
                           ->select('empresas.nombre', 'empresas.id', 'lps.id', 'lps.lista', 'lps.inicio', 'lps.fin')
                           ->get();

      foreach($listasigs as $listasig)
      {
         // Verificar que este asignado a esta lista
         if($listactual->id == $listasig->id)
         {
            $this->asigna = 1;
            session()->flash('actual', 'Ya esta asignada a esta lista: '.$listasig->lista);
         }

         // Verifica que la lista no intersecta por debajo
         if($this->asigna==""){
            if($listactual->inicio >= $listasig->inicio && $listactual->inicio <= $listasig->fin)
               {
                  $this->asigna = 1;
                  session()->flash('debajo', 'Esta asignado a la lista: '.$listasig->lista);
               }
         }
         if($this->asigna==""){
            // Verifica que la lista no intersecta por arriba
            if($listactual->fin  >= $listasig->inicio && $listactual->fin <= $listasig->fin)
               {
                  $this->asigna = 1;
                  session()->flash('encima', 'Esta asignado a la lista: '.$listasig->lista);
               }
         }

         if($this->asigna==""){
            // Verifica que la lista no este dentro
            if($listactual->inicio  <= $listasig->inicio && $listactual->fin >= $listasig->fin)
               {
                  $this->asigna = 1;
                  session()->flash('dentro', 'Esta asignado a la lista: '.$listasig->lista);
               }
         }


         if($this->asigna==""){
            // Verifica que la lista no contenga la actual
            if($listactual->inicio  >= $listasig->inicio && $listactual->fin <= $listasig->fin)
               {
                  $this->asigna = 1;
                  session()->flash('contiene', 'Esta asignado a la lista: '.$listasig->lista);
               }
         }
      }

      return $this->asigna;
   }
   // Empresas asignadas a la lista actual
   private function empresel()
   {
      return Empresa::rightjoin('lpclies', 'empresas.id', '=', 'lpclies.cliente')
                     ->where('lpclies.lp', $this->idlista)
                     ->where('empresas.estado', 1)
                     ->select('empresas.id', 'empresas.nombre')
                     ->orderBy('nombre', 'ASC')
                     ->get();
   }
   // Listado de productos
   private function producto()
   {
      return Producto::where('estado', 1)
                     ->orderBy('producto', 'ASC')
                     ->get();
   }
   // Detalles del producto seleccionado
   private function detaproducto()
   {
      return Producto::where('id', $this->idproduct)
                        ->select('producto', 'tipo')
                        ->first();
   }
   // Verifica si el producto esta seleccionado para esta lista
   private function estadoproduc()
   {
      $estado = DB::table('lppros')
               ->where('producto', $this->idproduct)
               ->where('lp', $this->idlista)
               ->count();

      return $estado;
   }
   // Cargar producto a la lista de precios
   public function carga()
   {
      $this->validate([
         "alias"     => 'required',
         "valor"    => 'required',
      ]);


      DB::table('lppros')->insert([
                  'lp'        => $this->idlista,
                  'producto'  => $this->idproduct,
                  'alias'     => $this->alias,
                  'valor'     => $this->valor,
                  'creo'      => Auth::user()->id,
               ]);

      session()->flash('message', 'Se cargo correctamente el producto con alias: '.$this->alias);

      $this->alias      ="";
      $this->valor      ="";
      $this->idproduct  ="";

   }
   // Eliminar producto
   public function elimproduc($id)
   {
      DB::table('lppros') ->where('producto', $id)
                           ->where('lp', $this->idlista)
                           ->delete();
   }
   // Productos asignados a la lista
   private function productosel()
   {
      return Producto::join('lppros', 'lppros.producto', '=', 'productos.id')
                     ->where('lppros.estado', 1)
                     ->where('lppros.lp', $this->idlista)
                     ->orderBy('productos.producto', 'ASC')
                     ->select('productos.id', 'productos.producto', 'productos.tipo', 'lppros.alias', 'lppros.valor')
                     ->get();
   }
   // Modifica alias del producto en la lista
   public function modalias($id)
   {
      if($this->alia != ""){

         DB::table('lppros')
                  ->where('producto', $id)
                  ->where('lp', $this->idlista)
                  ->update([
                     'alias' => $this->alia,
                  ]);

         $this->alia = '';
      }
   }
   // Modifica valor del producto
   public function modvalor($id)
   {
      if($this->valo != ""){

         DB::table('lppros')
                  ->where('producto', $id)
                  ->where('lp', $this->idlista)
                  ->update([
                     'valor' => $this->valo,
                  ]);

         $this->valo = '';
      }
   }
   // Asigna valor a la accion a seguir con la lista
   public function accion($id)
   {
      $this->accion = $id;
   }
   // elimina valor a la accion a seguir con la lista
   public function noaccion()
   {
      $this->accion = "";
   }
   // Activa formulario para reutilizar la lista de precios
   public function reutilizalista()
   {
      // Crear lista nueva
      $now = Carbon::now();
      $this->listar = 'Reutilizar lista'.$now;

   }
   // Reutiliza lista de precios
   public function reuti()
   {
      // Seleccion lista actual
      $listabase = Lp::where('id', $this->idlista)->first();

      if($listabase->fin < $this->inicior && $this->inicior < $this->finr){

          // Crear lista nueva
         $this->validate([
            "listar"     => 'required',
            "inicior"    => 'required',
            "finr"       => 'required',
         ]);

         $nuelis = Lp::create([
                     'lista'  => $this->listar,
                     'inicio' => $this->inicior,
                     'fin'    => $this->finr,
                     'creo'   => Auth::user()->id,
         ]);
         // Seleccionar clientes
         $clientes = DB::table('lpclies')
                        ->where('lp', $this->idlista)
                        ->select('cliente')
                        ->get();

            foreach($clientes as $cliente)
            {
               DB::table('lpclies')->insert([
                  'lp'        => $nuelis->id,
                  'cliente'   => $cliente->cliente,
                  'creo'      => Auth::user()->id,
               ]);
            }
         // Seleccionar productos
         $productos = DB::table('lppros')
                        ->where('lp', $this->idlista)
                        ->select('producto', 'alias', 'valor')
                        ->get();

            foreach($productos as $producto)
            {
               DB::table('lppros')->insert([
                  'lp'        => $nuelis->id,
                  'producto'  => $producto->producto,
                  'alias'     => $producto->alias,
                  'valor'     => $producto->valor,
                  'creo'      => Auth::user()->id,
               ]);
            }

         session()->flash('listaope', '¡SE GENERO LA LISTA: '.$nuelis->lista.'!');
         $this->idlista = $nuelis->id;
         $this->listar = "";
         $this->inicior= "";
         $this->finr   = "";
         $this->accion = "";
      } else {
         session()->flash('listaope', '¡VERIFIQUE LAS FECHAS ASIGNADAS A LA LISTA: '.$this->listar.'!');
      }


   }
   // Activa lista de precios
   public function activalista()
   {
      Lp::where('id', $this->idlista)
         ->update([
            'estado' => 2,
         ]);


      session()->flash('listaope', '¡SE ACTIVO CORRECTAMENTE LA LISTA!');

      $this->accion = "";
   }
   // inactiva lista de precios
   public function inactivalista()
   {
      Lp::where('id', $this->idlista)
         ->update([
            'estado' => 3,
         ]);

      DB::table('lpclies')
         ->where('lp', $this->idlista)
         ->update([
            'estado' => 0,
         ]);

      DB::table('lppros')
         ->where('lp', $this->idlista)
         ->update([
            'estado' => 0,
         ]);


      session()->flash('listaope', '¡SE INACTIVO CORRECTAMENTE LA LISTA!');
      $this->idlista = "";
      $this->accion = "";
   }
   // Elimina lista de precios
   public function eliminalista()
   {
      DB::table('lppros')->where('lp', $this->idlista)->delete();
      DB::table('lpclies')->where('lp', $this->idlista)->delete();
      Lp::where('id', $this->idlista)->delete();


      session()->flash('listaope', '¡SE ELIMINO CORRECTAMENTE LA LISTA!');
      $this->idlista = "";
      $this->accion = "";
   }

   public function render()
   {

      return view('livewire.facturacion.crealista', [
         'listas'          => DB::table('lps')
                                 ->where('estado', '<=', 2)
                                 ->orderBy('estado', 'ASC')
                                 ->get(),
         'idlista'         => $this->idlista,
         'idemp'           => $this->idemp,
         'idproduct'       => $this->idproduct,
         'listar'          => $this->listar,
         'empresas'        => $this->empresa(),
         'empreses'        => $this->empresel(),
         'listasel'        => $this->listasel(),
         'productos'       => $this->producto(),
         'productosels'    => $this->productosel(),
         'empresaagreg'    => $this->empresaagreg(),
         'detalles'        => $this->detalles(),
         'detaproducto'    => $this->detaproducto(),
         'estadoproduc'    => $this->estadoproduc(),
      ]);
   }
}
