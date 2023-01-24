@extends('adminlte::master')
@section('titulo')
   Gestión de Facturación
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   PARAMETROS
@endsection

@section('link')
   /paramefac
@endsection
@section('modulo')
   FACTURACION/CONFIGURACION
@endsection
@section('detallemodulo')
   Configurar Modulo de Facturación
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
                           <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Productos</a></li>
                           <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Listas de Precios</a></li>
                           <li class="nav-item"><a class="nav-link" href="#cargo" data-toggle="tab">Cargos a la factura</a></li>
                        </ul>
                     </div><!-- /.card-header -->
                     <div class="card-body">
                        <div class="tab-content">
                           <div class="tab-pane" id="cargo">
                              <livewire:facturacion.cargo/>
                           </div>
                           <div class="active  tab-pane" id="activity">
                              <livewire:facturacion.productos/>
                           </div>
                           <!-- /.tab-pane -->
                           <div class="tab-pane" id="timeline">
                              <livewire:facturacion.crealista/>
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
