@extends('adminlte::master')
@section('titulo')
   Registro Efectivo
@endsection
@section('encabezado')
   Gestión Efectivo
@endsection

@section('link')
/efectivo
@endsection
@section('modulo')
   FINANCIERO/RECEPCIÓN EFECTIVO
@endsection
@section('detallemodulo')
   Gestión de efectivo
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
                        <h2>Gestión de Efectivo</h2>
                     </div>
                  </div>
                  <div class="card-body">
                     <livewire:financiero.efectivo />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
