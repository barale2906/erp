<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Factura;
use App\Planilla;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
   public function planillapdf($id)
   {
      $planilla = DB::table('empresas')
                        ->join('planillas', 'planillas.empresa_id', '=', 'empresas.id')
                        ->join('rutas', 'rutas.id', '=', 'planillas.ruta_id')
                        ->join('users', 'users.id', '=', 'planillas.operador')
                        ->where('planillas.id', $id)
                        ->select('planillas.id', 'planillas.fecha', 'planillas.observaciones',
                                 'rutas.nombre as ruta', 'users.name', 'empresas.nombre',
                                 'empresas.logo')
                        ->first();

      $correspondencias =  DB::table('correspondencias')
                                    ->join('asignaciones', 'asignaciones.correspondencia_id', '=', 'correspondencias.id')
                                    ->where('correspondencias.planilla', $id)
                                    ->select('asignaciones.orden', 'correspondencias.nombredestinatario', 'correspondencias.nombresede',
                                             'correspondencias.nombreubicacion', 'correspondencias.descripcion',
                                             'correspondencias.cobrocliente', 'correspondencias.cobro', 'correspondencias.id',
                                             'correspondencias.horario')
                                    ->orderBY('asignaciones.orden', 'ASC')
                                    ->get();

      $pdf = PDF::loadView('pdf.planilla', compact('planilla', 'correspondencias'))
                  ->setPaper('letter', 'landscape');


      return $pdf->download('planilla.pdf');
   }

   public function facturapdf($id)
   {
      // Basicos Facturador
      $somos = Empresa::where('id', 1)
                     ->first();
      // Basicos factura
      $basicos = Factura::join('empresas', 'empresas.id', '=', 'facturas.cliente_id')
               ->join('sucursales', 'sucursales.id', '=', 'facturas.sucursal_id')
               ->join('ciudades', 'ciudades.id', '=', 'sucursales.ciudad_id')
               ->select(
                  'facturas.*', 'empresas.nit', 'empresas.nombre', 'empresas.direccion', 'empresas.telefono',
                  'sucursales.nombre as nomsucursal', 'sucursales.direccion as direcsucur',
                  'ciudades.ciudad'
               )
               ->where('facturas.id', $id)
               ->get();

      // Totaliza itemes
      $detalles = DB::table('detafacturas')
                  ->join('lppros', 'lppros.id', '=', 'detafacturas.producto_id')
                  ->select('detafacturas.producto_id',
                           DB::raw('SUM(detafacturas.cantidad) as cantidad'),
                           DB::raw('SUM(detafacturas.vr_total) as total'),
                           'detafacturas.vr_unitario', 'lppros.alias')
                  ->where('detafacturas.factura_id', $id)
                  ->groupBy('detafacturas.producto_id', 'detafacturas.vr_unitario')
                  ->orderBy('lppros.alias', 'ASC')
                  ->get();

      $pdf = PDF::loadView('pdf.factura', compact('somos', 'basicos', 'detalles'))
      ->setPaper('letter');


      return $pdf->download('factura.pdf');
   }
}
