@extends('adminlte::master')
@section('titulo')
   Definir Festivos
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   DETALLE DEL ENVÍO
@endsection

@section('link')
/parametros
@endsection
@section('modulo')
   CONFIGURACION/FECHAS
@endsection
@section('detallemodulo')
   Cargue de festivos
@endsection
@section('body')
<section class="content">
   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="col-5">
               @include('custom.message')
         </div>
      </div>
      <div class="row justify-content-center">
         <div class="col-12 col-sm-6">
            <livewire:festivos/>
         </div>
      </div>
   </div>
</section>
@endsection


