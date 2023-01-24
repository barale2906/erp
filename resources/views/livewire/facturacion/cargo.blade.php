<div class="row align-content-center">
   <div class="col-12 col-sm-3">
      <div class="card text-white bg-info">
         <div class="card-header">
            Crear Cargo
         </div>
         <div class="card-body">
            <form wire:submit.prevent='crear' method="POST" >
               @csrf
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Cargo</div>
                     </div>
                     <input type="text" class="form-control" wire:model='cargo' name="cargo" id="cargo" required>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Descripcion</div>
                     </div>
                     <textarea class="form-control" wire:model='descripcion' name="descripcion" id="descripcion" rows="3" required></textarea>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Tipo</div>
                     </div>
                     <select class="custom-select" wire:model='tipo' name="tipo" id="tipo">
                        <option selected>Seleccione tipo..</option>
                        <option value="1">Impuesto</option>
                        <option value="2">Descuento</option>
                     </select>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Valor</div>
                     </div>
                     <input type="text" class="form-control" wire:model='valor' name="valor" id="valor" required>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Factor</div>
                     </div>
                     <select class="custom-select" wire:model='factor' name="factor" id="factor">
                        <option selected>Seleccione factor..</option>
                        <option value="1">Porcentaje</option>
                        <option value="2">Número</option>
                     </select>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Producto(s)</div>
                     </div>
                     <select class="custom-select" wire:model='producto' name="producto[]" id="producto" multiple required>
                        <option value="0">TODOS</option>
                        @foreach ($productos as $producto)
                           <option value="{{$producto->id}}">{{$producto->producto}}</option>
                        @endforeach
                     </select>
                  </div>

                  <button type="submit" class="btn btn-default">Crear</button>
            </form>
         </div>
      </div>
   </div>
   <div class="col-12 col-sm-9">
      <div class="card bg-light">
         <div class="card-header">
            Cargos Activos
         </div>
         <div class="card-body">
            <div>
               @if (session()->has('message'))
                     <div class="alert alert-success">
                        {{ session('message') }}
                     </div>
               @endif
            </div>
            <table class="table table-bordered table-striped table-responsive">
               <thead>
                  <tr>
                     <th></th>
                     <th scope="col">Cargo</th>
                     <th scope="col">Descripción</th>
                     <th scope="col">Tipo</th>
                     <th scope="col">Valor</th>
                     <th scope="col">Factor</th>
                     <th scope="col">Producto</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($cargos as $cargo)
                     <tr>
                        <td>
                           <button type="button" class="btn btn-secondary btn-xs" wire:click="inactivar({{$cargo->id}})">Inactivar</button>
                        </td>
                        <td>{{$cargo->cargo}}</td>
                        <td>{{$cargo->descripcion}}</td>
                        <td>
                           @switch($cargo->tipo)
                              @case(1)
                                 Impuesto
                                 @break
                              @case(2)
                                 Descuento
                                 @break
                           @endswitch
                        </td>
                        <td>{{$cargo->valor}}</td>
                        <td>
                           @switch($cargo->factor)
                              @case(1)
                                 %
                                 @break
                              @case(2)

                                 @break
                           @endswitch
                        </td>
                        <td>
                           @if ($cargo->producto == 0)
                              TODOS
                           @else
                              {{$cargo->nomprod}}
                           @endif
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
