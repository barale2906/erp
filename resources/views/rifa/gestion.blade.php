@extends('adminlte::master')
@section('titulo')
   Gestión de Rifas
@endsection


@section('encabezado')
   GESTIONA LAS RIFAS DESDE ACÁ
@endsection

@section('link')
/gestionrifa
@endsection
@section('modulo')
   RIFAS/GESTIÓN
@endsection
@section('detallemodulo')
   Definición de las rifas
@endsection

@section('body')
<!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row justify-content-center">
            <div class="card">
               <div class="card-body">
                  <div class="col-12">
                     <livewire:rifa.gestion />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
