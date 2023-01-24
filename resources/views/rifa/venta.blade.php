@extends('adminlte::master')
@section('titulo')
   Venta de Rifas
@endsection


@section('encabezado')
   GESTIONA LAS VENTAS DE LAS RIFAS DESDE ACÁ
@endsection

@section('link')
/ventarifa
@endsection
@section('modulo')
   RIFAS/VENTAS
@endsection
@section('detallemodulo')
   Control de Ventas
@endsection

@section('body')
<!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row justify-content-center">
            <div class="card">
               <div class="card-body">
                  <div class="col-12">
                     <livewire:rifa.ventas />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
