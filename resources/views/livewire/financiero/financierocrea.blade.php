<div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
      Crear Producto Financiero
   </button>

   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Producto Financiero</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            </div>
         <form wire:submit.prevent="crear">
            <div class="modal-body">
               <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select class="custom-select" id="tipo" wire:model='tipo' required>
                     <option selected>Clase de producto...</option>
                     <option value="Cuenta Corriente">Cuenta Corriente</option>
                     <option value="Cuenta Ahorro">Cuenta Ahorro</option>
                     <option value="Tarjeta Crédito">Tarjeta de Crédito</option>
                  </select>
                  @error('tipo') <span class="error text-danger text-sm">{{ $message }}</span> @enderror
               </div>
               <hr>
               <div class="form-group">
                  <label for="nombre">Nombre del Producto</label>
                  <input type="text" class="form-control" id="nombre" wire:model='nombre' placeholder="Nombre del producto" >
                  @error('nombre') <span class="error text-danger text-sm">{{ $message }}</span> @enderror
               </div>
               <hr>
               <div class="form-group">
                  <label for="numero">Número del Producto</label>
                  <input type="text" class="form-control" id="numero" wire:model='numero' placeholder="Número del producto" >
                  @error('numero') <span class="error text-danger text-sm">{{ $message }}</span> @enderror
               </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" wire:click='cerrar' data-dismiss="modal">Cerrar</button>
               <button type="submit" class="btn btn-success" >Crear Producto</button>

               <div>
                  @if (session()->has('suceso'))
                        <div class="alert alert-success">
                           {{ session('suceso') }}
                        </div>
                  @endif
               </div>
            </div>
         </form>
         </div>
      </div>
   </div>
</div>
