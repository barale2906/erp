<?php

namespace App\Http\Controllers;

use App\Soporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SoporteController extends Controller
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
            'documento'     => 'required',
            'ruta'          => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'expedicion'    => 'required',
            'vencimiento'   => 'required',

        ]);

        $soporte = Soporte::create($request->all());


            $ruta = $request->file('ruta');
            $archivo = $request->username.'_'.time().'_'.$soporte->documento.'.'.$ruta->getClientOriginalExtension();
            $destino = public_path('soportes');
            $request->ruta->move($destino, $archivo);
            $ruta="../soportes/".$archivo;

            // Actualizar ruta en la BD
            Soporte::where('id', $soporte->id)
                  ->update(['ruta'=>$ruta]);


        $nombre = 'Se cargo correctamente el documento: '.$soporte->documento;

        return redirect()->route('user.edit',$soporte->user_id)
            ->with('status_success', $nombre);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Soporte  $soporte
     * @return \Illuminate\Http\Response
     */
    public function show(Soporte $soporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Soporte  $soporte
     * @return \Illuminate\Http\Response
     */
    public function edit(Soporte $soporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Soporte  $soporte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soporte $soporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Soporte  $soporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Soporte $soporte)
    {
        $this->authorize('haveaccess','soporte.destroy');
        $soporte->delete();

        $nombre = 'Se elimino correctamente el documento: '.$soporte->documento;

        return redirect()->route('user.edit',$soporte->user_id)
            ->with('status_success', $nombre);
    }
}
