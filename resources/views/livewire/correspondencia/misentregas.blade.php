<div class="col-12">
   @php
      $total="";
   @endphp
   @can('haveaccess','configcorres')
      @php
         $total=2;
      @endphp
   @endcan
   @can('haveaccess','configcorresuper')
      @php
         $total=1;
      @endphp
   @endcan
   <!-- /.row -->
   <!-- Main content -->
   <section class="content">
      <div class="card">
            <div class="card-header">
               <h3 class="card-title text-uppercase text-bold">Seleccione el período:</h3>
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
                     @if ($total!="")
                        <div class="input-group mb-2 mr-sm-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">Operador</div>
                           </div>
                           <select wire:model='operador' name="operador" id="operador" class="custom-select">
                              <option selected>Seleccione operador</option>
                              @foreach ($operadores as $operador)
                                 <option value="{{$operador->user_id}}">{{$operador->name}}</option>
                              @endforeach
                           </select>
                        </div>
                     @endif
                  </form>
               </div>
               <div class="row justify-content-center">
                  @if (session()->has('periodo'))
                        <div class="alert alert-success">
                           {{ session('periodo') }}
                        </div>
                  @endif
               </div>
               <hr>
                  <div class="row justify-content-center">
                     @switch($serviciocrt)
                        @case(1)
                           <p>!No hay resultados para esta búsqueda!</p>
                           @break
                        @case(2)
                           @if ($seleccionados->count()>0)
                              <table class="table table-bordered table-striped table-responsive">
                                 <thead>
                                    <tr>
                                       <th scope="col" colspan="9">Registros Encontrados: {{$seleccionados->count()}}</th>
                                    </tr>
                                    <tr>
                                       <th scope="col">ID</th>
                                       <th scope="col">Fecha</th>
                                       <th scope="col">Empresa</th>
                                       <th scope="col">Operador</th>
                                       <th scope="col">Descripción</th>
                                       <th scope="col">Dirección</th>
                                       <th scope="col">Ciudad</th>
                                       <th scope="col">Observaciones</th>
                                       <th scope="col">Estado</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($seleccionados as $seleccionado)
                                       <tr>
                                          <td><small>{{$seleccionado->envio}}</small></td>
                                          <td><small>{{$seleccionado->created_at}}</small></td>
                                          <td><small>{{$seleccionado->nombre}}</small></td>
                                          <td><small>{{$seleccionado->name}}</small></td>
                                          <td><small>{{$seleccionado->descripcion}}</small></td>
                                          <td><small>{{$seleccionado->detalle}} - {{$seleccionado->nombresede}}</small></td>
                                          <td><small>{{$seleccionado->nombreubicacion}}</small></td>
                                          <td><small>{{$seleccionado->observaciones}}</small></td>
                                          <td>

                                                @switch($seleccionado->entregado)
                                                   @case(1)
                                                   <i class="fas fa-laugh-beam"></i>
                                                      @break
                                                   @case(2)
                                                      <i class="far fa-sad-tear"></i>
                                                      @break
                                                @endswitch

                                          </td>
                                       </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           @else
                              <h4>¡No hay resultados para esta consulta!</h4>
                           @endif

                           @break
                     @endswitch
                  </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
      </div>
      <!-- /.card -->
   </section>
   <!-- /.content -->
</div>
