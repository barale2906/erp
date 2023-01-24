@extends('adminlte::master')
@section('titulo')
   Generar Planillas de Entrega
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   GESTIONAR RUTAS DE ENTREGA
@endsection

@section('link')
/recorridorden
@endsection
@section('modulo')
   CORRRESPONDENCIA/GESTIÓN DE CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Organiza rutas de entrega
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
               $control=5;
         @endphp
         @include('correspondencia.navegacion')
         <div class="row justify-content-center">
               <div class="col-12 col-sm-6">
                  <livewire:correspondencia.crearutas/>
               </div>
               <div class="col-12 col-sm-3">
                  <livewire:correspondencia.planilladmon/>
               </div>
         </div>
         <div class="row justify-content-center">
               <div class="col-12">
                  <livewire:correspondencia.creaplanillas />
               </div>
               <div class="col-12">
                  <livewire:correspondencia.ordenaruta />
               </div>
         </div>

      </div>
   </section>
@endsection
