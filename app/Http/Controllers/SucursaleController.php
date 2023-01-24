<?php

namespace App\Http\Controllers;

use App\Sucursale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SucursaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        Gate::authorize('haveaccess','sucursale.create');

        $request->validate([
            'nombre'     => 'required',
            'direccion'  => 'required',
            'ciudad_id'  => 'required'
        ]);

        $sucursal = Sucursale::create($request->all());
        $nombre = 'Se creo correctamente la sucursal: '.$sucursal->nombre;

        return redirect()->route('sucursal')
            ->with('status_success', $nombre);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sucursale  $sucursale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sucursale $sucursale)
    {
        $this->authorize('haveaccess','sucursale.edit');


        return view('sucursal.edit', compact('sucursale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sucursale  $sucursale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sucursale $sucursale)
    {
        $this->authorize('haveaccess','sucursale.update');



        $sucursale->update($request->all());
        $nombre = 'Se actualizo correctamente la sucursal: '.$sucursale->nombre;


        return redirect()->route('sucursal')
            ->with('status_success',$nombre);
    }

    public function getSucursales(Request $request)
    {
        if($request->ajax()){

            $sucursales = Sucursale::where('empresa_id', $request->empresa_id)->get();
            foreach ($sucursales as $sucursal){

                $sucursalesArray[$sucursal->id] = $sucursal->nombre;

            }

            return response()->json($sucursalesArray);

        }
    }

    }
