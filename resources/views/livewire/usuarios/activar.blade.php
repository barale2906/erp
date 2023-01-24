<div>
   <li class="list-group-item">
      <form wire:submit.prevent='submit' method="POST" >
         <div class="form-group row">
            <label for="conductor" class="col-sm-5 col-form-label">Estado</label>
            <div class="col-sm-7">
               <select name="estadocam" id="estadocam" wire:model="estadocam" class="custom-select" required>
                  @switch($estado)
                     @case(1)
                        <option value="{{$estado}}">Registrado</option>
                        @break
                     @case(2)
                        <option value="{{$estado}}">Activo</option>
                        @break
                     @case(3)
                        <option value="{{$estado}}">Inactivo</option>
                        @break
                  @endswitch
                  @if ($estado==3)
                     <option value="1">Registrado</option>
                  @else
                     <option value="3">Inactivo</option>
                  @endif
               </select>
            </div>

         </div>
         <div class="form-group row">
            <div class="offset-sm-5 col-sm-7">
               <button type="submit" class="btn btn-info">Cambiar Estado</button>
            </div>
         </div>
      </form>
      <div>
         @if (session()->has('menestado'))
               <div class="alert alert-success">
                  {{ session('menestado') }}
               </div>
         @endif
      </div>
   </li>
</div>
