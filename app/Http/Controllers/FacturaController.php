<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class FacturaController extends Controller
{
   public function zip(Request $request)
   {

      Gate::authorize('haveaccess','coorfac');

      $request->validate([
            'zip'                   => 'required|mimes:zip|max:2048',
      ]);

      // Cargar zip


         $zip = $request->file('zip');
         $archivo = $request->factura_id.'.'.$zip->getClientOriginalExtension();
         $destino = public_path('facturas');
         $request->zip->move($destino, $archivo);
         $ruta="../facturas/".$archivo;

         // cargar
         /*Storage::putFileAs(
            'facturas', $zip, $archivo
         );*/

         //$zip->storeAs($destino, $archivo);

         // Cargar base de datos
         DB::table('facturazips')
            ->insert([
               'factura_id'   => $request->factura_id,
               'user_id'      => Auth::user()->id,
               'ruta'         => $ruta,
            ]);

         $nombre = "Se ha cargado correctamente la factura: ".$request->factura_numero;

         return redirect()->route('listafactura')
         ->with('status_success', $nombre);


   }
}
