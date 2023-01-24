<?php

namespace App\Http\Livewire\Usuarios;

use App\Adicional;
use App\Area;
use App\EmpresaUser;
use App\Sucursale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Detalle extends Component
{
   public $idusuario;
   public $name;
   public $username;
   public $empresa;
   public $sanguineo;
   public $sanguineoact;
   public $nacimiento;
   public $nacimientoact;
   public $adicioncuenta;
   public $direccion;
   public $telefono;
   public $direccionact='';
   public $telefonoact='';


   public function mount($userid)
   {
      $this->idusuario  = $userid->id;
      $this->name       = $userid->name;
      $this->username   = $userid->username;
      $this->empresa    = $userid->empresa;


   }

   // datos adicionales
   private function adicional()
   {
      $adicionact = Adicional::where('user_id', $this->idusuario)
                              ->first();

      if(!empty($adicionact)){
         $this->adicioncuenta = $adicionact->id;
      }

      if($this->adicioncuenta>0)
      {
         $this->sanguineoact  = $adicionact->sanguineo;
         $this->nacimientoact = $adicionact->nacimiento;
      } else {
         $this->sanguineoact  = '';
         $this->nacimientoact = '';
      }

      return $adicionact;
   }

   // Ubicación actual
   private function ubiactual()
   {
      return EmpresaUser::join('empresas', 'empresas.id', '=', 'empresa_users.empresa_id')
                        ->where('user_id', $this->idusuario)
                        ->where('empresa_id', $this->empresa)
                        ->select('empresa_users.*', 'empresas.nombre')
                        ->first();
   }

   // Direccion actual
   private function direactual()
   {
      $direactual = DB::table('usercontacto')
                  ->where('user_id', $this->idusuario)
                  ->orderBy('id', 'DESC')
                  ->first();

      if(!empty($direactual)){
         $this->direccionact  =  $direactual->direccion;
         $this->telefonoact   =  $direactual->telefono;
      }
   }

   // Sucursales para la empresa Actual
   private function sucursales()
   {
      return Sucursale::where('estado', 1)
                        ->where('empresa_id', $this->empresa)
                        ->select('id', 'nombre')
                        ->orderBy('nombre', 'ASC')
                        ->get();
   }

   //Áreas para la empresa Actual
   private function areas()
   {
      return Area::where('empresa_id', $this->empresa)
                  ->where('estado', 1)
                  ->select('id', 'area')
                  ->orderBy('area', 'ASC')
                  ->get();
   }

   // Crear direcciones - telefonos
   public function submit()
   {
      // Fecha de hoy
      $now = Carbon::now();

      $this->validate([
         "direccion" => 'required',
         "telefono"  => 'required',
      ]);

       // Inactivar datos anteiores
      DB::table('usercontacto')
      ->where('user_id', $this->idusuario)
      ->update([
         "estado"     => 0,
      ]);

      // Generar nuevo registro
      DB::table('usercontacto')
         ->insert([
            "fecha"     => $now,
            "user_id"   => $this->idusuario,
            "direccion" => $this->direccion,
            "telefono"  => $this->telefono,
         ]);

      session()->flash('mensdirec', 'Se actualizarón los datos');

      $this->direccion ="";
      $this->telefono  ="";

   }

   // Actualizar sanguineo
   public function modsanguineo()
   {
      if($this->adicioncuenta>0)
      {
         Adicional::where('user_id', $this->idusuario)
                  ->update([
                     'sanguineo' => $this->sanguineo,
                  ]);
      } else {
         Adicional::create([
            'user_id'   => $this->idusuario,
            'sanguineo' => $this->sanguineo,
            'estado'    => 2,
         ]);
      }

      session()->flash('sanguimen', '¡Se actualizo el grupo sanguineo!.');
   }

   // Actualizar fecha cumple
   public function modcumple()
   {
      if($this->adicioncuenta>0)
      {
         Adicional::where('user_id', $this->idusuario)
                  ->update([
                     'nacimiento' => $this->nacimiento,
                  ]);
      } else {

         Adicional::create([
            'user_id'   => $this->idusuario,
            'nacimiento' => $this->nacimiento,
            'estado'    => 2,
         ]);
      }

      session()->flash('nacimimen', '¡Se actualizo la fecha de nacimiento!.');
   }

   public function render()
   {
      return view('livewire.usuarios.detalle', [
         'ubiactual'    => $this->ubiactual(),
         'direactual'   => $this->direactual(),
         'adicional'    => $this->adicional(),
         'sucursales'   => $this->sucursales(),
         'areas'        => $this->areas(),
      ]);
   }
}
