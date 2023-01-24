<div>
   <div class="btn-group" role="group" aria-label="Basic example">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
         Crear
      </button>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-info" wire:click='periomuestra'>
         Períodica
      </button>
      <a class="btn btn-primary" href="/historial" role="button">Historial</a>
   </div>

@if ($periodica==2)
   <div class="card m-1">
      <div class="card-header">
         Diligencias Períodicas programadas
      </div>
      <ul class="list-group list-group-flush">
         @foreach ($periodili as $perio)
            <li class="list-group-item">
               <small>
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" wire:click='selecdili({{$perio->id}})'>
                     <i class="fas fa-check"></i>
                  </button>
                  <strong>Recoge:</strong> {{$perio->recoge}}
                  <strong>Entrega:</strong> {{$perio->entrega}}
                  <strong>UEN:</strong> {{$perio->uen}}
                  <strong>Centro:</strong> {{$perio->centro}}
                  <strong>Proyecto:</strong> {{$perio->proyecto}}
                  <strong>Comentarios:</strong> {{$perio->comentarios}}
               </small>
            </li>
         @endforeach
      </ul>
   </div>
@endif

   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Diligencia</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                     <label for="sitio">Recolección</label>
                     <select class="custom-select" id="sitio" wire:model='sitio'>
                        <option selected>punto de recolección...</option>
                        <option value="1">Mi oficina</option>
                        <option value="2">Mi Proveedor / Cliente</option>
                        <option value="3">Digito dirección</option>
                     </select>
                  </div>
                  @switch($sitio)

                     @case(0)
                        <p>Seleccione sitio de recolección</p>
                        @break
                     @case(2)
                        <div class="form-group">
                           <label for="exampleInputPassword1">Seleccione Cliente / Proveedor</label>
                           @switch($consultafrecuentes)
                              @case(1)
                                 <select class="custom-select" id="recoleccion" wire:model='recoleccion'>
                                    <option selected>punto de recolección...</option>
                                       @foreach ($recolprovee as $item)
                                          <option value="{{$item->destinatario}} - {{$item->direccion}} - {{$item->ciudad}}">{{$item->destinatario}}</option>
                                       @endforeach
                                 </select>
                                 @break
                              @case(0)
                                 <select class="custom-select" id="recoleccion" >
                                    <option selected>No hay registros</option>
                                 </select>
                                 @break


                           @endswitch
                        </div>
                        @break
                     @case(3)
                           <div class="form-group">
                              <label for="exampleInputPassword1">Digita la dirección</label>
                              <textarea class="form-control" id="recoleccion" wire:model='recoleccion' placeholder="Dirección completa del punto de recolección" required></textarea>
                           </div>
                        @break
                  @endswitch
                  <hr>
                  @if (!empty($recoleccion))
                     <div class="form-group">
                        <label for="sitio">Entrega</label>
                        <select class="custom-select" id="entrega" wire:model='entrega'>
                           <option selected>Punto de Entrega...</option>
                           <option value="1">Mi oficina</option>
                           <option value="2">Mi Proveedor / Cliente</option>
                           <option value="3">Digito dirección</option>
                        </select>
                     </div>
                     @switch($entrega)
                        @case(0)
                           <p>Seleccione sitio de entrega</p>
                           @break
                        @case(2)
                           <div class="form-group">
                              <label for="exampleInputPassword1">Seleccione Cliente / Proveedor</label>
                              @if ($consultafrecuentes==1)
                                 <select class="custom-select" id="direntrega" wire:model='direntrega'>
                                    <option selected>punto de recolección...</option>
                                       @foreach ($recolprovee as $item)
                                          <option value="{{$item->destinatario}}-{{$item->direccion}}-{{$item->ciudad}}">{{$item->destinatario}}</option>
                                       @endforeach
                                 </select>
                              @else
                                 <select class="custom-select" id="recoleccion" >
                                    <option selected>No hay registros</option>
                                 </select>
                              @endif
                           </div>
                           @break
                        @case(3)
                              <div class="form-group">
                                 <label for="exampleInputPassword1">Digita la dirección</label>
                                 <textarea class="form-control" id="direntrega" wire:model='direntrega' placeholder="Dirección completa del punto de entrega" required></textarea>
                              </div>
                           @break

                     @endswitch
                  @endif
                  @if (!empty($direntrega))
                     <hr>
                     <div class="form-group">
                        <label for="uen">Registre UEN del envío si aplica</label>
                        <input type="text" class="form-control" id="uen" wire:model='uen' placeholder="Escriba NO APLICA de ser necesario" required>
                     </div>
                  @endif
                  @if (!empty($uen))
                     <hr>
                     <div class="form-group">
                        <label for="centro">Centro de costos del envío</label>
                        <input type="text" class="form-control" id="centro" wire:model='centro' placeholder="Escriba NO APLICA de ser necesario" required>
                     </div>
                  @endif
                  @if (!empty($centro))
                     <hr>
                     <div class="form-group">
                        <label for="proyecto">A que proyecto pertenece</label>
                        <input type="text" class="form-control" id="proyecto" wire:model='proyecto' placeholder="Escriba NO APLICA de ser necesario" required>
                     </div>
                  @endif
                  @if (!empty($proyecto))
                     <hr>
                     <div class="form-group">
                        <label for="proyecto">En que fecha:</label>
                        <input type="date" class="form-control" id="fecha" wire:model='fecha' required>
                     </div>
                  @endif
                  @if (!empty($fecha))
                     <hr>
                     <div class="form-group">
                        <label for="exampleInputPassword1">Que debemos hacer?</label>
                        <textarea class="form-control" id="comentario" wire:model='comentario' placeholder="Especifica lo que debemos hacer" required></textarea>
                     </div>
                  @endif

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" wire:click='cerrar' data-dismiss="modal">Cerrar</button>
               @if (!empty($comentario))
                  <button type="button" class="btn btn-success" wire:click='crear'>Crear Diligencia</button>
                  @if ($periodica!=2)
                     <div class="form-control form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="periodica" wire:model='periodica'>
                        <label class="form-check-label" for="periodica">
                           Diligencia Períodica
                        </label>
                     </div>
                  @endif
               @endif
               <div>
                  @if (session()->has('messagelim'))
                        <div class="alert alert-success">
                           {{ session('messagelim') }}
                        </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>

</div>
