<div>
   <div class="col-12">
      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
         <div class="card">
               <div class="card-header">
                  <h3 class="card-title text-uppercase text-bold text-center">Recibir</h3>


               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form wire:submit.prevent='recibir' method="POST" >
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
                                 <div class="input-group-text">Seleccione la Transportadora</div>
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
                           <button type="submit" class="btn btn-default">Mostrar Diligencias</button>
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
                                          <div class="btn-group" role="group" aria-label="Basic example">
                                             <button type="button" wire:click="recibir({{$seleccion->fuerid}})"
                                                   class="btn btn-info"><i class="fas fa-check-double"></i></button>
                                             <button type="button" wire:click="alertar({{$seleccion->fuerid}})"
                                                   class="btn btn-warning"><i class="fas fa-exclamation"></i></button>
                                          </div>
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
                     <p class="text text-cyan">Debes seleccionar una transportadora y registrar un número de guía.</p>
                  @endif
               </div>
         </div>
         <!-- /.card -->
      </section>
      <!-- /.content -->
   </div>
</div>
