<div>
   @can('haveaccess','configcorres')
      <!-- Main content -->
   <section class="content">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title text-uppercase text-bold text-center text-capitalize">Solicitudes Abiertas</h3>
               @if (session()->has('message'))
                  <div class="row alert alert-success">
                     {{ session('message') }}
                  </div>
               @endif
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <div class="row justify-content-center">

               <div class="row mb-4">
                  <div class="col form-inline">
                     Por Página: &nbsp;
                     <select wire:model="porpagina" class="form-control">
                        <option>2</option>
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>100</option>
                     </select>
                  </div>

                  <div class="col">
                     <input wire:model.debounce.300ms="buscar" class="form-control" type="text" placeholder="Buscar">
                  </div>
                  <p>Se encontrarón: {{$abiertas->total()}} solicitudes</p>
               </div>

               <table class="table table-bordered table-striped table-responsive">
                  <thead>
                     <tr>
                        <th scope="col" style="cursor: pointer;" ></th>
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
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('nombredestinatario')">
                           Destinatario
                           @if ($ordena != 'nombredestinatario')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('nombresede')">
                           Dirección
                           @if ($ordena != 'nombresede')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('nombreubicacion')">
                           Ciudad
                           @if ($ordena != 'nombreubicacion')
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
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('planilla')">
                           Planilla
                           @if ($ordena != 'planilla')
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
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($abiertas as $abierta)
                        <tr>
                           <td>
                              <div class="btn-group" role="group" aria-label="Basic example">
                                 <button type="button" wire:click="cerrar({{$abierta->id}})" class="btn btn-warning"><i class="fas fa-door-closed"></i></button>
                                 <a class="btn btn-info" href="{{route('corres.edit', $abierta->id)}}"><i class="fas fa-search-plus"></i></a>
                              </div>
                           </td>
                           <td>{{$abierta->id}}</td>
                           <td>{{$abierta->nombredestinatario}}</td>
                           <td>{{$abierta->nombresede}}</td>
                           <td>{{$abierta->nombreubicacion}}</td>
                           <td>{{$abierta->observaciones}}</td>
                           <td>{{$abierta->planilla}}</td>
                           <td>
                              @switch($abierta->estado)
                                 @case(1)
                                    Creado
                                    @break
                                 @case(2)
                                    Devuelto
                                    @break
                                 @case(3)
                                    Fuera
                                    @break
                                 @case(4)
                                    Alertado
                                    @break
                                 @case(5)
                                    Ruta
                                    @break
                                 @case(7)
                                    Entregado
                                    @break
                              @endswitch
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
               <p>
                  Mostrando {{$abiertas->firstItem()}} a {{$abiertas->lastItem()}} de {{$abiertas->total()}} solicitudes
               </p>
               <p>
                  {{$abiertas->links()}}
               </p>
            </div>
         </div>
         <!-- /.card-body -->
         <div class="card-footer">
         </div>
      </div>
      <!-- /.card -->
   </section>
   <!-- /.content -->
   @endcan
</div>
