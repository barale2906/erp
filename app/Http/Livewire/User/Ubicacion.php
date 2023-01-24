<?php

namespace App\Http\Livewire\User;

use App\Adicional;
use App\Area;
use App\EmpresaUser;
use App\Sucursale;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Ubicacion extends Component
{
   public $sucursal;
   public $area;

   // Listado de áreas
   private function areas()
   {
      return Area::where('empresa_id', Auth::user()->empresa)
                  ->select('id', 'area')
                  ->orderBy('area')
                  ->get();
   }

   // Listado de sucursales
   private function sucursales()
   {
      return Sucursale::where('empresa_id', Auth::user()->empresa)
                        ->select('id', 'nombre')
                        ->orderBy('nombre')
                        ->get();
   }

   // Cargar ubicación
   public function ubicacion()
   {
      $sucur = Sucursale::where('id', $this->sucursal)->select('nombre')->first();
      $are = Area::where('id', $this->area)->select('area')->first();

      EmpresaUser::where('empresa_id', Auth::user()->empresa)
         ->where('user_id', Auth::user()->id)
         ->update([
               'sucursal'     => $sucur->nombre,
               'sucursal_id'  => $this->sucursal,
               'area'         => $are->area,
               'area_id'      => $this->area,
               ]);

      User::where('id', Auth::user()->id)
            ->update([
               'estado' => 2,
            ]);


      Adicional::create([
         'user_id'   => Auth::user()->id,
         'estado'    => 2,
      ]);


      $this->reset();


//      $nombre = 'Se actualizó la ubicación correctamente.';

      //return compact('request','adicional', 'empresausuario');
      redirect()->route('home');
   }


   public function render()
   {
      return view('livewire.user.ubicacion',[
               'areas'        => $this->areas(),
               'sucursales'   => $this->sucursales(),
      ]);
   }
}
