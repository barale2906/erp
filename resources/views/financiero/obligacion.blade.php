@extends('adminlte::master')
@section('titulo')
   Obligaciones Financieras
@endsection
@section('encabezado')
   Control de las obligaciones
@endsection

@section('link')
/obligaciones
@endsection
@section('modulo')
   FINANCIERO/OBLIGACIÓN
@endsection
@section('detallemodulo')
   Gestionar las obligaciones de la empresa.
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
                        <livewire:financiero.obliganueva>
                     </div>
                  </div>
                  <div class="card-body">
                     <livewire:financiero.obligactivas />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection