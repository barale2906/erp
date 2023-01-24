@extends('adminlte::master')
@section('titulo')
   Guías Prepagadas
@endsection
@section('encabezado')
   Guías Prepagadas
@endsection

@section('link')
/prepago
@endsection
@section('modulo')
   FACTURACION/PREPAGO
@endsection
@section('detallemodulo')
   Asignación y control de las guías prepagadas
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
            <div class="row justify-content-center">
               <div class="col-12">
                  <div class="card">
                     <div class="card-header text-lg">
                        <livewire:facturacion.prepasigna />
                     </div>
                     <div class="card-body">
                        Listados
                     </div>
                  </div>
               </div>
            </div>
      </div>
      </div>
   </section>
@endsection
