@extends('adminlte::master')
@section('titulo')
   Gestión de correspondencia
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   PARAMETROS
@endsection

@section('link')
   /parametros
@endsection
@section('modulo')
   CORRRESPONDENCIA/CONFIGURACION
@endsection
@section('detallemodulo')
   Configurar Modulo de Correspondencia
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
               $control=6;
         @endphp
         @include('correspondencia.navegacion')
         <div class="row">
            <div class="col-12 col-sm-12">
               <!-- /.row -->
               <!-- Main content -->
               <section class="content">
                  <div class="card">
                     <div class="card-header p-2">
                        <ul class="nav nav-pills">
                           <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Motivos de Devolución</a></li>
                           <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Otro parámetro</a></li>
                        </ul>
                     </div><!-- /.card-header -->
                     <div class="card-body">
                        <div class="tab-content">
                           <div class="active tab-pane" id="activity">
                              <livewire:correspondencia.devolucion/>
                           </div>
                           <!-- /.tab-pane -->
                           <div class="tab-pane" id="timeline">
                           </div>
                        </div>
                        <!-- /.tab-content -->
                     </div><!-- /.card-body -->
                  </div>
                     <!-- /.nav-tabs-custom -->
               </section>
               <!-- /.content -->
            </div>
         </div>
      </div>
   </section>
@endsection
