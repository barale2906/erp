@extends('adminlte::master')
@section('titulo')
   Mis Diligencias
@endsection
@section('encabezado')
   Generar Diligencias
@endsection

@section('link')
/diligencias
@endsection
@section('modulo')
   DILIGENCIAS/MIS DILIGENCIAS
@endsection
@section('detallemodulo')
   Gestionar mis diligencias
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
                        <livewire:diligencias.detalledili />
                     </div>
                  </div>
                  <div class="card-body">
                     <livewire:diligencias.diligencias />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
