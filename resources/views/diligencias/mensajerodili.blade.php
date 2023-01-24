@extends('adminlte::master')
@section('titulo')
   Asignaciones Mensajero
@endsection
@section('encabezado')
   Diligencias Asignadas
@endsection

@section('link')
/mensajerodili
@endsection
@section('modulo')
   DILIGENCIAS/DILIGENCIAS ASIGNADAS
@endsection
@section('detallemodulo')
   Revisa las diligencias asignadas
@endsection
@section('body')
   <section class="content">
      <div class="container-fluid">
         <!-- /.row -->
         <div class="row justify-content-center">
            <div class="col-5">
               @include('custom.message')
            </div>
         </div>
         <div class="row justify-content-center">
            <div class="col-12">
               <div class="card">
                  <div class="card-header text-lg">
                     Estas son tus diligencias asignadas.
                  </div>
                  <div class="card-body">
                     <livewire:diligencias.dilimensajero>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
