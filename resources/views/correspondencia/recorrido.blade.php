@extends('adminlte::master')
@section('titulo')
   Envíos con {{ $operador->name }}
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   ENVÍOS EN MI PODER
@endsection

@section('link')
/gestioncorres
@endsection
@section('modulo')
   CORRRESPONDENCIA/GESTIÓN DE CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Envíos en Recorrido
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

         @can('haveaccess','configcorres')
               <div class="row justify-content-center">
                  <div class="col-12 col-sm-6">
                     <div class="info-box">
                           <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-chart-line"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text">Seleccione un operador para identificar las solicitudes a su cargo</span>
                              <form action="{{route('recorrido.show', Auth::user()->id)}}" method="GET">
                                 <div class="input-group">
                                       <select class="custom-select" id="id" name="id" aria-label="Example select with button addon">
                                             <option selected value="{{Auth::user()->id}}">{{$operador->name}}</option>
                                          @foreach ($cargados as $cargado)
                                             @if ($cargado->name!=$operador->name)
                                                   <option value="{{$cargado->operador}}">{{$cargado->name}}</option>
                                             @endif

                                          @endforeach
                                       </select>
                                       <div class="input-group-append">
                                          <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                                       </div>
                                 </div>
                              </form>
                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                  </div>
                  <div class="col-12 col-sm-3">
                     <div class="info-box">
                           <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box-open"></i></span>
                           <div class="info-box-content">
                              <a href="/soliabierta"><span class="info-box-text">Solicitudes Abiertas</span></a>
                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                  </div>
               <!-- /.row -->
         @endcan
         <div class="row">
                  <div class="col-12 col-sm-12">
                     <!-- /.row -->
                     <!-- Main content -->
                     <section class="content">
                           <div class="card">
                           <div class="card-header">
                              <h3 class="card-title center">A nombre de <span class="text text-bold">{{$operador->name}}</span>
                                 hay <span class="text text-bold text-warning">{{$poder->count()}}</span> solicitudes de un total de
                              <span class="text text-bold text-blue">{{$total}}</span> solicitudes activas. </h3>

                           </div>
                           <!-- /.card-header -->
                           <div class="card-body">
                              <table class="table table-bordered table-striped">
                                 <thead>

                                       <tr>
                                          <th scope="col">ID</th>
                                          <th scope="col">Destinatario</th>
                                          <th scope="col">Sede/Dirección</th>
                                          <th scope="col">Área/Ciudad</th>
                                          <th scope="col">Descripción</th>
                                          <th scope="col">Horario</th>
                                          <th scope="col">Fecha - hora de recolección</th>
                                       </tr>
                                 </thead>
                                 <tbody>
                                       @foreach ($poder as $pode)
                                          <tr>
                                             <td>{{$pode->id}}</td>
                                             <td>{{$pode->nombredestinatario}}</td>
                                             <td>{{$pode->nombresede}}</td>
                                             <td>{{$pode->nombreubicacion}}</td>
                                             <td>{{$pode->descripcion}}</td>
                                             <td>{{$pode->horario}}</td>
                                             <td>{{$pode->recibio}}</td>
                                          </tr>
                                       @endforeach
                                 </tbody>
                              </table>
                           </div>
                           <!-- /.card-body -->
                           </div>
                           <!-- /.card -->
                     </section>
                     <!-- /.content -->
                  </div>
         </div>
      </div>
   </section>
@endsection
