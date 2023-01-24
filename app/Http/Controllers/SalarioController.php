<?php

namespace App\Http\Controllers;

use App\Salario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SalarioController extends Controller
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
        Gate::authorize('haveaccess','salario.create');

        $request->validate([
            'salario'     => 'required',
        ]);

        // Inactivar salarios anteriores
        $inactivar = Salario::where('user_id', $request->user_id)
                        ->update(['estado' => 2]);
        // Generar nuevo salario
        $salario = Salario::create($request->all());
        $nombre = 'Se asigno un salario de: $ '.$salario->salario.' correctamente.';

        return redirect()->route('user.edit',$salario->user_id)
            ->with('status_success', $nombre);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salario  $salario
     * @return \Illuminate\Http\Response
     */
    public function show(Salario $salario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salario  $salario
     * @return \Illuminate\Http\Response
     */
    public function edit(Salario $salario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salario  $salario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salario $salario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salario  $salario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salario $salario)
    {
        //
    }
}
