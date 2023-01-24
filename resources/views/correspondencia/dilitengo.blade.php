@extends('adminlte::master')
@section('titulo')
   Gestión de correspondencia
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   LISTADO DE SOLICITUDES EN MI PODER
@endsection

@section('link')
/dilitengo
@endsection
@section('modulo')
   CORRRESPONDENCIA/GESTIÓN DE CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Listado de Solicitudes En Mi Poder
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
               <div class="col-10">
                  <livewire:correspondencia.misplanillas />
               </div>
               <div class="col-2">
                  <livewire:correspondencia.planillapdf />
               </div>
         </div>
         <div class="row justify-content-center">
               <div class="col-12">
                  <livewire:correspondencia.dilitengo />
               </div>
         </div>
      </div>
   </section>


@endsection
