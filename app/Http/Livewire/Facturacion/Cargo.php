<?php

namespace App\Http\Livewire\Facturacion;

use App\Producto;
use App\Cargo as Cargos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cargo extends Component
{
   public $cargo;
   public $descripcion;
   public $tipo;
   public $valor;
   public $factor;
   public $producto=[];
   //public $producto;

   // Crear cargo
   public function crear()
   {

      $this->validate([
         "cargo"           => 'required',
         "descripcion"     => 'required',
         "tipo"            => 'required',
         "valor"           => 'required',
         "factor"          => 'required',
         "producto"        => 'required',
      ]);

      foreach ($this->producto as $produc)
      {
         Cargos::create([
            'cargo'        => $this->cargo,
            'descripcion'  => $this->descripcion,
            'tipo'         => $this->tipo,
            'valor'        => $this->valor,
            'factor'       => $this->factor,
            'producto'     => $produc,
            'creo'         => Auth::user()->id,
         ]);
      }
      /*
      Cargos::create([
         'cargo'        => $this->cargo,
         'descripcion'  => $this->descripcion,
         'tipo'         => $this->tipo,
         'valor'        => $this->valor,
         'factor'       => $this->factor,
         'producto'     => $this->producto,
         'creo'         => Auth::user()->id,
      ]);*/

      session()->flash('message', $this->cargo.' fue creado correctamente.');

      $this->cargo         = "";
      $this->descripcion   = "";
      $this->tipo          = "";
      $this->valor         = "";
      $this->factor        = "";
      $this->producto      = "";
   }

   // Inactivar cargo
   public function inactivar($id)
   {
      Cargos::where('id', $id)
            ->update([
               'estado' => 0,
            ]);

      session()->flash('message', 'El cargo fue inactivado correctamente.');
   }

   public function render()
   {
      return view('livewire.facturacion.cargo',[
         'productos' => Producto::where('estado', 1)
                                 ->select('id', 'producto')
                                 ->orderbY('producto', 'ASC')
                                 ->get(),
         'cargos'    => Cargos::leftjoin('productos', 'productos.id', '=', 'cargos.producto')
                                 ->select(
                                    'cargos.id', 'cargos.cargo', 'cargos.descripcion', 'cargos.tipo',
                                    'cargos.valor', 'cargos.factor', 'cargos.producto', 'productos.producto as nomprod'
                                    )
                                 ->where('cargos.estado', 1)
                                 ->orderbY('cargos.cargo', 'ASC')
                                 ->get(),
      ]);
   }
}
