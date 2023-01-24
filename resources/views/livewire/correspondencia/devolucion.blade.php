<div>
   <div class="card">
      <div class="card-header">
         <h3 class="card-title center">Nuevo Motivo</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
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
                           <div class="input-group-text">Motivo</div>
                        </div>
                        <input type="text" class="form-control" wire:model='motivo' name="motivo" id="motivo" required>
                  </div>

                  <button type="submit" class="btn btn-default">Crear</button>

         </form>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
         <table>
            <thead>
               <tr>
                  <th>Motivo</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($motivos as $motivo)
                  <tr>
                     <td>{{$motivo->motivo}}</td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
   <!-- /.card -->
</div>
