<div>
   <div class="row justify-content-center">
      <div class="col-12">
         <div class="card card-yellow collapsed-card" wire:ignore.self>
               <div class="card-header">
                  <h3 class="card-title">RUTAS</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                           <i class="fas fa-plus"></i></button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                     <i class="fas fa-times"></i></button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12">
                           <div class="card">
                              <div class="card-header">
                                 <h3 class="card-title center">Nueva Ruta</h3>
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body">
                                 <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#rutas">
                                       VER RUTAS
                                 </button>
                                 <form wire:submit.prevent='submit' method="POST" >
                                       @csrf
                                          <div>
                                             @if (session()->has('message'))
                                                   <div class="alert alert-success">
                                                      {{ session('message') }}
                                                   </div>
                                             @endif
                                          </div>


                                             <div class="input-group mb-2 mr-sm-2">
                                                   <div class="input-group-prepend">
                                                      <div class="input-group-text">Nombre</div>
                                                   </div>
                                                   <input type="text" class="form-control" wire:model='nombre' name="nombre" id="nombre" required>
                                             </div>
                                             <div class="input-group mb-2 mr-sm-2">
                                                   <div class="input-group-prepend">
                                                   <div class="input-group-text">Descripción</div>
                                                   </div>
                                                   <textarea class="form-control" wire:model='descripcion' name="descripcion" id="descripcion" cols="30" rows="4" required></textarea>
                                             </div>
                                             <button type="submit" class="btn btn-default">Crear</button>

                                 </form>
                              </div>
                              <!-- /.card-body -->
                           </div>
                           <!-- /.card -->
                     </div>

                  </div>
               </div>
               <!-- /.card-body -->
               <div class="card-footer">
               </div>
               <!-- /.card-footer-->
         </div>
         <!-- Modal -->
         <div class="modal fade" id="rutas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog  modal-xl" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Listado de Rutas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <div class="modal-body">
                     @if ($rutas->count()>0)
                     <table id="misrutas" class="table table-bordered table-striped table-responsive">
                           <thead>
                              <tr>
                                 <th></th>
                                 <th scope="col">Nombre</th>
                                 <th scope="col">Descripción</th>

                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($rutas as $ruta)
                              <tr>
                                 <td></td>
                                 <td>{{$ruta->nombre}}</td>
                                 <td>{{$ruta->descripcion}}</td>
                              </tr>
                              @endforeach
                           </tbody>

                     </table>
                     @else
                           <p>No se han generado rutas.</p>
                     @endif

                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                  </div>
               </div>
               </div>
         </div>
      </div>
   </div>
   <!-- /.row -->
</div>
