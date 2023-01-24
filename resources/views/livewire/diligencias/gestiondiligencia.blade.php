<div class="row justify-content-center">
   <div class="col-xs-12 col-sm-7">
      <div class="input-group mb-3">
         <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Mensajero</label>
         </div>
         <select class="custom-select" id="inputGroupSelect01" wire:model='operadorid'>
            <option selected>Operador...</option>
            @foreach ($operadores as $item)
               <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
         </select>
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 ">
      @if ($listado->count())
         <table class="table table-bordered table-striped table-responsive">
            <thead>
               <tr>
                  <th scope="col"></th>
                  <th scope="col">N°</th>
                  <th scope="col">Comentarios</th>
                  <th scope="col">Recolección</th>
                  <th scope="col">Entrega</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Empresa</th>
                  <th scope="col">Observaciones</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($listado as $item)
                  <tr>
                     <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                           @if ($operadorid)
                              <button type="button" class="btn btn-success btn-xs" wire:click='asigna({{$item->id}})'>
                                 <i class="fas fa-biking"></i>
                              </button>
                           @endif
                           <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#observa"  wire:click='modalcierre({{$item->id}})'>
                              <i class="fas fa-comments"></i>
                           </button>
                        </div>
                     </td>
                     <td>{{$item->id}}</td>
                     <td>{{$item->comentarios}}</td>
                     <td>{{$item->recoge}}</td>
                     <td>{{$item->entrega}}</td>
                     <td>{{$item->fecha}}</td>
                     <td>{{$item->nombre}}</td>
                     <td>{{$item->observaciones}}</td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      @else
      <div class="alert alert-info" role="alert">
         <h5>No hay diligencias nuevas.</h5>
      </div>
      @endif
   </div>
   <div class="col-xs-12 col-sm-12">

         <div class="row mb-4">
            <div class="col form-inline">
                  Por Página: &nbsp;
                  <select wire:model="porpagina" class="form-control">
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                  </select>
            </div>
            <div class="col input-group">
                  <input wire:model.debounce.300ms="buscar" class="form-control" type="text" placeholder="Buscar">
                  <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary form-control" wire:click='limpiar'><i class="fas fa-eraser"></i></button>
                  </div>
            </div>
            @if ($listasig->count())
               <p>Se encontrarón: {{$listasig->total()}} solicitudes activas </p>
            @endif
         </div>
         @if ($listasig->count())
         <table class="table table-bordered table-striped table-responsive">
            <thead>
               <tr>
                  <th scope="col"></th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('id')">
                        ID
                        @if ($ordena != 'id')
                        <i class="fas fa-sort"></i>
                        @else
                        @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                        @else
                        <i class="fas fa-sort-down"></i>
                        @endif
                        @endif
                  </th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('observaciones')">
                        Observaciones
                        @if ($ordena != 'observaciones')
                        <i class="fas fa-sort"></i>
                        @else
                        @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                        @else
                        <i class="fas fa-sort-down"></i>
                        @endif
                        @endif
                  </th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('comentarios')">
                     Comentarios
                     @if ($ordena != 'comentarios')
                        <i class="fas fa-sort"></i>
                     @else
                        @if ($ordenado=='ASC')
                           <i class="fas fa-sort-up"></i>
                        @else
                           <i class="fas fa-sort-down"></i>
                        @endif
                     @endif
                  </th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('fecha')">
                     Fecha - Entrega
                     @if ($ordena != 'fecha')
                        <i class="fas fa-sort"></i>
                     @else
                        @if ($ordenado=='ASC')
                           <i class="fas fa-sort-up"></i>
                        @else
                           <i class="fas fa-sort-down"></i>
                        @endif
                     @endif
               </th>
            </tr>
            </thead>
            <tbody>
               @foreach ($listasig as $item)
                  @if ($imag == $item->id)
                     <tr>
                        <td colspan="5">
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
                           @if ($operadorid)
                              <button type="button" class="btn btn-warning btn-sm"  wire:click='reasigna({{$item->id}})'>
                                 <i class="fas fa-biking"></i><i class="fas fa-exchange-alt"></i>
                              </button>
                           @endif
                           <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cierre"  wire:click='modalcierre({{$item->id}})'>
                              <i class="fas fa-door-closed"></i>
                           </button>
                           <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#observa"  wire:click='modalcierre({{$item->id}})'>
                              <i class="fas fa-comments"></i>
                           </button>                           
                           @if (empty($imag))
                              <button type="button" class="btn btn-info btn-sm" wire:click='imagenes({{$item->id}})'>
                                 <i class="fas fa-camera-retro"></i>
                              </button>
                           @endif
                           @if ($imag == $item->id)
                              <button type="button" class="btn btn-danger btn-sm" wire:click='cancelar'>
                                 <i class="fas fa-times-circle"></i>
                              </button>
                           @endif
                           <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelar"  wire:click='modalcierre({{$item->id}})'>
                              <i class="fas fa-times"></i>
                           </button>
                        </div>
                     </td>
                     <td>
                        {{$item->id}}
                     </td>
                     <td>
                        <small>{{$item->observaciones}}</small>
                     </td>
                     <td>
                        <small>{{$item->comentarios}}</small>
                     </td>
                     <td>
                        <small>[ {{$item->fecha}} ] - {{$item->entrega}}</small>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
         <p>
            Mostrando {{$listasig->firstItem()}} a {{$listasig->lastItem()}} de {{$listasig->total()}} solicitudes
         </p>
         <p>
               {{$listasig->links()}}
         </p>
      @else
         <div class="alert alert-secondary" role="alert">
            No hay diligencias en gestión bajo los criterios de búsqueda.
         </div>
      @endif
   </div>

   <!-- Modal cancelar-->
   <div class="modal fade" id="cancelar" tabindex="-1" aria-labelledby="cancelarLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Cancelar Diligencia N°: {{$diligenciaid}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="observaciones">¿Por qué se cancela la solicitud?</label>
                  <textarea class="form-control" id="observaciones" rows="3" wire:model='observaciones'></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click='cancelar'>Cerrar</button>
               @if ($observaciones)
                  <button type="button" class="btn btn-danger" wire:click='cancelada({{$diligenciaid}})'>Cancelar Diligencia</button>
               @endif
               <div>
                  @if (session()->has('suceso'))
                        <div class="alert alert-success">
                           {{ session('suceso') }}
                        </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal cierre - prepago -->
   <div class="modal fade" id="cierre" tabindex="-1" aria-labelledby="cierreLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            @if ($diligenciaid)
               <div class="modal-header">
                  <h5 class="modal-title" id="cierreLabel">¿Esta seguro de Cerrar la Diligencia N° {{$diligenciaid}}?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  @if ($prepa)
                     <div class="alert alert-warning" role="alert">
                        Este cliente tiene <strong>{{$prepa}}</strong> guías disponibles.
                     </div>
                  @else
                     <div class="alert alert-success" role="alert">
                        Este Cliente no maneja guías prepagadas
                     </div>
                  @endif
                  <div class="form-group">
                     <label for="observaciones">Registre observaciones</label>
                     <textarea class="form-control" id="observaciones" rows="3" wire:model='observaciones'></textarea>
                  </div>
                  @if ($this->observaciones)
                     <div class="form-group">
                        <label for="diligencias">Cantidad de diligencias - guías</label>
                        <input type="number" class="form-control" name="guias" wire:model='guias' placeholder="cuantas diligencias aplica">
                     </div>
                  @endif
               </div>
            @endif

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click='cancelar'>Cancelar</button>
               @if ($guias)
                  @if ($prepa)
                     <button type="button" class="btn btn-warning" wire:click='cierra({{$diligenciaid}})'>Cerrar Diligencia</button>
                  @else
                     <button type="button" class="btn btn-info" wire:click='cierra({{$diligenciaid}})'>Cerrar Diligencia</button>
                  @endif
               @endif
               <div>
                  @if (session()->has('suceso'))
                        <div class="alert alert-success">
                           {{ session('suceso') }}
                        </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal registra observaciones -->
   <div class="modal fade" id="observa" tabindex="-1" aria-labelledby="observaLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="observaLabel">Diligencia N° {{$diligenciaid}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @if ($prepa)
                  <div class="alert alert-warning" role="alert">
                     Este cliente tiene <strong>{{$prepa}}</strong> guías disponibles.
                  </div>
               @else
                  <div class="alert alert-success" role="alert">
                     Este Cliente no maneja guías prepagadas
                  </div>
               @endif
               @if ($diliactual)
                  <p><strong>Recoge:</strong> {{$diliactual->recoge}}</p>
                  <p><strong>Entrega:</strong> {{$diliactual->entrega}}</p>
                  <p><strong>Comentarios:</strong> {{$diliactual->comentarios}}</p>
                  <p><strong>Observaciones:</strong> {{$diliactual->observaciones}}</p>
               @endif
               <div class="form-group">
                  <label for="observaciones">Registre observaciones</label>
                  <textarea class="form-control" id="observaciones" rows="3" wire:model='observaciones'></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click='cancelar'>Cancelar</button>
               @if ($observaciones)
                  <button type="button" class="btn btn-warning" data-dismiss="modal" wire:click='observa'>Guarda Observación</button>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
