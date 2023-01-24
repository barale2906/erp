<?php

namespace App\Http\Controllers;

use App\Exports\IndiExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class XlsController extends Controller
{
   public function inditiempoxls(Request $request)
   {
      $export = new IndiExport;
      $export->setIni($request->fechaini);
      $export->setFin($request->fechafin);

      return Excel::download($export, 'indi.xlsx');
   }
}
