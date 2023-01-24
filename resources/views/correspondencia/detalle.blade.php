@extends('adminlte::master')
@section('titulo')
   Programar Envíos
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   DETALLE DEL ENVÍO
@endsection

@section('link')
/micorrespondencia
@endsection
@section('modulo')
   CORRESPONDENCIA/MI CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Detalle Envío
@endsection
@section('body')
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
                  <div class="card">
                     <div class="card-header">
                           <h3 class="card-title center">ENVÍO N° {{$correspondencia->id}}</h3>

                     </div>
                     <!-- /.card-header -->
                     <div class="card-body">
                           <table  class="table table-bordered table-striped">
                              <thead>

                                 <tr>
                                       <th scope="col">ITEM</th>
                                       <th scope="col">DATOS</th>

                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                       <td>Fecha:</td>
                                       <td>{{ $correspondencia->created_at}}</td>
                                 </tr>
                                 <tr>
                                       <td>Remitente:</td>
                                       <td>{{ $correspondencia->name}}</td>
                                 </tr>
                                 <tr>
                                       <td>Sucursal:</td>
                                       <td>{{ $correspondencia->nombresucursal}}</td>
                                 </tr>
                                 <tr>
                                       <td>Area:</td>
                                       <td>{{ $correspondencia->nombrearea}}</td>
                                 </tr>
                                 <tr>
                                       <td>Destinatario:</td>
                                       <td>{{ $correspondencia->nombredestinatario}}</td>
                                 </tr>
                                 <tr>
                                       <td>Sede/Dirección:</td>
                                       <td>{{ $correspondencia->nombresede}}</td>
                                 </tr>
                                 <tr>
                                       <td>Área/Ciudad:</td>
                                       <td>{{ $correspondencia->nombreubicacion}}</td>
                                 </tr>
                                 <tr>
                                       <td>Horario:</td>
                                       <td>{{ $correspondencia->horario}}</td>
                                 </tr>
                                 <tr>
                                       <td>Descripción:</td>
                                       <td>{{ $correspondencia->descripcion}}</td>
                                 </tr>
                                 <tr>
                                       <td>Detalle:</td>
                                       <td>{{ $correspondencia->detalle}}</td>
                                 </tr>
                                 <tr>
                                       <td>Observaciones:</td>
                                       <td>{{ $correspondencia->observaciones}}</td>
                                 </tr>
                                 <tr>
                                       <td>Clase de Entrega:</td>
                                       <td>{{ $clases->nombre}}</td>
                                 </tr>
                                 @if ($correspondencia->planilla>0)
                                    <tr>
                                          <td>Planilla:</td>
                                          <td>{{ $correspondencia->planilla}}</td>
                                    </tr>
                                 @endif
                                 @if ($correspondencia->estado>=6)
                                    @if ($tiempos->diferem != null)
                                       <tr>
                                          <td>Tiempo Mensajero:</td>
                                          <td><strong>Fecha de entrega:</strong> {{$tiempos->entrega}},<br>
                                             <strong>Horas totales de gestión:</strong> {{$tiempos->diferem}},<br>
                                             <strong>Festivos transcurridos:</strong> {{$tiempos->festivos}}
                                          </td>
                                       </tr>
                                    @endif

                                    <tr>
                                       <td>Tiempo Total:</td>
                                       <td><strong>Fecha de recepción:</strong> {{$tiempos->recibe}},<br>
                                          <strong>Horas totales de gestión:</strong> {{$tiempos->diferencia}},<br>
                                          <strong>Festivos transcurridos:</strong> {{$tiempos->festivos}}
                                       </td>
                                    </tr>
                                 @endif

                                 <tr>
                                       <td>Imágenes de Registro:</td>
                                       <td>
                                          @foreach ($imagenes as $imagen)
                                             <div class="col-12 col-xs-3">
                                                <a href="../{{$imagen->ruta}}">
                                                   <img src="../{{$imagen->ruta}}" class="img-circle elevation-2" width="100" height="100">
                                                </a>
                                             </div>
                                          @endforeach
                                       </td>
                                 </tr>

                              </tbody>


                           </table>
                           @php
                              $estado = $correspondencia->estado;

                           @endphp
                           <form  action="{{ route('corres.update', $correspondencia->id)}}" method="POST">
                              @if ($estado != 6)


                              @csrf
                              @method('PUT')
                              <input type="hidden" name="observacion" value="{{ $correspondencia->observaciones}}">
                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                       <div class="input-group-text">Agregar Observaciones</div>
                                 </div>
                                 <textarea class="form-control" name="observaciones" id="observaciones" cols="30" rows="2" ></textarea>
                              </div>
                              <input type="hidden" id="control" name="control" value="0">

                                 <button type="submit" class="btn btn-success mb-2">Registrar Observación</button>
                              @endif
                                 @can('haveaccess','corres.index')
                                       <a class="btn btn-warning mb-2" href="/gestioncorres">Listado de Solicitudes</a>
                                       <a class="btn btn-default mb-2" href="/dilitengo">En mi poder</a>
                                 @endcan
                                       <a class="btn btn-info mb-2" href="../../misenvios">Mis Envíos</a>

                           </form>

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


