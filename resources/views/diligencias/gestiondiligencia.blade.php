@extends('adminlte::master')
@section('titulo')
   Gestionar Diligencias
@endsection
@section('encabezado')
   Gestionar Diligencias
@endsection

@section('link')
/gestiondiligencia
@endsection
@section('modulo')
   DILIGENCIAS/GESTIONAR DILIGENCIAS
@endsection
@section('detallemodulo')
   Gestionar diligencias de los clientes
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
                     <div class="row justify-content-center">
                        <div class="col-2"><a class="btn btn-primary" href="/historialadmin" role="button">VER HISTORIAL</a></div>
                     </div>
                  </div>
                  <div class="card-body">
                     <livewire:diligencias.gestiondiligencia />
                  </div>
               </div>
            </div>
      </div>
      </div>
   </section>
@endsection
