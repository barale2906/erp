@extends('adminlte::master')
@section('titulo')
   Listado de Facturas
@endsection
@section('encabezado')
   Listado de Facturas
@endsection

@section('link')
   /listafactura
@endsection
@section('modulo')
   FACTURACION/LISTA FACTURAS
@endsection
@section('detallemodulo')
   Control de Facturas
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
               <livewire:facturacion.listafactura />
            </div>
         </div>
      </div>
   </section>
@endsection
