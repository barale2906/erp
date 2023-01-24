<?php

namespace App\Imports;

use App\Correspondencia;
use App\EmpresaUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class CorrespondenciaImport implements ToCollection
{
   /*
 * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null

   public function model(array $row)
   {
      $ubicacion=EmpresaUser::where('user_id', Auth::user()->id)
                                 ->where('empresa_id', Auth::user()->empresa)
                                 ->first();

      return new Correspondencia([

         'solicita'          =>Auth::user()->id,
         'empresa_id'        =>Auth::user()->empresa,
         'name'              =>Auth::user()->name,
         'sucursal'          =>$ubicacion->sucursal_id,
         'nombresucursal'    =>$ubicacion->sucursal,
         'area'              =>$ubicacion->area_id,
         'nombrearea'        =>$ubicacion->area,
         'clase'             =>1,
         'nombredestinatario'=>$row[0], // columna A
         'nombresede'        =>$row[1], // columna B
         'nombreubicacion'   =>$row[2], // columna c
         'horario'           =>$row[3], // columna D
         'descripcion'       =>$row[4], // columna E
         'detalle'           =>$row[5], // columna F
         'cobrocliente'      =>$row[6], // columna G
         'cobro'             =>$row[7], // columna H
         'observaciones'     =>$row[8], // columna I

      ]);
   }
   */

   public function collection(Collection $rows)
   {
      // Determinar remitente
      $ubicacion=EmpresaUser::where('user_id', Auth::user()->id)
                                 ->where('empresa_id', Auth::user()->empresa)
                                 ->first();

      // Detrminar momento de creación
      $now = Carbon::now();

      foreach ($rows as $row)
      {
         // Crear en tabla base
         $solicitud = Correspondencia::create([
                                    'solicita'          =>Auth::user()->id,
                                    'empresa_id'        =>Auth::user()->empresa,
                                    'name'              =>Auth::user()->name,
                                    'sucursal'          =>$ubicacion->sucursal_id,
                                    'nombresucursal'    =>$ubicacion->sucursal,
                                    'area'              =>$ubicacion->area_id,
                                    'nombrearea'        =>$ubicacion->area,
                                    'clase'             =>1,
                                    'nombredestinatario'=>$row[0], // columna A
                                    'nombresede'        =>$row[1], // columna B
                                    'nombreubicacion'   =>$row[2], // columna c
                                    'horario'           =>$row[3], // columna D
                                    'descripcion'       =>$row[4], // columna E
                                    'detalle'           =>$row[5], // columna F
                                    'cobrocliente'      =>$row[6], // columna G
                                    'cobro'             =>$row[7], // columna H
                                    'observaciones'     =>$row[8], // columna I
         ]);

         // Crear en control de tiempo
         DB::table('inditiempos')->insert([
            'fecha'              => $now,
            'correspondencia_id' => $solicitud->id,
         ]);

      }
   }
}
