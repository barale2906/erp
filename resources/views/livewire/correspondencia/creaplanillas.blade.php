<div class="row justify-content-center">
   @if ($mostrar==1)
      @if (empty($idplani))
         <div class="col-12 col-sm-6">
               <!-- /.row -->
               @if ($numeracion->count()>=1)
                  <!-- Main content -->
                  <section class="content">
                     <div class="card">
                           <div class="card-header">
                           <h3 class="card-title text-uppercase text-bold text-center">Crear Planilla para la ruta {{$nombreruta->nombre}}</h3>

                           </div>
                           <!-- /.card-header -->
                           <div class="card-body">
                                 <form wire:submit.prevent='crear' method="POST" >
                                       @csrf
                                          <div>
                                             @if (session()->has('message'))
                                                   <div class="alert alert-success">
                                                      {{ session('message') }}
                                                   </div>
                                             @endif
                                          </div>
                                          <div>
                                             @if (session()->has('eliminar'))
                                                   <div class="alert alert-danger">
                                                      {{ session('eliminar') }}
                                                   </div>
                                             @endif
                                          </div>
                                          <div class="input-group mb-2 mr-sm-2">
                                             <div class="input-group-prepend">
                                                   <div class="input-group-text">Fecha:</div>
                                             </div>
                                             <input type="date" class="form-control" wire:model='fecha' name="fecha" id="fecha" required>
                                          </div>
                                          <div class="input-group mb-2 mr-sm-2">
                                             <div class="input-group-prepend">
                                                   <div class="input-group-text">Asignar Operador</div>
                                             </div>
                                             <select wire:model='operador' class="custom-select">
                                                   <option selected>Seleccione Operador</option>
                                                   @foreach ($operadores as $operadore)
                                                      <option value="{{$operadore->id}}">{{ $operadore->name}}</option>
                                                   @endforeach
                                             </select>
                                          </div>
                                          <div class="input-group mb-2 mr-sm-2">
                                             <div class="input-group-prepend">
                                             <div class="input-group-text">Observaciones</div>
                                             </div>
                                             <textarea class="form-control" wire:model='observaciones' name="observaciones" id="observaciones" cols="30" rows="4" required></textarea>
                                          </div>
                                          <div class="input-group mb-2 mr-sm-2">
                                             <div class="input-group-prepend">
                                                   <div class="input-group-text">Número de diligencias a asignar:</div>
                                             </div>
                                             <select wire:model='cantidad' class="custom-select" required>
                                                      <option selected>Seleccione</option>
                                                   @foreach ($numeracion as $numero)
                                                      <option value="{{$numero->orden}}">{{$numero->orden}}</option>
                                                   @endforeach
                                             </select>
                                          </div>


                                          <button type="submit" class="btn btn-default">Crear</button>

                                 </form>
                           </div>
                           <!-- /.card-body -->
                           <div class="card-footer">
                              @if ($planillasabiertas->count()>0)
                                 <h5 class="text text-capitalize">Planillas en proceso</h5>
                                 <table class="table table-bordered table-striped table-responsive">
                                       <thead>
                                          <tr>
                                             <th></th>
                                             <th scope="col">Fecha</th>
                                             <th scope="col">Ruta</th>
                                             <th scope="col">Operador</th>
                                             <th scope="col">Observaciones</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($planillasabiertas as $plani)
                                          <tr>
                                             <td><button type="button" wire:click="editar({{$plani->planid}})"
                                                   class="btn btn-info"><i class="far fa-edit"></i></button></td>
                                             <td>{{$plani->fecha}}</td>
                                             <td>{{$plani->nombre}}</td>
                                             <td>{{$plani->name}}</td>
                                             <td><small>{{$plani->observaciones}}</small></td>
                                          </tr>
                                          @endforeach
                                       </tbody>

                                 </table>
                              @else
                                 <p>No hay planillas en proceso.</p>
                              @endif
                           </div>
                     </div>
                     <!-- /.card -->
                  </section>
               <!-- /.content -->
               @else
                  <div class="col-4">
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                           <strong>{{Auth::user()->name}}</strong> ¡Ya asignaste todas las diligencias de la ruta {{$nombreruta->nombre}}!
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                     </div>
                  </div>

               @endif


         </div>
      @else
         <div class="col-12">
               <!-- /.row -->
               <!-- Main content -->
               <section class="content">
                  <div class="card">
                     <div class="card-header">

                           <h3 class="card-title text-uppercase text-bold text-center">Editar Planilla N°: {{$idplani}}
                           con fecha: {{$planillactual->fecha}}</h3>
                           <div>
                              @if (session()->has('modifico'))
                                 <div class="alert alert-warning">
                                       {{ session('modifico') }}
                                 </div>
                              @endif
                           </div>
                           <div class="card-tools">
                              <button type="button" wire:click="cerrar()"
                              class="btn btn-default"><i class="fas fa-times"></i></button>
                           </div>
                     </div>
                     <!-- /.card-header -->
                     <div class="card-body">
                           <form wire:submit.prevent='modificar' class="form-inline" method="POST" >
                              @csrf

                                 <div class="input-group mb-2 mr-sm-2">
                                       <div class="input-group-prepend">
                                          <div class="input-group-text">Actualizar Operador</div>
                                       </div>
                                       <select wire:model='operador' class="custom-select">
                                          <option value="{{$planillactual->id}}">{{$planillactual->name}}</option>
                                          @foreach ($operadores as $operadore)
                                             @if ($operadore->id != $planillactual->id)
                                                   <option value="{{$operadore->id}}">{{ $operadore->name}}</option>
                                             @endif
                                          @endforeach
                                       </select>
                                 </div>
                                 <div class="input-group mb-2 mr-sm-2">
                                       <div class="input-group-prepend">
                                       <div class="input-group-text">Observaciones</div>
                                       </div>
                                       {{$planillactual->observaciones}}
                                 </div>

                                 <button type="submit" class="btn btn-default">Modificar</button>
                                 <button type="button" wire:click="eliminar({{$idplani}})"
                                       class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                           </form>

                           <hr>

                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer">
                           @if ($planillasabiertas->count()>0)
                              <h5 class="text text-capitalize">Planillas en elaboración</h5>
                              <table class="table table-bordered table-striped">
                                 <thead>
                                       <tr>
                                          <th></th>
                                          <th scope="col">Fecha</th>
                                          <th scope="col">Ruta</th>
                                          <th scope="col">Operador</th>
                                          <th scope="col">Observaciones</th>

                                       </tr>
                                 </thead>
                                 <tbody>
                                       @foreach ($planillasabiertas as $plani)
                                       <tr>
                                          <td><button type="button" wire:click="editar({{$plani->planid}})"
                                             class="btn btn-info"><i class="fas fa-check-double"></i></button></td>
                                          <td>{{$plani->fecha}}</td>
                                          <td>{{$plani->nombre}}</td>
                                          <td>{{$plani->name}}</td>
                                          <td><small>{{$plani->observaciones}}</small></td>
                                       </tr>
                                       @endforeach
                                 </tbody>

                              </table>
                           @else
                              <p>No hay planillas en proceso.</p>
                           @endif
                     </div>
                  </div>
                  <!-- /.card -->
               </section>
               <!-- /.content -->
         </div>
      @endif
   @endif
</div>
