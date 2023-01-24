<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\Area;
use App\Correspondencia;
use App\EmpresaUser;
use App\Sucursale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EmpresaUserController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      Gate::authorize('haveaccess','misdatos');




      $sucursales = Sucursale::where('empresa_id', Auth::user()->empresa)
                     ->where('estado', 1)
                     ->select('id', 'nombre')
                     ->get();

      $areas = Area::where('empresa_id', Auth::user()->empresa )
                  ->where('estado', 1)
                  ->select('id', 'area')
                  ->get();



      //return compact('programado', 'sucursales', 'areas');
      return view('correspondencia.envioshoy', compact('sucursales', 'areas'));
   }


   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      Gate::authorize('haveaccess','empresa.asigna');

      $request->validate([
         'empresa_id'        => 'required',
         'sucursal_id'       => 'required',
         'area_id'           => 'required',
         'role_id'           => 'required'
      ]);

      // Obtener datos base.

      if($request->asignaempresa ==1 ){
         $allsucur = Sucursale::where('id', $request->sucursal_id)
                     ->first();
         $allarea = Area::Where('id', $request->area_id)
                     ->first();

         $sucursal_id= $allsucur->id;
         $sucurname  = $allsucur->nombre;
         $area_id    = $allarea->id;
         $areaname   = $allarea->area;

      } else {
         $sucu = $request->sucursal_id;
         $sucursal = explode('-',$sucu);
         $sucursal_id = $sucursal[0];
         $sucurname = $sucursal[1];

         $area = $request->area_id;
         $area = explode('-',$area);
         $area_id = $area[0];
         $areaname = $area[1];
      }


      // Eliminar otras combinaciones de este usuario en la misma empresa

      EmpresaUser::where('empresa_id', $request->empresa_id)
                  ->where('user_id', $request->user_id)
                  ->delete();
      // Insertar nuevo registro
      $empresaUser = EmpresaUser::create([
         'role_id'       => $request->role_id,
         'user_id'       => $request->user_id,
         'name'          => $request->nombre_usuario,
         'empresa_id'    => $request->empresa_id,
         'sucursal_id'   => $sucursal_id,
         'sucursal'      => $sucurname,
         'area_id'       => $area_id,
         'area'          => $areaname,
      ]);

      $nombre="Se asigno corretcamente la nueva empresa a: ".$request->nombre_usuario;

      return redirect()->route('user.edit',$empresaUser->user_id)
         ->with('status_success', $nombre);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\EmpresaUser  $empresaUser
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      $this->authorize('haveaccess','misdatos');
      $empresauser = EmpresaUser::where('id', $id)
                     ->first();


      return compact('empresauser');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\EmpresaUser  $empresaUser
    * @return \Illuminate\Http\Response
    */
   public function edit(EmpresaUser $empresaUser)
   {
      $this->authorize('haveaccess','misdatos');


      return compact('empresauser');

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\EmpresaUser  $empresaUser
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {


   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\EmpresaUser  $empresaUser
    * @return \Illuminate\Http\Response
    */
   public function destroy(EmpresaUser $empresaUser)
   {
      //
   }

   public function rifa(Request $request)
   {
      // Insertar nuevo registro
      EmpresaUser::where('user_id', Auth::user()->id)
                  ->where('empresa_id', Auth::user()->empresa)
                  ->update([
                     'role_id'       => 7,
                     'name'          => Auth::user()->name,
                     'empresa_id'    => 3,
                     'sucursal_id'   => 4,
                     'sucursal'      => "Chaquetas Prom Principal",
                     'area_id'       => 8,
                     'area'          => "Gerencia General",
                  ]);

         User::where('id', Auth::user()->id)
               ->update([
                  'estado' => 2,
               ]);

         DB::table('role_user')
            ->where('user_id', Auth::user()->id)
            ->update([
               'role_id' => 7,
            ]);



      return redirect()->route('ventarifa');

   }

   public function actualizar(Request $request)
   {
      // Actualizar ubicación dentro de la empresa

      $sucu = $request->sucursal_id;
      $sucursal = explode('-',$sucu);
      $sucursal_id = $sucursal[0];
      $sucurname = $sucursal[1];

      $area = $request->area_id;
      $area = explode('-',$area);
      $area_id = $area[0];
      $areaname = $area[1];


      EmpresaUser::where('empresa_id', $request->empresa_id)
         ->where('user_id', $request->user_id)
         ->update([
               'sucursal_id'  => $sucursal_id,
               'sucursal'     => $sucurname,
               'area_id'      => $area_id,
               'area'         => $areaname,
               ]);

      User::where('id', $request->user_id)
            ->update([
               'estado' => 2,
            ]);

      // Verificar existencia en adicionals
      $existe = Adicional::where('user_id', $request->user_id)
                           ->first();

      // Generar registro
      if(empty($existe)){
         Adicional::create([
            'user_id'   => $request->user_id,
            'estado'    => 2,
         ]);
      }

      $nombre = 'Se actualizó la ubicación correctamente.';

      //return compact('request','adicional', 'empresausuario');
      return redirect()->route('user.edit',$request->user_id)
      ->with('status_success', $nombre);
   }
}
