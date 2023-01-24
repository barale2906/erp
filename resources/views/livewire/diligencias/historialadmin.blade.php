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
                  @if ($imag == $diligencia->id)
                     <tr>
                        <td colspan="10">
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
                        @if ($imag == $diligencia->id)
                           <button type="button" class="btn btn-danger btn-xs" wire:click='cancelar'>
                              <i class="fas fa-times-circle"></i>
                           </button>
                        @else
                           <button type="button" class="btn btn-info btn-xs" wire:click='imagenes({{$diligencia->id}})'>
                              <i class="fas fa-camera-retro"></i>
                           </button>
                        @endif
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
</div>
