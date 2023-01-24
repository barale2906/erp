<?php

namespace App\Http\Controllers;

use App\Area;
use App\Empresa;
use App\Sucursale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Expr\Variable;

class EmpresaController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

      Gate::authorize('haveaccess','empresa.index');

      $empresas =  Empresa::orderBy('nombre','Asc')->paginate(20);

      return view('empresa.index',compact('empresas'));
   }


   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      Gate::authorize('haveaccess','empresa.create');

      return view('empresa.create');
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
public function store(Request $request)
{
   Gate::authorize('haveaccess','empresa.create');

   $request->validate([

      'nit'           => 'required',
      'nombre'        => 'required',
      'direccion'     => 'required',
      'tipo'          => 'required',
      'metodopago'    => 'required',

   ]);



   $empresa = Empresa::create($request->all());
   $sede = $empresa->nombre.' Principal';
   $sucursal = Sucursale::insert([
      'direccion'     => $request->direccion,
      'nombre'        => $sede,
      'empresa_id'    => $empresa->id,
      'ciudad_id'     => '1'

   ]);

   $area = Area::insert([

      'area'        => 'Gerencia General',
      'empresa_id'    => $empresa->id,


   ]);





   $nombre = 'Se creo correctamente la empresa: '.$empresa->nombre.' Debe completar la información';

   return redirect()->route('empresa.edit',$empresa->id)
      ->with('status_success', $nombre);
}

/**
 * Display the specified resource.
   *
   * @param  \App\Empresa  $empresa
   * @return \Illuminate\Http\Response
   */
public function show(Empresa $empresa)
{
   //
}

/**
 * Show the form for editing the specified resource.
   *
   * @param  \App\Empresa  $empresa
   * @return \Illuminate\Http\Response
   */
public function edit(Empresa $empresa)
{
   $this->authorize('haveaccess','empresa.edit');

   $sucursales = $empresa->sucursales()->first();
   $areas      = $empresa->areas()->first();




   //return compact('empresa', 'sucursales', 'areas');
   return view('empresa.edit', compact('empresa', 'sucursales', 'areas'));

}

/**
 * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Empresa  $empresa
   * @return \Illuminate\Http\Response
   */
public function update(Request $request, Empresa $empresa)
{
   $this->authorize('haveaccess','empresa.update');


   $empresa->update($request->all());

   $variablelogo=$request->logo;

   if($variablelogo!=""){

         // Cargar logo
      $request->validate([
            'logo'          => 'image|mimes:jpg,jpeg,png|max:2048',

      ]);

      $logo = $request->file('logo');
      $archivo = $empresa->nit.'.'.$logo->getClientOriginalExtension();
      $destino = public_path('logos');
      $request->logo->move($destino, $archivo);
      $ruta="../logos/".$archivo;

      // Actualizar ruta en la BD
      Empresa::where('id', $empresa->id)
            ->update(['logo'=>$ruta]);


   }


   $nombre = 'Se creo/actualizo correctamente la empresa: '.$empresa->nombre;


   return redirect()->route('empresa.index')
      ->with('status_success',$nombre);
}




}
