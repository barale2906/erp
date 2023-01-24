@extends('adminlte::master')
@section('titulo')
   historial de obligaciones
@endsection
@section('encabezado')
   Obligaciones Historial
@endsection

@section('link')
/obligahist
@endsection
@section('modulo')
   FINANCIERO/Historial
@endsection
@section('detallemodulo')
   Historial de Obligaciones
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
                     <div class="row justify-content-center">
                        <h2>Historial de Obligaciones</h2>
                     </div>
                  </div>
                  <div class="card-body">
                     <livewire:financiero.historial />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
