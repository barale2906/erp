<div class="card p-2 mt-3">
   <h5>Cambiar Contraseña</h5>
   <div class="form-group">
      <label for="contrasena">Digite Contraseña</label>
      <input type="password" class="form-control" id="contrasena" wire:model="contrasena">
   </div>
   <div class="form-group">
      <label for="contra">Repita Contraseña</label>
      <input type="password" class="form-control" id="contra" wire:model='contra'>

   </div>
   @if (!empty($contrasena) && !empty($contra))
      @if ($contrasena === $contra)
         <button type="button" class="btn btn-info" wire:click='cambiar'>Actualizar Contraseña</button>
      @else
         <span class="text-danger text-sm">Las contraseñas no son iguales</span>
      @endif
   @endif
   <div>
      @if (session()->has('contrasena'))
            <div class="alert alert-success">
               {{ session('contrasena') }}
            </div>
      @endif
   </div>
</div>
