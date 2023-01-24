@extends('adminlte::master')
@section('titulo')
   Gestión Humana
@endsection
@section('encabezado')
   PARAMETROS HUMANA
@endsection

@section('link')
   /paramehum
@endsection
@section('modulo')
   HUMANA/CONFIGURACION
@endsection
@section('detallemodulo')
   Configurar Modulo de Gestión Humana
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
         <div class="row">
            <div class="col-12 col-sm-12">
               <!-- /.row -->
               <!-- Main content -->
               <section class="content">
                  <div class="card ">
                     <div class="card-header p-2">
                        <ul class="nav nav-pills">
                           @can('haveaccess','superhumana')
                              <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Item Salario</a></li>
                              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Esquemas de Costos</a></li>
                           @endcan
                        </ul>
                     </div><!-- /.card-header -->
                     <div class="card-body">
                        <div class="tab-content">
                           <div class="tab-pane" id="activity">
                              <livewire:humana.itemsalario/>
                           </div>
                           <!-- /.tab-pane -->
                           <div class="tab-pane" id="timeline">
                              <livewire:humana.esquemacosto/>
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
