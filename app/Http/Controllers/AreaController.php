<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AreaController extends Controller
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
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      Gate::authorize('haveaccess','area.create');

      $request->validate([
         'area'     => 'required'

      ]);

      $area = Area::create($request->all());
      $nombre = 'Se creo correctamente el área: '.$area->area;

      return redirect()->route('areas')
         ->with('status_success', $nombre);
   }



   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Area  $area
    * @return \Illuminate\Http\Response
    */
   public function edit(Area $area)
   {
      $this->authorize('haveaccess','area.edit');


      return view('area.edit', compact('area'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Area  $area
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Area $area)
   {
      $this->authorize('haveaccess','area.update');



      $area->update($request->all());
      $nombre = 'Se actualizo correctamente el área: '.$area->area;


      return redirect()->route('areas')
         ->with('status_success',$nombre);
   }

   public function getAreas(Request $request)
   {
      if($request->ajax()){

         $areas = Area::where('empresa_id', $request->empresa_id)->get();
         foreach ($areas as $area){

               $areasArray[$area->id] = $area->area;

         }

         return response()->json($areasArray);

      }
   }


}
