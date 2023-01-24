@extends('adminlte::master')
@section('titulo')
   Movimientos Financieros
@endsection
@section('encabezado')
   Registro de Movimientos Financieros
@endsection

@section('link')
/movimiento
@endsection
@section('modulo')
   FINANCIERO/MOVIMIENTO FINANCIERO
@endsection
@section('detallemodulo')
   Gestionar los movimientos de los diferentes productos financieros
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
                        <h2>Registrar Movimiento</h2>
                     </div>
                  </div>
                  <div class="card-body">
                     <livewire:financiero.movimiento />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
