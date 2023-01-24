<?php

namespace App\Http\Controllers;

use App\Ciudade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CiudadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','sucursale.create');

        $ciudades =  Ciudade::orderBy('ciudad','Asc')
                    ->select('id','ciudad')
                    ->get();

        return view('sucursal.index',compact('ciudades'));


    }

    public function listaciudad()
    {



            $ciudads = Ciudade::where('estado', 1)
                        ->orderBy('ciudad', 'ASC')->get();


            return $ciudads;


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
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ciudade  $ciudade
     * @return \Illuminate\Http\Response
     */
    public function edit(Ciudade $ciudade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ciudade  $ciudade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ciudade $ciudade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ciudade  $ciudade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ciudade $ciudade)
    {
        //
    }
}
