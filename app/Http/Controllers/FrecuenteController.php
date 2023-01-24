<?php

namespace App\Http\Controllers;

use App\Frecuente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FrecuenteController extends Controller
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

            'destinatario'  => 'required',
            'direccion'     => 'required',
            'horario'       => 'required',
            'ciudad'        => 'required',
            'observaciones' => 'required',
            'sucursal'      => 'required',
            'area'          => 'required',

        ]);

        $frecuente = Frecuente::create($request->all());

        $nombre = 'Se creo correctamente el destinatario frecuente: '.$frecuente->destinatario.
                    ' si no aparece en el listado de los frecuentes haz clic sobre el ID en la tabla';

        return compact('frecuente', 'nombre');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Frecuente  $frecuente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('haveaccess','misdatos');
        $frecuente = Frecuente::where('id', $id)
                        ->first();


        return compact('frecuente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Frecuente  $frecuente
     * @return \Illuminate\Http\Response
     */
    public function edit(Frecuente $frecuente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Frecuente  $frecuente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Frecuente $frecuente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Frecuente  $frecuente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Frecuente $frecuente)
    {
        //
    }
}
