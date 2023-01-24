@extends('adminlte::master')
@section('titulo')
   Historial Diligencias
@endsection
@section('encabezado')
   Revisar Diligencias
@endsection

@section('link')
/historial
@endsection
@section('modulo')
   DILIGENCIAS/MI HISTORIAL DE DILIGENCIAS
@endsection
@section('detallemodulo')
   Revisar el historial de mis diligencias
@endsection
@section('body')
   <section class="content">
      <div class="container-fluid">
         <!-- /.row -->
         <div class="row justify-content-center">
            <div class="col-5">
               @include('custom.message')
            </div>
         </div>
         <div class="row justify-content-center">
            <div class="col-12">
               <div class="card">
                  <div class="card-header text-lg">
                     Busca la diligencia que requieras para ver sus detalles, se muestran todas las de la empresa
                  </div>
                  <div class="card-body">
                     <livewire:diligencias.historial>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
