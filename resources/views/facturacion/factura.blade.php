@extends('adminlte::master')
@section('titulo')
   Generar Factura
@endsection
@section('encabezado')
   Genera Factura
@endsection

@section('link')
   /factura
@endsection
@section('modulo')
   FACTURACION/FACTURAR
@endsection
@section('detallemodulo')
   Factura servicios
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
               <livewire:facturacion.generafactura />
            </div>
         </div>
      </div>
   </section>
@endsection
