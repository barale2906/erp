<div>
   <div class="card">
      <div class="card-header">
         <h3 class="card-title center">Nuevo Producto</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
         <div class="row">
            <div class="col-12 col-sm-6">
               <form wire:submit.prevent='submit' method="POST" >
                  @csrf
                     <div>
                        @if (session()->has('message'))
                              <div class="alert alert-success">
                                 {{ session('message') }}
                              </div>
                        @endif
                     </div>
                     <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">Producto</div>
                        </div>
                        <input type="text" class="form-control" wire:model='producto' name="producto" id="producto" required>
                     </div>
                     <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">Descripción</div>
                        </div>
                        <textarea class="form-control" wire:model='descripcion' name="descripcion" id="descripcion"
                           cols="30" rows="4" required></textarea>
                     </div>
                     <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">Tipo</div>
                        </div>
                        <select class="custom-select" wire:model='tipo' name='tipo' id='tipo' required>
                           <option selected>Seleccione tipo de producto</option>
                           <option value="Hora">Hora</option>
                           <option value="Vuelta">Vuelta</option>
                           <option value="Global">Global</option>
                        </select>
                     </div>
                     <button type="submit" class="btn btn-default">Crear</button>
               </form>
            </div>
            <div class="col-12 col-sm-6">
               <table id="total" class="table table-bordered table-striped table-responsive">
                  <thead>
                     <tr>
                        <th scope="col"></th>
                        <th scope="col">Producto</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Tipo</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($productos as $producto)
                        <tr>
                           <td></td>
                           <td>{{$producto->producto}}</td>
                           <td>{{$producto->descripcion}}</td>
                           <td>{{$producto->tipo}}</td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>

      </div>
      <!-- /.card-body -->
   </div>
   <!-- /.card -->
</div>
