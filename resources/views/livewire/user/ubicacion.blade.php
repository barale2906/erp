<div>
   <h5> <i class="far fa-surprise"></i> Para ingresar a todos los modulos cuentanos donde estas.</h5>
   <div class="mb-3">
      <label for="sucursal" class="form-label">Seleccione sucursal</label>
         <select class="custom-select" id="sucursal" wire:model='sucursal'>
            <option selected>Sucursal...</option>
            @foreach ($sucursales as $item)
               <option value="{{$item->id}}">{{$item->nombre}}</option>
            @endforeach
         </select>
   </div>
   <div class="mb-3">
      <label for="area" class="form-label">Seleccione area</label>
         <select class="custom-select" id="area" wire:model='area'>
            <option selected>Area...</option>
            @foreach ($areas as $item)
               <option value="{{$item->id}}">{{$item->area}}</option>
            @endforeach
         </select>
   </div>
   @if ($area && $sucursal)
      <button type="button" class="btn btn-default" wire:click='ubicacion'>Cargar <i class="fas fa-arrow-circle-right"></i></button>
   @endif
</div>
