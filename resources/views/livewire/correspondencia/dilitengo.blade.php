<div class="row justify-content-center">
   <div class="col-12">
      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
            <div class="card">
               <div class="card-header">
               <h3 class="card-title text-uppercase text-bold text-center">Ver y Editar las diligencias en tu poder</h3>

               </div>
               <!-- /.card-header -->
               <div class="card-body">

                  <table id="total" class="table table-bordered table-striped table-responsive">
                     <thead>
                           <tr>
                              <th></th>
                              <th scope="col">ID</th>
                              <th scope="col">Destinatario</th>
                              <th scope="col">Sede/Dirección</th>
                              <th scope="col">Área/Ciudad</th>
                              <th scope="col">Descripción</th>
                           </tr>
                     </thead>
                     <tbody>
                        @foreach ($dilitengo as $dilit)
                        <tr>
                           <td>
                              <div class="btn-group" role="group" aria-label="Basic example">
                                 <!-- Button trigger modal -->
                                 <button type="button" wire:click="detalle({{$dilit->id}})" class="btn btn-info"
                                    data-toggle="modal" data-target="#editar">
                                    <i class="fas fa-marker"></i>
                                 </button>
                                 <a class="btn btn-info" href="{{route('corres.edit', $dilit->id)}}"><i class="fas fa-search-plus"></i></a>
                              </div>
                           </td>
                           <td>{{$dilit->id}}</td>
                           <td>{{$dilit->nombredestinatario}}</td>
                           <td>{{$dilit->nombresede}}</td>
                           <td>{{$dilit->nombreubicacion}}</td>
                           <td>{{$dilit->descripcion}}</td>
                        </tr>
                        @endforeach
                     </tbody>

                  </table>

               </div>
               <!-- /.card-body -->
               <div class="card-footer">

               </div>
            </div>
            <!-- /.card -->
      </section>
      <!-- /.content -->
   </div>
   <!-- Modal -->
   <div class="modal fade" id="editar" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-uppercase" id="exampleModalLabel">Registrar entrega a la solicitud N° {{$actual}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body"> 
               <form class="form-inline" action="{{ route('cargafoto')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                     <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">Entregado</div>
                        </div>
                        <select class="custom-select" name="entregado" id="entregado"
                           wire:model="entregado" wire:change="estadoentrega" required>
                           <option selected>Seleccione una opción...</option>
                           <option value="1">SI</option>
                           <option value="2">NO</option>
                        </select>
                     </div>
                     @if ($entregar==2)
                        <div class="input-group mb-2 mr-sm-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">Motivo Devolución</div>
                           </div>
                           <select class="custom-select" name="motivo" id="motivo" required>
                                 <option selected>Seleccione motivo...</option>
                              @foreach ($motivos as $motivo)
                                 <option value="{{$motivo->id}}">{{$motivo->motivo}}</option>
                              @endforeach
                           </select>
                        </div>
                     @endif
                     @if ($entregar>0)
                        <div class="input-group mb-2 mr-sm-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">Observación de entrega</div>
                           </div>
                           <textarea name="actualizacie" id="actualizacie" required></textarea>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">Seleccione la imagen</div>
                           </div>
                           <input type="file"  name="foto" id="foto" required>
                        </div>
                        <input type="hidden" name="correspondencia_id" id="correspondencia_id" value="{{$actual}}" >
                        <button type="submit" class="btn btn-warning" wire:click="borrarentregar">
                           <i class="fas fa-truck"></i>
                        </button>
                     @endif

               </form>
            </div>
         </div>
      </div>
   </div>
</div>
