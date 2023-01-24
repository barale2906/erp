@extends('adminlte::master')
@section('titulo')
   Cuentas de Cobro
@endsection
@section('encabezado')
   Generar Cuentas
@endsection

@section('link')
/cuentacobro
@endsection
@section('modulo')
   FACTURACION/CUENTAS
@endsection
@section('detallemodulo')
   Generar Cuentas de Cobro
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
               <livewire:facturacion.cuentacobro />
            </div>
      </div>
      </div>
   </section>
@endsection
