<?php

namespace App\Http\Controllers;

use App\Correspondencia;
use App\Recorrido;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RecorridoController extends Controller
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
      Gate::authorize('haveaccess','corres.edit');

      // Actualizar quien lo tiene
      $tenia = Recorrido::where('correspondencia_id', $request->correspondencia_id)
                           ->orderBy('id', 'desc')
                           ->select('id')
                           ->first();
      if(!empty($tenia)){
         Recorrido::where('id', $tenia->id)
                     ->update(['estado' => '3']);
      }

      $recorrido = Recorrido::create($request->all());



      $datos  = Correspondencia::where('id',$request->correspondencia_id)
                                 ->first();
      $now = Carbon::now();
      //$now = $now->format('Y-m-d');

      $observaciones = " ---- ".$now." ".Auth::user()->name.", recogio el envío. ---- ".$datos->observaciones;

      Correspondencia::where('id',$request->correspondencia_id)
                           ->update([
                              'estado' => '5',
                              'observaciones' => $observaciones
                              ]);

      $nombre = "Le fue registrada a su nombre la diligencia: ".$recorrido->correspondencia_id;

      return compact('nombre');
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Recorrido  $recorrido
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request)
   {
      $this->authorize('haveaccess','misdatos');

      $poder = DB::table('recorridos')
               ->join('correspondencias', 'recorridos.correspondencia_id', '=', 'correspondencias.id')
               ->select(
                  'recorridos.updated_at as recibio', 'correspondencias.id', 'correspondencias.nombredestinatario',
                     'correspondencias.nombresede', 'correspondencias.nombreubicacion',
                     'correspondencias.horario', 'correspondencias.descripcion'
                  )
               ->where('recorridos.operador', $request->id)
               ->where('recorridos.estado', 1)
               ->where('correspondencias.empresa_id', Auth::user()->empresa)
               ->orderBy('recorridos.updated_at','Asc')
               ->get();


      $operador = User::where('id', $request->id)
                  ->select('name')
                  ->first();

      $cargados =  DB::table('recorridos')
                  ->join('users', 'recorridos.operador', '=', 'users.id')
                  ->join('correspondencias', 'recorridos.correspondencia_id', '=', 'correspondencias.id')
                  ->select(
                           'users.name', 'recorridos.operador'
                     )
                  ->where('recorridos.estado', 1)
                  ->where('correspondencias.empresa_id', Auth::user()->empresa)
                  ->groupBy('recorridos.operador', 'users.name')
                  ->orderBy('users.name','Asc')
                  ->get();
      $total   =  Correspondencia::where('empresa_id', Auth::user()->empresa)
                     ->where('estado', '!=', 6)
                     ->count();

      //return compact('total', 'operador', 'poder', 'cargados');

      return view('correspondencia.recorrido', compact('total', 'operador', 'poder', 'cargados'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Recorrido  $recorrido
    * @return \Illuminate\Http\Response
    */
   public function edit(Recorrido $recorrido)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Recorrido  $recorrido
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Recorrido  $recorrido
    * @return \Illuminate\Http\Response
    */
   public function destroy(Recorrido $recorrido)
   {
      //
   }
}
