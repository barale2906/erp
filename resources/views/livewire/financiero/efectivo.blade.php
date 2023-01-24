<div>
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
   @switch($movimiento)
      @case(1)
         <div class="alert alert-info" role="alert">
         @break
      @case(2)
         <div class="alert alert-warning" role="alert">
         @break
      @default
         <div class="alert alert-default" role="alert">
   @endswitch


      <form class="form-inline" wire:submit.prevent="cargar">
         <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
               <div class="input-group-text">Mov:</div>
            </div>
            <select class="custom-select" id="movimiento" wire:model='movimiento'>
               <option selected>Seleccione ...</option>
               <option value="1">Recibe dinero</option>
               <option value="2">Entrega dinero</option>
            </select>
         </div>
         @if (!empty($movimiento))
            <div class="input-group mb-2 mr-sm-2">
               <div class="input-group-prepend">
                  <div class="input-group-text">Descripción</div>
               </div>
               <textarea class="form-control" id="descripcion" wire:model='descripcion' rows="1"></textarea>
               @error('descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="input-group mb-2 mr-sm-2">
               <div class="input-group-prepend">
                  <div class="input-group-text">Valor</div>
               </div>
               <input type="number" class="form-control" id="valor" wire:model='valor' placeholder="cantidad recibida">
               @error('valor') <span class="error text-danger">{{ $message }}</span> @enderror
               <span class="text-default"><strong>Sin puntos, ni comas</strong></span>
            </div>
            @if ($movimiento==1)
               <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                     <div class="input-group-text">De:</div>
                  </div>
                  <select class="custom-select" id="usude" wire:model='usude'>
                     <option selected>Seleccione usuario...</option>
                     @foreach ($poseen as $pos)
                        @if (Auth::user()->id != $pos->user_id)
                           <option value="{{$pos->user_id}}-{{$pos->usuario}}">{{$pos->usuario}}-$ {{ number_format($pos->saldo, 0, ',', '.')}}</option>
                        @endif
                     @endforeach
                  </select>
               </div>
            @endif
            @if ($movimiento==2)
               <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                     <div class="input-group-text">foto:</div>
                  </div>
                  <input type="file" class="form-control" id="foto" wire:model='foto' required>
                  @error('foto') <span class="error text-danger">{{ $message }}</span> @enderror
               </div>
            @endif
            <button type="submit" class="btn btn-default mb-2">Registrar</button>
         @endif

      </form>
   </div>
   @if ($movimientos->count())
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

         <p>Se encontrarón: {{$movimientos->total()}} registros </p>

      </div>
      <table class="table table-bordered table-striped table-responsive">
         <thead>
            <tr>
               <th colspan="3"><strong>TOTAL</strong></th>
               <th><strong>$ {{ number_format($total, 0, ',', '.')}}</strong></th>
            </tr>
            <tr>
               <th scope="col">Fecha</th>
               <th scope="col">Movimiento</th>
               <th scope="col">Descripción</th>
               <th scope="col">Valor</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($movimientos as $item)
               <tr>
                  <td>
                     {{$item->created_at}}
                  </td>
                  <td>
                     <small>{{$item->movimiento}}</small>
                  </td>
                  <td>
                     <small>{{$item->descripcion}}</small>
                  </td>
                  <td class="text-right">
                     $ {{ number_format($item->valor, 0, ',', '.')}}
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
      <p>
         Mostrando {{$movimientos->firstItem()}} a {{$movimientos->lastItem()}} de {{$movimientos->total()}} solicitudes
      </p>
      <p>
         {{$movimientos->links()}}
      </p>
   @else
      <h4>No tienes movimientos en efectivo</h4>
   @endif
</div>
