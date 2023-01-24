@extends('adminlte::master')
@section('titulo')
   Solicitudes Abiertas
@endsection
@section('encabezado')
   SOLICITUDES ABIERTAS
@endsection

@section('link')
/soliabierta
@endsection
@section('modulo')
   CORRRESPONDENCIA/GESTIÓN DE CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Solicitudes Abiertas
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
            $control=1;
         @endphp
         @include('correspondencia.navegacion')
         <div class="row justify-content-center">
            <div class="col-12">
               <livewire:correspondencia.soliabierta />
            </div>
      </div>
      </div>
   </section>
@endsection
