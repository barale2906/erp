<div class="row justify-content-center">
   @if ($control!=4)
   <div class="col-xs-12 col-sm-12 ">
      <button type="button" class="btn btn-success btn-sm" wire:click='busca'><i class="fas fa-search"></i></button>
      @if ($diligencias->count())
         <table class="table table-bordered table-striped table-responsive">
            <thead>
               <tr>
                  <th scope="col">Datos</th>                  
               </tr>
            </thead>
            <tbody>
               @foreach ($diligencias as $item)                  
                  @if ($imag == $item->diligencia->id)
                     <tr>
                        <td>
                           @if ($control==1)
                              <div class="row">
                                 @foreach ($imagenesta as $image)
                                       <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                          <div class="text-center">
                                             <a href="{{$image->ruta}}" class="btn btn-sm" target="_blank">
                                                <img src="{{$image->ruta}}" alt="SOMOS ENVIOS Y DILIGENCIAS S.A.S." class="img-circle img-fluid">
                                             </a>                                          
                                          </div>                                     
                                       </div>
                                 @endforeach
                              </div>
                           @else
                              <h4>No tiene imagenes cargadas</h4>
                           @endif
                        </td>
                     </tr>
                  @endif
                  <tr>
                     <td>
                        <small>
                           @if ($item->diligencia->estado==2)
                              <button type="button" class="btn btn-info btn-xs" wire:click='recibir({{$item->diligencia->id}})'>
                                 <i class="fas fa-check"></i> Recibir
                              </button>
                           @else
                              <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#exampleModal" wire:click='modalcierre({{$item->diligencia->id}}, 2)'>
                                 <i class="fas fa-comments"></i>
                               </button>
                              <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModal" wire:click='modalcierre({{$item->diligencia->id}}, 3)'>                               
                                 <i class="fas fa-check"></i>
                              </button>
                              @if ($imag == $item->diligencia->id)
                                 <button type="button" class="btn btn-danger btn-xs" wire:click='cancelar'>
                                    <i class="fas fa-times-circle"></i>
                                 </button>
                              @else
                                 @if (empty($imag))
                                    <button type="button" class="btn btn-info btn-xs" wire:click='imagenes({{$item->diligencia->id}})'>
                                       <i class="fas fa-camera-retro"></i>
                                    </button>
                                 @endif                                 
                              @endif
                              
                           @endif
                           ---
                           [{{$item->diligencia->id}}] - <strong>Recoge: </strong> {{$item->diligencia->recoge}}                           -
                           - <strong>Entrega: </strong> {{$item->diligencia->entrega}}
                           - <strong>Comentarios: </strong> {{$item->diligencia->comentarios}}
                           - <strong>Fecha: </strong> {{$item->diligencia->fecha}}
                           - <strong>Observaciones: </strong>{{$item->diligencia->observaciones}}
                        </small>
                     </td>
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

   @endif
   @if ($control==4)
      <div class="col-xs-12 col-sm-12 ">
         <div class="row mb-4">
            <div class="col form-inline">
               Por Página: &nbsp;
               <select wire:model="porpagina" class="form-control">
                  <option>2</option>
                  <option>5</option>
                  <option>10</option>
                  <option>20</option>
                  <option>50</option>
               </select>
            </div>
            <div class="col input-group">
               <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary form-control" wire:click='limpiar'>Inicio</button>
               </div>
               <input wire:model.debounce.300ms="inicio" class="form-control" type="date" >
               <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary form-control" wire:click='limpiar'>Fin</button>
               </div>
               <input wire:model.debounce.300ms="fin" class="form-control" type="date" >
               <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary form-control" wire:click='limpiar'><i class="fas fa-eraser"></i></button>
               </div>
            </div>
            @if ($misdiligencias)
               <p>Se encontrarón: {{$misdiligencias->total()}} solicitudes activas </p>
            @endif
         </div>
         @if ($misdiligencias)
            <table class="table table-bordered table-striped table-responsive">
               <thead>
                  <tr>
                     <th scope="col" style="cursor: pointer;" wire:click="ordena('fecha')">
                        Información de la Diligencia
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
                     <th scope="col" style="cursor: pointer;" wire:click="ordena('guias')">
                        Cantidad
                        @if ($ordena != 'guias')
                           <i class="fas fa-sort"></i>
                        @else
                           @if ($ordenado=='ASC')
                              <i class="fas fa-sort-up"></i>
                           @else
                              <i class="fas fa-sort-down"></i>
                           @endif
                        @endif
                     </th>
                     <th scope="col" style="cursor: pointer;" wire:click="ordena('estado')">
                        Estado
                        @if ($ordena != 'estado')
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
                  @foreach ($misdiligencias as $item)
                     <tr>
                        <td>
                           <small>
                              <strong>ID: </strong>{{$item->id}}
                              <strong> FECHA:</strong>{{$item->fecha}}
                              <strong> RECOGE: </strong>{{$item->recoge}}
                              <strong> ENTREGA:</strong>{{$item->entrega}}
                              <strong> COMENTARIOS: </strong>{{$item->comentarios}}
                              <strong> OBSERVACIONES</strong>{{$item->observaciones}}
                           </small>
                        </td>
                        <td>
                           @if ($item->estado != 3)
                              {{$item->guias}}
                           @endif
                        </td>
                        <td>
                           @switch($item->estado)
                              @case(1)
                                 Asignada a ti
                                 @break
                              @case(2)
                                 Ejecutada por ti
                                 @break
                              @case(3)
                                 Reasignada a un compañero
                                 @break
                              @case(4)
                                 Se te pago
                                 @break
                              @case(5)
                                 Cancelo el cliente
                                 @break
                           @endswitch
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
            <p>
               Mostrando {{$misdiligencias->firstItem()}} a {{$misdiligencias->lastItem()}} de {{$misdiligencias->total()}} solicitudes
            </p>
            <p>
                  {{$misdiligencias->links()}}
            </p>
         @endif

      </div>
   @endif
   
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
         <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
         @if (!empty($control))
                  <h5 class="modal-title" id="exampleModalLabel">Diligencia N°: {{$diliactual}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            @if ($control==2)
            
               <form wire:submit.prevent="cargaimagenobser" enctype="multipart/form-data" method="POST">
            
               
                     <div class="modal-body">               
                           <div class="form-group">
                              <label for="observaciones">Registre observaciones</label>
                              <textarea class="form-control" id="observaciones" rows="3" wire:model='observaciones' required></textarea>
                              @error('observaciones') <span class="error text-danger">{{ $message }}</span> @enderror
                           </div>
                           <div class="form-group">
                              <label for="entrego">Entrega la diligencia</label>
                              <select class="custom-select" id="entrego" wire:model='entrego' aria-label="Example select with button addon">
                                 <option selected>Entrego?...</option>
                                 <option value="1">Si</option>
                                 <option value="2">No</option>
                              </select>
                              @error('entrego') <span class="error text-danger">{{ $message }}</span> @enderror
                           </div>
                           
                           <div class="form-group">
                              <label for="imagentrega">Cargar Imagen</label>
                              <input type="file" class="form-control-file" id="imagentrega" wire:model='imagentrega' required>                              
                              @error('imagentrega') <span class="error text-danger">{{ $message }}</span> @enderror
                           </div>
                                                      
                           
                                       
                     </div>
                  <div class="modal-footer">  
                     @if ($imagentrega)
                        @can('haveaccess','diligencia.mensajero')
                           <button type="submit" class="btn btn-warning" >Guarda Registro</button>
                        @endcan    
                     @endif             
               
               </form>
            
            @endif
            @if ($control==3)
               <form wire:submit.prevent="finalizar" enctype="multipart/form-data" method="POST">
                  <div class="modal-body">
                     <div class="form-group">
                        <label for="observaciones">Registre observaciones</label>
                        <textarea class="form-control" id="observaciones" rows="3" wire:model='observaciones' required></textarea>
                        @error('observaciones') <span class="error text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="form-group">
                        <label for="pago">Registrar pago de la diligencia</label>
                        <input type="number" class="form-control-file" id="pago" wire:model='pago' >
                        <span class="text-danger">Solamente registrar el valor de la diligencia SIN PUNTOS NI COMAS, </span><br>
                        <span class="text-danger">¡REGISTRE SOLAMENTE PAGO DE LA DILIGENCIA!</span>
                     </div>
                  </div>
                  <div class="modal-footer">
                  @can('haveaccess','diligencia.mensajero')
                     <button type="submit" class="btn btn-warning" >Finalizar Diligencia</button>
                  @endcan
               </form>
            @endif            
         @endif
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click='cancelar'>Cancelar</button>
                  <div>
                     @if (session()->has('suceso'))
                        <div class="alert alert-warning" role="alert">
                           <strong>¡Importante!</strong> {{ session('suceso') }}
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     @endif
                  </div>
               </div>
            
            </div>
            </div>
      </div>
   
   
</div>
