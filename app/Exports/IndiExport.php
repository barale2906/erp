<?php

namespace App\Exports;

use App\Correspondencia;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IndiExport implements FromCollection, WithHeadings
{
   private $ini;
   private $fin;

   public function headings(): array
      {
         return [
               'ID',
               'Fecha Solicitud',
               'observaciones',
               'Festivos',
               'Entrega Mensajero',
               'Tiempo Mensajero',
               'Recibe Destinatario',
               'Tiempo total',

         ];
      }


      public function setIni($ini)
      {
         $this->ini = $ini;
      }

      public function setFin($fin)
      {
         $this->fin = $fin;
      }



   /**
 * @return \Illuminate\Support\Collection
   */
   public function collection()
   {
      return Correspondencia::join('inditiempos', 'inditiempos.correspondencia_id', '=', 'correspondencias.id')
                              ->where('empresa_id', Auth::user()->empresa)
                              ->whereDate('fecha', '>=', $this->ini)
                              ->whereDate('fecha', '<=', $this->fin)
                              ->select(
                                 'correspondencias.id', 'inditiempos.fecha', 'correspondencias.observaciones', 'inditiempos.festivos',
                                 'inditiempos.entrega', 'inditiempos.diferem', 'inditiempos.recibe', 'inditiempos.diferencia'
                                 )
                              ->orderby('correspondencias.id')
                              ->get();
   }
}
