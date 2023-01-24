<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\EmpresaUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

class AdicionalController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      //
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
      Gate::authorize('haveaccess','misdatos');

      $request->validate([
         'foto'          => 'image|mimes:jpg,jpeg,png|max:2048',
         'empresa_id'    => 'required',
         'sucursal_id'   => 'required',
         'area_id'       => 'required',
      ]);

      // Cargar fotografía
      if($request->foto){
         $foto = $request->file('foto');
         $archivo = $request->username.'.'.$foto->getClientOriginalExtension();
         $destino = public_path('usuarios');
         $request->foto->move($destino, $archivo);
         $ruta="../usuarios/".$archivo;

         // Actualizar ruta en la BD
         User::where('id', $request->user_id)
               ->update(['foto'=>$ruta]);

      }
      // Generar información adicional
      $adicional = Adicional::create($request->all());
      $nombre = 'Se registraron los datos correctamente.';


      // ACtualizar estado del usuario
      User::where('id', $request->user_id)
         ->update(['estado'=>$request->estado]);


      // Actualizar ubicación dentro de la empresa

      $sucu = $request->sucursal_id;
      $sucursal = explode('-',$sucu);
      $sucursal_id = $sucursal[0];
      $sucurname = $sucursal[1];

      $area = $request->area_id;
      $area = explode('-',$area);
      $area_id = $area[0];
      $areaname = $area[1];



      $empresausuario =EmpresaUser::where('empresa_id', $request->empresa_id)
                     ->where('user_id', $request->user_id)
                     ->update([
                           'sucursal_id' => $sucursal_id,
                           'sucursal'    => $sucurname,
                           'area_id'     => $area_id,
                           'area'        => $areaname
                           ]);


         //return compact('request','adicional', 'empresausuario');
      return redirect()->route('user.edit',$adicional->user_id)
         ->with('status_success', $nombre);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Adicional  $adicional
    * @return \Illuminate\Http\Response
    */
   public function show(Adicional $adicional)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Adicional  $adicional
    * @return \Illuminate\Http\Response
    */
   public function edit(Adicional $adicional)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Adicional  $adicional
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Adicional $adicional)
   {
      $this->authorize('haveaccess','misdatos');

      if($request->consul==""){

         $request->validate([
               'foto'          => 'image|mimes:jpg,jpeg,png|max:2048',
               'empresa_id'    => 'required',
               'sucursal_id'   => 'required',
               'area_id'       => 'required',

         ]);

      }

      $adicional->update($request->all());

      // Cargar fotografía
      if($request->foto != ""){

         $foto = $request->file('foto');
         $archivo = $request->username.'.'.$foto->getClientOriginalExtension();
         $destino = public_path('usuarios');
         $request->foto->move($destino, $archivo);
         $ruta="../usuarios/".$archivo;

         // Actualizar ruta en la BD
         User::where('id', $adicional->user_id)
               ->update([ 'foto' => $ruta ]);

      }


      $nombre = 'Se actualizo correctamente la información';


      return redirect()->route('user.edit',$adicional->user_id)
      ->with('status_success', $nombre);
   }



   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Adicional  $adicional
    * @return \Illuminate\Http\Response
    */
   public function destroy(Adicional $adicional)
   {
      //
   }

   public function foto(Request $request)
   {

      Gate::authorize('haveaccess','misdatos');

      $request->validate([
         //'foto'          => 'image|mimes:jpg,jpeg,png|max:2048',
         'foto'   => 'image|mimes:jpg,jpeg,png',
         'foto'   => 'required',
      ]);

      // Cargar fotografía
      if($request->foto)
      {
         $foto = $request->file('foto');
         $archivo = $request->username.'.'.$foto->getClientOriginalExtension();
         $destino = public_path('usuarios');
         Image::make($request->file('foto'))
               ->resize(600,450)
               ->save('usuarios/'.$archivo);

         $ruta="../usuarios/".$archivo;

         // Actualizar ruta en la BD
         User::where('id', $request->idusuario)
               ->update([ 'foto' => $ruta ]);

      $nombre = 'Se actualizo correctamente la información';


      return redirect()->route('user.edit',$request->idusuario)
      ->with('status_success', $nombre);
      }

   }
}
