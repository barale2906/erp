<?php

namespace App\Http\Controllers\api;

use App\Correspondencia;
use App\EmpresaUser;
use App\Frecuente;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ConsultasController extends Controller
{
   // Listado de destinatarios internos
   public function destinatarios()
   {
      Gate::authorize('haveaccess','misdatos');

      $empresa = Auth::user()->empresa;

      $correspondencia = EmpresaUser::where('empresa_id', $empresa)
                           ->where('estado', '1');




      return datatables()
      ->eloquent($correspondencia)
      ->addColumn('accion', 'correspondencia.adicionales' )
      ->rawColumns(['accion'])
      ->toJson();
   }
   // Datos del remitente.
   public function remitente()
   {
      Gate::authorize('haveaccess','misdatos');

      $base = EmpresaUser::where('user_id', Auth::user()->id )
      ->where('empresa_id', Auth::user()->empresa )
      ->first();

      return $base;
   }
   // Diligencias creadas por mi hoy
   public function miashoy()
   {

      Gate::authorize('haveaccess','misdatos');


      $hoy = Carbon::today(); //Aquí se obtiene la fecha de hoy

      $miashoy = Correspondencia::where('solicita', Auth::user()->id)
                                 ->where('empresa_id', Auth::user()->empresa)
                                 ->where('created_at', '>=', $hoy)
                                 ->where('estado', 1);


      return datatables()
      ->eloquent($miashoy)
      ->addColumn('actividad', 'correspondencia.adicionalenviado' )
      ->rawColumns(['actividad'])
      ->toJson();

   }
   // Todas mis diligencias
   public function mias()
   {

      Gate::authorize('haveaccess','misdatos');




      $mias = Correspondencia::where('solicita', Auth::user()->id)
                                 ->where('empresa_id',  Auth::user()->empresa)
                                 ->orderBy('id', 'DESC');



      return datatables()
      ->eloquent($mias)
      ->addColumn('todos', 'correspondencia.cierre' )
      ->rawColumns(['todos'])
      ->toJson();

   }
   // Todas las diligencias para mi
   public function parami()
   {

      Gate::authorize('haveaccess','misdatos');

      $parami = Correspondencia::where('destinatario', Auth::user()->id)
                                 ->where('empresa_id', Auth::user()->empresa)
                                 ->orderBy('id', 'DESC');



      return datatables()
      ->eloquent($parami)
      ->addColumn('todos', 'correspondencia.cierre' )
      ->rawColumns(['todos'])
      ->toJson();

   }
   // Todas las diligencias desde mi área actual
   public function nuestras()
   {

      Gate::authorize('haveaccess','misdatos');

      // Establecer sucursal y área actual
      $ubicacion = EmpresaUser::where('user_id', Auth::user()->id)
                              ->where('empresa_id', Auth::user()->empresa)
                              ->where('estado', 1)
                              ->select('sucursal_id', 'area_id')
                              ->first();


      $nuestras = Correspondencia::where('sucursal', $ubicacion->sucursal_id)
                                 ->where('area', $ubicacion->area_id)
                                 ->orderBy('id', 'DESC');



      return datatables()
      ->eloquent($nuestras)
      ->addColumn('todos', 'correspondencia.cierre' )
      ->rawColumns(['todos'])
      ->toJson();

   }
   // Todas las diligencias para mi área actual
   public function paranosotros()
   {

      Gate::authorize('haveaccess','misdatos');

      // Establecer sucursal y área actual
      $ubicacion = EmpresaUser::where('user_id', Auth::user()->id)
                              ->where('empresa_id', Auth::user()->empresa)
                              ->where('estado', 1)
                              ->select('sucursal_id', 'area_id')
                              ->first();


      $nosotros = Correspondencia::where('sede', $ubicacion->sucursal_id)
                                 ->where('ubicacion', $ubicacion->area_id)
                                 ->orderBy('id', 'DESC');



      return datatables()
      ->eloquent($nosotros)
      ->addColumn('todos', 'correspondencia.cierre' )
      ->rawColumns(['todos'])
      ->toJson();

   }
   // Destinatarios frecuentes
   public function frecuentes()
   {

      Gate::authorize('haveaccess','misdatos');



      $actual = EmpresaUser::where('user_id', Auth::user()->id)
                           ->where('empresa_id', Auth::user()->empresa)
                           ->where('estado', 1)
                           ->select('sucursal_id', 'area_id')
                           ->first();

      $misfrecuentes = Frecuente::where('sucursal', $actual->sucursal_id)
                                 ->where('area', $actual->area_id)
                                 ->where('estado', 1);


      return datatables()
      ->eloquent($misfrecuentes)
      ->addColumn('elegir', 'correspondencia.adicionalfrecuente' )
      ->rawColumns(['elegir'])
      ->toJson();

   }
   // muestra todas las solicitudes para la empresa actual
   public function todos()
   {

      Gate::authorize('haveaccess','corres.edit');

      $todos = Correspondencia::where('empresa_id', Auth::user()->empresa);


      return datatables()
      ->eloquent($todos)
      ->addColumn('todos', 'correspondencia.adicionaltodos' )
      ->rawColumns(['todos'])
      ->toJson();

   }

}
