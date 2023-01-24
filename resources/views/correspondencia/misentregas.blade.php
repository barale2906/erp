@extends('adminlte::master')
@section('titulo')
   Verificar Entregas
@endsection
@section('encabezado')
   MIS ENTREGAS
@endsection

@section('link')
/misentregas
@endsection
@section('modulo')
   CORRESPONDENCIA/MIS ENTREGAS
@endsection
@section('detallemodulo')
   Correspondencia
@endsection
@section('body')
   <section class="content">
      <div class="container-fluid">
         <!-- Info boxes -->
         <div class="row justify-content-center">
            <div class="col-12 col-sm-2 ">
               <div class="info-box mb-3">
                     <span class="info-box-icon bg-success elevation-1"><i class="fas fa-motorcycle"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text">Crear Envío</span>

                        @can('haveaccess','misdatos')
                        <a class="btn btn-secondary" href="/micorrespondencia"><i class="fas fa-fast-backward"></i></a>
                        @endcan

                     </div>
                     <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
         <div class="row justify-content-center">
               <div class="col-5">
                  @include('custom.message')
               </div>
         </div>
         <div class="row justify-content-center">
            <div class="col-12">
               <livewire:correspondencia.misentregas />
            </div>
      </div>
      </div>
   </section>
@endsection
