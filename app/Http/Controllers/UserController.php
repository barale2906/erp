<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\Empresa;
use App\EmpresaUser;
use App\Role;
use App\Salario;
use App\Soporte;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

      Gate::authorize('haveaccess','user.index');

      //$users = User::orderBy('id','Asc')->paginate(8);

      //return view('user.index',compact('users'));

      //$users = User::all();

      return datatables()
      ->eloquent(User::query())
      //->eloquent($users)
      ->addColumn('accion', 'user.adicionales' )
      ->rawColumns(['accion'])
      ->toJson();

   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {

   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show(User $user)
   {
      $this->authorize('haveaccess','user.show');


      return view('user.view', compact('user'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit(User $user)
   {
      $this->authorize('haveaccess','misdatos');


      $adicional = Adicional::where('user_id', $user->id)->orderBy('id', 'DESC')
                     ->first();
      $direactual = DB::table('usercontacto')
                     ->where('user_id', $user->id)
                     ->orderBy('id', 'DESC')
                     ->first();
      $soportes = Soporte::where('user_id', $user->id)
                  ->orderBy('vencimiento', 'ASC')
                  ->orderBy('estado', 'ASC')
                  ->paginate(50);
      $salarios = Salario::where('user_id', $user->id)
                  ->orderBy('created_at', 'DESC')
                  ->paginate(20);
      $empresas = DB::table('empresa_users')
                  ->join('empresas', 'empresa_users.empresa_id', '=', 'empresas.id')
                  ->join('roles', 'empresa_users.role_id', '=', 'roles.id')
                  ->join('sucursales', 'empresa_users.sucursal_id', '=', 'sucursales.id')
                  ->join('areas', 'empresa_users.area_id', '=', 'areas.id')
                  ->select(
                     'empresas.id as emid', 'empresas.nombre as emnombre', 'empresas.logo', 'roles.id as rolid',
                     'roles.name', 'sucursales.id as sucid', 'sucursales.nombre as sucnombre',
                     'areas.id as areaid', 'areas.area'
                     )
                  ->where('empresa_users.user_id', $user->id)
                  ->get();
      $disponibles = Empresa::where('estado', '1' )
                     ->select('id as dispoid', 'nombre')
                     ->orderBy('nombre', 'ASC')
                     ->get();

      $roles = Role::select('id', 'name')
                     ->where('id', '>', '2')
                     ->orderBy('id', 'ASC')
                     ->get();

      $ubicacion = DB::table('empresa_users')
                  ->join('empresas', 'empresa_users.empresa_id', '=', 'empresas.id')
                  ->join('roles', 'empresa_users.role_id', '=', 'roles.id')
                  //->join('sucursales', 'empresa_users.sucursal_id', '=', 'sucursales.id')
                  //->join('areas', 'empresa_users.area_id', '=', 'areas.id')
                  ->select(
                     'empresas.id as emid', 'empresas.nombre as emnombre', 'roles.id as rolid',
                     'roles.name', 'empresa_users.sucursal_id as sucid', 'empresa_users.sucursal as sucnombre',
                     'empresa_users.area_id as areaid', 'empresa_users.area'
                     )
                  ->where('empresa_users.user_id', $user->id)
                  ->where('empresa_users.empresa_id', $user->empresa)
                  ->first();

      $sucursales = DB::table('sucursales')
                     ->where('empresa_id', $user->empresa)
                     ->where('estado', '1')
                     ->orderBy('nombre', 'ASC')
                     ->get();

      $areas = DB::table('areas')
                     ->where('empresa_id', $user->empresa)
                     ->where('estado', '1')
                     ->orderBy('area', 'ASC')
                     ->get();



   //return compact('user', 'adicional', 'soportes', 'salarios', 'empresas', 'roles', 'disponibles', 'ubicacion');
      return view('user.edit', compact(
         'user', 'adicional', 'direactual', 'soportes', 'salarios', 'empresas', 'disponibles', 'roles', 'ubicacion', 'sucursales', 'areas'
      ));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, User $user)
   {
      $this->authorize('haveaccess','misdatos');


      $user->update($request->all());

      $nombre='Su ubicación actual es: '.$request->nombremp;

      if($request->sucursal=="2"){
         DB::table('role_user')->where('user_id', $user->id)
                     ->update(['role_id' => $request->role_id]);

                     return redirect()->route('user.edit',$user->id)
                     ->with('status_success', $nombre );
      } else {

         $asignado = DB::table('empresa_users')->where('user_id', $user->id)
                           ->where('empresa_id', $user->empresa)
                           ->select('role_id')
                           ->first();

         if(empty($asignado)){

               $rolactual = DB::table('empresa_users')->where('user_id', $user->id)
                                    ->where('empresa_id', $request->empresactual)
                                    ->select('role_id')
                                    ->first();

               DB::table('empresa_users')->insert([
                           'user_id'       => $user->id,
                           'empresa_id'    => $user->empresa,
                           'role_id'       => $rolactual->role_id,
                           'name'          => $user->name,
                           'sucursal_id'   => $request->sucurid,
                           'sucursal'      => $request->sucurnom,
                           'area_id'       => $request->areaid,
                           'area'          => $request->areanom

                           ]);
         }



         return redirect()->route('sucursal')
         ->with('status_success',$nombre);
      }


   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(User $user)
   {
      $this->authorize('haveaccess','role.destroy');
      $user->delete();
      $nombre='Usuario: '.$user->name.' Eliminado Correctamente';


      return redirect('/userindex')
         ->with('status_success', $nombre );

   }
}
