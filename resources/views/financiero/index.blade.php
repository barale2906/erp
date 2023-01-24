@extends('adminlte::master')
@section('titulo')
   Productos Financieros
@endsection
@section('encabezado')
   Control de Productos Financieros
@endsection

@section('link')
/financiero
@endsection
@section('modulo')
   FINANCIERO/PORDUCTOS FINANCIEROS
@endsection
@section('detallemodulo')
   Gestionar productos financieros
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
                        <div class="col-2"><livewire:financiero.financierocrea/></div>
                     </div>
                  </div>
                  <div class="card-body">
                     <livewire:financiero.financierolista />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
