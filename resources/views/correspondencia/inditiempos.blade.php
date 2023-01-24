@extends('adminlte::master')
@section('titulo')
   Calculo de indicadores
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   INDICADORES
@endsection

@section('link')
/inditiempos
@endsection
@section('modulo')
   CORRRESPONDENCIA/INDICADORES
@endsection
@section('detallemodulo')
   Indicadores del Proceso
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
         @php
               $control='';
         @endphp
         @include('correspondencia.navegacion')
         <div class="row justify-content-center">
               <div class="col-12">
                  <livewire:correspondencia.inditiempo/>
               </div>
         </div>
      </div>
   </section>
@endsection
