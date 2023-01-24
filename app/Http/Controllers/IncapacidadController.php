<?php

namespace App\Http\Controllers;

use App\Incapacidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IncapacidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','consulta.incapacidad');

        $incapacidads =  Incapacidad::orderBy('inicia','Desc')->paginate(20);

        return view('incapacidad.index',compact('incapacidads'));
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
        Gate::authorize('haveaccess','edita.incapacidad');

        $request->validate([
            'usu_id'     => 'required',
            'motivo'     => 'required',
            'inicia'     => 'required',


        ]);

        $incapacidad = Incapacidad::create($request->all());
        $nombre = 'Se creo correctamente la incapacidad con motivo: '.$incapacidad->motivo;

        return redirect()->route('incapacidad.index')
            ->with('status_success', $nombre);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incapacidad  $incapacidad
     * @return \Illuminate\Http\Response
     */
    public function show(Incapacidad $incapacidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incapacidad  $incapacidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Incapacidad $incapacidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Incapacidad  $incapacidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incapacidad $incapacidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incapacidad  $incapacidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incapacidad $incapacidad)
    {
        //
    }
}
