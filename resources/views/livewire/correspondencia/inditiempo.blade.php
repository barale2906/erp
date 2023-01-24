<div class="col-12">

      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
         <div class="card">
               <div class="card-header">
                  <h3 class="card-title text-uppercase text-bold">Seleccione el período de generación de los envíos</h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <div wire:loading>
                     <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>¡¡Procesando la información!!</strong> Por favor espera, esta operación puede tardar unos minutos.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                  </div>
                  <div class="row justify-content-center">
                     @if (empty($resultados))
                        <div class="col-6">
                           <form class="form-inline">
                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                    <div class="input-group-text">Fecha Inicio</div>
                                 </div>
                                 <input type="date" class="form-control" wire:model.lazy='fechaini'
                                    name="fechaini" id="fechaini" autofocus>
                              </div>
                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                    <div class="input-group-text">Fecha Fin</div>
                                 </div>
                                 <input type="date" class="form-control" wire:model.lazy='fechafin' name="fechafin" id="fechafin" required>
                              </div>
                           </form>
                        </div>
                     @endif

                     @if (!empty($resultados))
                        <div class="col-8">
                           <table class="table table-bordered table-striped table-responsive">
                              <thead>
                                 <tr>
                                    <th colspan="7">INFORME DE ENTREGAS DURANTE EL {{$fechaini}} Y EL {{$fechafin}}</th>
                                 </tr>
                                 <tr>
                                    <th scope="col">Total</th>
                                    <th scope="col">Mensajero</th>
                                    <th scope="col">%</th>
                                    <th scope="col">Completo</th>
                                    <th scope="col">%</th>
                                    <th scope="col">No Entregado</th>
                                    <th scope="col">%</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @php
                                    $pormen=($mensajero/$tiempos->count())*100; $pormen =  round($pormen, 2);
                                    $porcom=($completo/$tiempos->count())*100; $porcom = round($porcom, 2);
                                    $pornoe=($noentregado/$tiempos->count())*100; $pornoe = round($pornoe, 2);
                                 @endphp
                                 <tr>
                                    <td>{{$tiempos->count()}}</td>
                                    <td>{{$mensajero}}</td>
                                    <td>{{$pormen}}</td>
                                    <td>{{$completo}}</td>
                                    <td>{{$porcom}}</td>
                                    <td>{{$noentregado}}</td>
                                    <td>{{$pornoe}}</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <div class="col-1">
                           <form action="inditiempoxls" method="POST">
                              @csrf
                                 <input type="hidden" value="{{$fechaini}}" name="fechaini" id="fechaini">
                                 <input type="hidden" value="{{$fechafin}}" name="fechafin" id="fechafin">
                                    <button type="submit" class="btn btn-success">
                                       <i class="far fa-file-excel"></i>
                                    </button>
                              </form>
                        </div>
                     @endif
                  </div>

                  <hr>
                  @if (!empty($resultados))
                     <div class="row">
                        <div class="col-12 col-sm-6">
                           <table class="table table-bordered table-striped table-responsive">
                              <thead>
                                    <tr>
                                       <th colspan="3">ENVÍO</th>
                                       <th colspan="2">MENSAJERO<br> <small>(Horas, Aplica para diligencias externas con planilla)</small></th>
                                       <th colspan="2">TOTAL<br> <small>(Horas)</small></th>
                                    </tr>
                                    <tr>
                                       <th scope="col">ID</th>
                                       <th scope="col">Fecha Envío</th>
                                       <th scope="col">Festivos</th>
                                       <th scope="col">Fecha Entrega</th>
                                       <th scope="col">Tiempo</th>
                                       <th scope="col">Recepción</th>
                                       <th scope="col">Tiempo</th>

                                    </tr>
                              </thead>
                              <tbody>
                                 @foreach ($resultados as $resultado)
                                    <tr>
                                       <td>{{$resultado->correspondencia_id}}</td>
                                       <td>{{$resultado->fecha}}</td>
                                       <td>{{$resultado->festivos}}</td>
                                       <td>{{$resultado->entrega}}</td>
                                       <td>
                                          @if ($resultado->diferem<0)
                                             0
                                          @else
                                             {{$resultado->diferem}}
                                          @endif

                                       </td>
                                       <td>{{$resultado->recibe}}</td>
                                       <td>
                                          @if ($resultado->diferencia<0)
                                             0
                                          @else
                                             {{$resultado->diferencia}}
                                          @endif
                                       </td>

                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           {{$resultados->links()}}
                        </div>
                        <div class="col-12 col-sm-6">
                           <table class="table table-bordered table-striped table-responsive">
                              <thead>

                                    <tr>
                                       <th scope="col">ID</th>
                                       <th scope="col">Fecha Envío</th>
                                       <th scope="col">Festivos</th>
                                       <th scope="col">24</th>
                                       <th scope="col">48</th>
                                       <th scope="col"><small>Arriba de 48</small></th>
                                       <th scope="col"><small>No Entregado</small></th>

                                    </tr>
                              </thead>
                              <tbody>
                                 @foreach ($tiempos as $tiempo)
                                    <tr>
                                       <td>{{$tiempo->correspondencia_id}}</td>
                                       <td>{{$tiempo->fecha}}</td>
                                       <td>{{$tiempo->festivos}}</td>
                                       <td>
                                          @if ($tiempo->diferem!=null && $tiempo->diferem<=24)
                                             1
                                          @endif
                                       </td>
                                       <td>
                                          @if ($tiempo->diferem>24 && $tiempo->diferem<=48)
                                             1
                                          @endif
                                       </td>
                                       <td>
                                          @if ($tiempo->diferem>48)
                                             1
                                          @endif
                                       </td>
                                       <td>
                                          @if ($tiempo->diferem==null)
                                             1
                                          @endif
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  @endif
               </div>
               <!-- /.card-body -->
               <div class="card-footer">
               </div>
         </div>
         <!-- /.card -->
      </section>
      <!-- /.content -->
</div>
