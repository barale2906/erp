<div>
   <div class="col-12">
      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
         <div class="card">
               <div class="card-header">
                  <h3 class="card-title text-uppercase text-bold text-center">Enviar</h3>

               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form wire:submit.prevent='enviar' method="POST" >
                     @csrf
                           <div>
                              @if (session()->has('message'))
                                 <div class="alert alert-success">
                                       {{ session('message') }}
                                 </div>
                              @endif
                           </div>
                           <div>
                              @if (session()->has('salida'))
                                 <div class="alert alert-danger">
                                       {{ session('salida') }}
                                 </div>
                              @endif
                           </div>


                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">Transportadora</div>
                              </div>
                              <select wire:model='transportadora' class="custom-select">
                                 <option selected>Seleccione transportador</option>
                                 @foreach ($transportadoras as $transpor)
                                       <option value="{{$transpor->id}}">{{ $transpor->nombre}}</option>
                                 @endforeach

                              </select>
                           </div>
                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">N° Guía</div>
                              </div>
                              <input type="text" class="form-control" wire:model='guia' name="guia" id="guia" required>
                           </div>
                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">N° Envío</div>
                              </div>
                              <select wire:model='correspondencia' class="custom-select" autofocus>
                                 <option selected>Seleccione envío</option>
                                 @foreach ($solicitudes as $solicitud)
                                       <option value="{{$solicitud->id}}">{{$solicitud->id}}-{{ $solicitud->nombredestinatario}}</option>
                                 @endforeach

                              </select>
                           </div>


                           <button type="submit" class="btn btn-default">Asignar Diligencia</button>

                  </form>

               </div>
               <!-- /.card-body -->
               <div class="card-footer">
                  @if ($seleccionadas->count() > 0)
                     <table class="table table-bordered table-striped table-responsive">
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
                              @foreach ($seleccionadas as $seleccion)
                                 <tr>
                                       <td>
                                          <button wire:click="eliminar({{$seleccion->fuerid}})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                       </td>
                                       <td>{{$seleccion->id}}</td>
                                       <td>{{$seleccion->nombredestinatario}}</td>
                                       <td>{{$seleccion->nombresede}}</td>
                                       <td>{{$seleccion->nombreubicacion}}</td>
                                       <td>{{$seleccion->descripcion}}</td>
                                 </tr>
                              @endforeach
                           </tbody>

                     </table>
                  @else
                     <p class="text text-cyan">No has seleccionado ningun envío.</p>
                  @endif
               </div>
         </div>
         <!-- /.card -->
      </section>
      <!-- /.content -->
   </div>
</div>
