<div>
   <div wire:loading>
      ¡¡Cargando Información!!
   </div>
   <div>
      @if (session()->has('message'))
         <div class="alert alert-success">
               {{ session('message') }}
         </div>
      @endif
   </div>

   <!-- Main content -->
   <section class="content">
      <div class="card">
            <div class="card-header">
               <h3 class="card-title text-uppercase text-bold text-center">Cargar fechas festivas</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <form class="form-inline" wire:submit.prevent='guardar' method="POST" >
                  @csrf
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Fecha</div>
                     </div>
                     <input type="date" class="form-control" wire:model.lazy='fecha'
                        name="fecha" id="fecha" autofocus>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">Descripción</div>
                     </div>
                     <input class="form-control" wire:model.lazy='descripcion'
                        name="descripcion" id="descripcion" />
                  </div>
                  <button type="submit" class="btn btn-default">Crear</button>
               </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
               <table class="table table-bordered table-striped table-responsive">
                  <thead>
                     <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Descripción</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($festivos as $fest)
                        <tr>
                           <td>{{$fest->fecha}}</td>
                           <td>{{$fest->descripcion}}</td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
               {{$festivos->links()}}
            </div>
      </div>
      <!-- /.card -->
   </section>
   <!-- /.content -->
</div>
