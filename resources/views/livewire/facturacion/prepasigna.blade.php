<div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
      Asignar Guías
   </button>

   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Asigna Las Guías Prepagadas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label for="exampleInputEmail1">Seleccione Cliente</label>
               <select class="custom-select" id="clienteid" wire:model='clienteid'>
                  <option selected>Cliente...</option>
                     @foreach ($clientes as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                     @endforeach
               </select>
            </div>
            @if ($clienteid)
               <div class="form-group">
                  <label for="facturaid">Factura N°</label>
                  <input type="text" class="form-control" id="facturaid" wire:model='facturaid'>
               </div>
            @endif
            @if ($facturaid)
               <div class="form-group">
                  <label for="cantidad">Cantidad</label>
                  <input type="text" class="form-control" id="cantidad" wire:model='cantidad'>
               </div>
            @endif


         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click='cerrar' data-dismiss="modal">Cerrar</button>
            @if ($cantidad)
               <button type="button" class="btn btn-info" wire:click='asignar'>Asignar Guías</button>
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
