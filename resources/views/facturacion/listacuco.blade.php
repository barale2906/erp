@extends('adminlte::master')
@section('titulo')
   Listado de cuentas de cobro
@endsection
@section('encabezado')
   Listado de cuentas de cobro
@endsection

@section('link')
   /listacuco
@endsection
@section('modulo')
   FACTURACION/LISTA CUENTAS DE COBRO
@endsection
@section('detallemodulo')
   Control de Cuentas de Cobro
@endsection

@section('body')
<!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row justify-content-center">
               <div class="col-5">
                  @include('custom.message')
               </div>
         </div>
         <div class="row justify-content-center">
            <div class="col-12">
               <livewire:facturacion.listacuco />
            </div>
         </div>
      </div>
   </section>
@endsection