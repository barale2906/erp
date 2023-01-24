<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancieroController extends Controller
{
   // Entrada
   public function lista()
   {
      return view('financiero.index');
   }

   // Efectivo
   public function efectivo()
   {
      return view('financiero.efectivo');
   }

   // Entrada
   public function movimiento()
   {
      return view('financiero.movimiento');
   }

   // Obligaciones
   public function obligaciones()
   {
      return view('financiero.obligacion');
   }

   // Obligaciones historial
   public function obligahist()
   {
      return view('financiero.historial');
   }

   
}
