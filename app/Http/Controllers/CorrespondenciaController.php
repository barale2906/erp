<?php

namespace App\Http\Controllers;

//require 'vendor/autoload.php';

use App\Asignacione;
use App\Correspondencia;
use App\Recorrido;
use App\TipoEnvio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
//use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Facades\Image;

use App\Imports\CorrespondenciaImport;
use App\Soportent;
use Illuminate\Support\Facades\DB;

class CorrespondenciaController extends Controller
{

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      Gate::authorize('haveaccess','corres.index');


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

      $now = Carbon::now();

      $request->validate([

         'nombredestinatario'=> 'required',
         'nombresede'        => 'required',
         'nombreubicacion'   => 'required',
         'descripcion'       => 'required',
         'detalle'           => 'required',
         'clase'             => 'required',

      ]);

      //Crear Envío
      $envio = Correspondencia::create($request->all());

      //Crear control de indicadores
      DB::table('inditiempos')->insert([
         'fecha'              => $now,
         'correspondencia_id' => $envio->id,
      ]);

      $nombre = 'Se creo correctamente el envío N° '.$envio->id.' si no aparece en el listado de los envíos haz clic sobre el ID en la tabla';

      return compact('envio', 'nombre');

   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Correspondencia  $correspondencia
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $this->authorize('haveaccess','misdatos');

      $correspondencia = Correspondencia::find($id);
      $clases= TipoEnvio::find($correspondencia->clase);
      $imagenes = Soportent::where('correspondencia_id', $id)
                              ->select('ruta')
                              ->get();

         $tiempos = DB::table('inditiempos')
                           ->where('correspondencia_id', $id)
                           ->first();


