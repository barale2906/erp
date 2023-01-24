@extends('adminlte::master')
@section('titulo')
   Gestionar Planillas de Entrega
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   GESTIONAR PLANILLAS DE ENTREGA
@endsection

@section('link')
/gestplanilla
@endsection
@section('modulo')
   CORRRESPONDENCIA/GESTIÓN DE CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Gestiona planillas de entrega
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
               <div class="col-12 col-sm-10">
                  <livewire:correspondencia.planillaproceso/>
               </div>
               <div class="col-12 col-sm-2">
                  <livewire:correspondencia.planillapdf/>
               </div>
               <div class="col-12">
                  <livewire:correspondencia.planillafinal/>
               </div>
         </div>
      </div>
   </section>
@endsection
