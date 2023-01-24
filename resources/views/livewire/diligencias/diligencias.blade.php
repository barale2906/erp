<div>
   <div>
      @if (session()->has('messagelim'))
            <div class="alert alert-success">
               {{ session('messagelim') }}
            </div>
      @endif
   </div>
   <h3>Diligencias en gestión</h3>
   @if ($prepa)
      <div class="row justify-content-center">
         <div class="col-6">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
               <strong>GUÍAS PREPAGADAS</strong> Tiene {{$prepa}} guías disponibles.
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
         </div>
      </div>
   @endif
   @if ($listado->count())
      <table class="table table-bordered table-striped table-responsive">
         <thead>
            <tr>
               <th colspan="5">CONTROL</th>
               <th>RECOLECCIÓN</th>
               <th>ENTREGA</th>
               <th colspan="3">GESTIÓN</th>
            </tr>
            <tr>
               <th scope="col"></th>
               <th scope="col">N°</th>
               <th scope="col">UEN</th>
               <th scope="col">Centro de Costos</th>
               <th scope="col">Proyecto</th>
               <th scope="col">Dirección de recolección</th>
               <th scope="col">Dirección de entrega</th>
               <th scope="col">Fecha</th>
               <th scope="col">Comentarios</th>
               <th scope="col">Observaciones</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($listado as $item)
               @if ($imag == $item->id)
                  <tr>
                     <td>
                        @if ($control==1)
                           @foreach ($imagenesta as $image)
                              <img src="{{$image->ruta}}" class="img-thumbnail" alt="SOMOS ENVIOS Y DILIGENCIAS S.A.S.">
                           @endforeach
                        @else
                           <h4>No tiene imagenes cargadas</h4>
                        @endif
                     </td>
                  </tr>
               @endif
               <tr>
                  <td>
                     <div class="btn-group" role="group" aria-label="Basic example">
                        @if ($item->estado==1)
                           <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modificaModal" wire:click='elimina({{$item->id}})'>
                              <i class="fas fa-trash-alt"></i>
                           </button>
                        @endif
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modificaModal" wire:click='cierra({{$item->id}})'>
                           <i class="fas fa-door-closed"></i>
                        </button>
                        @if ($imag == $item->id)
                           <button type="button" class="btn btn-warning btn-xs" wire:click='cancelar'>
                              <i class="fas fa-times-circle"></i>
                           </button>
                        @else
                           <button type="button" class="btn btn-info btn-xs" wire:click='imagenes({{$item->id}})'>
                              <i class="fas fa-camera-retro"></i>
                           </button>
                        @endif
                     </div>
                  </td>
                  <td>{{$item->id}}</td>
                  <td>{{$item->uen}}</td>
                  <td>{{$item->centro}}</td>
                  <td>{{$item->proyecto}}</td>
                  <td>{{$item->recoge}}</td>
                  <td>{{$item->entrega}}</td>
                  <td>{{$item->fecha}}</td>
                  <td>{{$item->comentarios}}</td>
                  <td>{{$item->observaciones}}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   @else
      <div class="alert alert-primary" role="alert">
         No tienes diligencias activas
      </div>
   @endif
   <!-- Modal -->
   <div class="modal fade" id="modificaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modificaModalLabel">
               @switch($accion)
                  @case(1)
                     Cierra Diligencia
                     @break
                  @case(2)
                     ELIMINA DILIGENCIA
                     @break
               @endswitch
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            @switch($accion)
               @case(1)
                  <h6>Esta seguro(a) de cerrar la diligencia N° {{$diligenciaid}}</h6>
                  <p>Esta Operación es irreversible</p>
                  @break
               @case(2)
                  <div class="alert alert-danger" role="alert">
                     <h6>Esta seguro(a) de ELIMINAR la diligencia N° {{$diligenciaid}}</h6>
                  <p>Esta Operación es irreversible</p>
                  </div>
                  @break
            @endswitch
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            @switch($accion)
               @case(1)
                  <button type="button" class="btn btn-warning" wire:click='cierrasol'>Cerrar Diligencia</button>
                  @break
               @case(2)
                  <button type="button" class="btn btn-danger" wire:click='elimsol'>ELIMINAR DILIGENCIA</button>
                  @break
            @endswitch
            <div>
               @if (session()->has('messagecierre'))
                     <div class="alert alert-success">
                        {{ session('messagecierre') }}
                     </div>
               @endif
            </div>
         </div>
      </div>
      </div>
   </div>
</div>
