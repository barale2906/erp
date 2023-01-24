<div>
   <div class="row mb-4">
      <div class="col form-inline">
         Por Página: &nbsp;
         <select wire:model="porpagina" class="form-control">
            <option>2</option>
            <option>5</option>
            <option>10</option>
            <option>20</option>
         </select>
      </div>

      <div class="col">
         <input wire:model.debounce.300ms="buscar" class="form-control" type="text" placeholder="Buscar">
      </div>

      <p>Se encontrarón: {{$diligencias->total()}} diligencias</p>
   </div>
   @if ($diligencias->count())

      <table class="table table-bordered table-striped table-responsive">
         <thead>
            <tr>
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
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('uen')">
                     UEN
                     @if ($ordena != 'uen')
                     <i class="fas fa-sort"></i>
                     @else
                     @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                     @else
                        <i class="fas fa-sort-down"></i>
                     @endif
                     @endif
                  </th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('centro')">
                     Centro
                     @if ($ordena != 'centro')
                     <i class="fas fa-sort"></i>
                     @else
                     @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                     @else
                        <i class="fas fa-sort-down"></i>
                     @endif
                     @endif
                  </th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('proyecto')">
                     Proyecto
                     @if ($ordena != 'proyecto')
                     <i class="fas fa-sort"></i>
                     @else
                     @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                     @else
                        <i class="fas fa-sort-down"></i>
                     @endif
                     @endif
                  </th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('recoge')">
                     Recoge
                     @if ($ordena != 'recoge')
                     <i class="fas fa-sort"></i>
                     @else
                     @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                     @else
                        <i class="fas fa-sort-down"></i>
                     @endif
                     @endif
                  </th>
                  <th scope="col" style="cursor: pointer;" wire:click="ordena('entrega')">
                     Entrega
                     @if ($ordena != 'entrega')
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
                     Fecha
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
                  <th scope="col" style="cursor: pointer;" ></th>
            </tr>
         </thead>
         <tbody>
            @foreach ($diligencias as $diligencia)
                  <tr>
                     <td>{{$diligencia->id}}</td>
                     <td>{{$diligencia->uen}}</td>
                     <td>{{$diligencia->centro}}</td>
                     <td>{{$diligencia->proyecto}}</td>
                     <td>{{$diligencia->recoge}}</td>
                     <td>{{$diligencia->entrega}}</td>
                     <td>{{$diligencia->fecha}}</td>
                     <td>{{$diligencia->comentarios}}</td>
                     <td>{{$diligencia->observaciones}}</td>
                     <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" wire:click='buscarfotos({{$diligencia->id}})' data-toggle="modal" data-target="#fotosent">
                           <i class="fas fa-images"></i>
                        </button>
                     </td>
                  </tr>
            @endforeach
         </tbody>
      </table>
      <p>
         Mostrando {{$diligencias->firstItem()}} a {{$diligencias->lastItem()}} de {{$diligencias->total()}} diligencias
      </p>
      <p>
         {{$diligencias->links()}}
      </p>
   @else
      <div class="col-sm-4">
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="far fa-surprise"></i></strong></strong> ¡No se hallaron resultados para esta búsqueda!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
      </div>
   @endif

         <div class="modal fade" id="fotosent" tabindex="-1" aria-labelledby="fotosentLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="fotosentLabel">Registros de Entrega para: {{$diligenciaid}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  @if ($diligenciaid && $control==1)
                     @foreach ($fotosdili as $item)
                        <img src="{{$item->ruta}}" class="img-thumbnail" alt="Somos Envios y Diligencias S.A.S.">
                     @endforeach
                  @else
                     <h4>Este envío no tiene fotos cargadas</h4>
                  @endif
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" wire:click='cerrarmodal' data-dismiss="modal">Cerrar</button>
               </div>
            </div>
            </div>
         </div>
</div>