      return view('correspondencia.detalle', compact('correspondencia', 'clases', 'imagenes', 'tiempos'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Correspondencia  $correspondencia
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      $control = $request->control;
      $now = Carbon::now();
      $yo = Auth::user()->name;
      $yoid = Auth::user()->id;
      //$now = $now->format('Y-m-d');

      switch ($control) {
         case '0': // Actualizando observaciones
                     $observaciones = " ---- ".$now." ".$yo." registro: ".$request->observaciones." ---- ".$request->observacion;

                     Correspondencia::where('id', $id)
                                          ->update([
                                             'observaciones' => $observaciones
                                             ]);


                     $nombre='Se adiciono observación para la solicitud: '.$id;

                     return redirect()->route('corres.edit',$id)
                           ->with('status_success', $nombre);

               break;
         case '1': // Cerrando el envío
               // obtener los datos del envío
                     $datos = Correspondencia::where('id', $id)
                                                ->select('observaciones')
                                                ->first();

                  if($datos->estado != 6){
                              $observaciones = " ---- ".$now." ".$yo." CERRO EL ENVÍO. "." ---- ".$datos->observaciones;

                              // Cerrar envío
                              Correspondencia::where('id', $id)
                                 ->update([
                                       'observaciones' => $observaciones,
                                       'recepcion'     => $now,
                                       'recibe'        => $yoid,
                                       'estado'        => '6'
                                       ]);
                     // Liberar Mensajero

                     $tenia = Recorrido::where('correspondencia_id', $id)
                     ->orderBy('id', 'desc')
                     ->select('id')
                     ->first();

                     if(!empty($tenia)){
                     Recorrido::where('id', $tenia->id)
                     ->update(['estado' => '4']);
                     }

                     // Calcular tiempo de entrega
                        //Selecciona el envío en la tabla
                        $indienvio = DB::table('inditiempos')
                                       ->where('correspondencia_id', $id)
                                       ->select('fecha', 'festivos')
                                       ->first();


                        //Determinar los festivos
                        $festivoperiodo = DB::table('festivos')
                        ->whereDate('fecha', '>=', $indienvio->fecha)
                        ->whereDate('fecha', '<=', $now)
                        ->count('id');

                        $horasfestivas = $festivoperiodo*24;




                     /*
                        //Diferencia de tiempo
                        // identificar diferencia de días
                        $creado = Carbon::create($indienvio->fecha);
                        $entre =  Carbon::create($now);
                        //$diferencia = $entregado->diffInDays($creado);
                        $diferenciam = $entre->diffInHours($creado);

                        // Descontando festivos
                        //$diff=$diferencia-$festivoperiodo; // Diferencia en días

      */
                        $diferenciam = $now->diffInHours($indienvio->fecha);
                        $diff = $diferenciam-$horasfestivas; // Diferencia en horas

                        //Actualizar tabla
                        DB::table('inditiempos')
                                 ->where('correspondencia_id', $id)
                                 ->update([
                                    'recibe'    =>$now,
                                    'festivos'  =>$festivoperiodo,
                                    'diferencia'=>$diff,
                                 ]);

                     $nombre='Se ha FINALIZADO correctamente el envío con ID: '.$id;
                     } else {
                     $nombre= 'El envío con ID: '.$id.' ya esta cerrado';
                     }
                     return compact('nombre');
               break;

      }

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Correspondencia  $correspondencia
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $this->authorize('haveaccess','misdatos');

      $corres= Correspondencia::findOrFail($id);
      $corres->delete();

      DB::table('inditiempos')
                           ->where('correspondencia_id', $id)
                           ->delete();


      $nombre='El envío con ID: '.$corres->id.' fue eliminado Correctamente, si aún lo ve en el listado de clic sobre el campo ID';

      // return redirect('/micorrespondencia')
      //->with('status_success', $nombre );
      return compact('corres', 'nombre');

   }

   public function importar(Request $request)
   {

      $file = $request->file('excel');

      Excel::import(new CorrespondenciaImport, $file );

      $nombre="Se han cargado las diligencias satisfactoriamente";

      return redirect('/micorrespondencia')
         ->with('status_success', $nombre );
   }

   public function foto(Request $request)
   {

      Gate::authorize('haveaccess','misdatos');

      $request->validate([
            //'foto'          => 'image|mimes:jpg,jpeg,png|max:2048',
            'foto'               => 'image|mimes:jpg,jpeg,png',
            'correspondencia_id' => 'required',
            'actualizacie'       => 'required',
            'entregado'          => 'required',

      ]);

      $now = Carbon::now();

      // Cargar fotografía
      if($request->foto)
      {

         $idsig = Soportent::max('id');

         $foto = $request->file('foto');
         $archivo = $request->correspondencia_id.'-'.$idsig.'.'.$foto->getClientOriginalExtension();
         $destino = public_path('entregas');

         // $request->foto->move($destino, $archivo); //este era el código anterior
         // Usando libreria intervention image
         Image::make($request->file('foto'))
               ->resize(600,450)
               ->save('entregas/'.$archivo);

         $ruta="../entregas/".$archivo;

         // Cargar la ruta en la BD
         Soportent::create([
            'correspondencia_id' => $request->correspondencia_id,
            'usuario'            => Auth::user()->id,
            'ruta'               => $ruta,
         ]);

         if($request->entregado==1){
            //Actualizar Envío

            $obse = $this->obse = Correspondencia::where('id', $request->correspondencia_id)
            ->select('observaciones', 'planilla')
            ->first();

            $nueva=' ---- '.$now.' '.Auth::user()->name.' ENTREGÓ EL ENVÍO con estas observaciones: '.$request->actualizacie.' ---- '.$obse->observaciones;

            // Actualizar envío
            Correspondencia::where('id', $request->correspondencia_id)
                              ->update([
                                 'observaciones' => $nueva,
                                 'estado' => 7,
                                 ]);

            // Actualizar entrega
            Recorrido::where('correspondencia_id', $request->correspondencia_id)
                     ->where('operador', Auth::user()->id)
                     ->update([
                        'entregado' => 1,
                     ]);



            // Calcular tiempo de entrega
               //Selecciona el envío en la tabla
               $indienvio = DB::table('inditiempos')
                           ->where('correspondencia_id', $request->correspondencia_id)
                           ->select('fecha', 'festivos')
                           ->first();

               //Determinar los festivos
               $festivoperiodo = DB::table('festivos')
                           ->whereDate('fecha', '>=', $indienvio->fecha)
                           ->whereDate('fecha', '<=', $now)
                           ->count('id');

               $horasfestivas = $festivoperiodo*24;


            /*
            //Diferencia de tiempo
            // identificar diferencia de días
            $creado = Carbon::create($indienvio->fecha);
            $entre =  Carbon::create($now);
            //$diferencia = $entregado->diffInDays($creado);
            $diferenciam = $entre->diffInHours($creado);

            // Descontando festivos
            //$diff=$diferencia-$festivoperiodo; // Diferencia en días

            */
            $diferenciam = $now->diffInHours($indienvio->fecha);
            $diffm = $diferenciam-$horasfestivas; // Diferencia en horas

            //Actualizar tabla
            DB::table('inditiempos')
                     ->where('correspondencia_id', $request->correspondencia_id)
                     ->update([
                        'entrega'   =>$now,
                        'festivos'  =>$festivoperiodo,
                        'diferem'   =>$diffm,
                     ]);

            $nombre = "Se registro como entregado y se cargo correctamente la imagen al envío N°: ".$request->correspondencia_id;

         } else {
            $obse = $this->obse = Correspondencia::where('id', $request->correspondencia_id)
                                                ->select('observaciones', 'planilla')
                                                ->first();

            $nueva=' ---- '.$now.' '.Auth::user()->name.': NO SE PUDO ENTREGAR el envio por: '.$request->actualizacie.' ---- '.$obse->observaciones;

            // Actualizar envío
            Correspondencia::where('id', $request->correspondencia_id)
                              ->update([
                                 'observaciones' => $nueva,
                                 ]);

             // Actualizar entrega
            Recorrido::where('correspondencia_id', $request->correspondencia_id)
            ->where('operador', Auth::user()->id)
            ->update([
               'entregado' => 2,
               'motivo'   =>$request->motivo,
            ]);


            // Registrar motivo de devolución
            DB::table('inditiempos')
                     ->where('correspondencia_id', $request->correspondencia_id)
                     ->update([
                        'motivo'   =>$request->motivo,
                     ]);

            $nombre = "No pudo ser entregado el envío N°: ".$request->correspondencia_id;
         }

         return redirect()->route('dilitengo')
         ->with('status_success', $nombre);
      }

   }
}
