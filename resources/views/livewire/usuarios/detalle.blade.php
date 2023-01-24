<div>

   <form class="form-horizontal" action="{{ route('fotousuario')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <h5>Actualizar tu fotografía</h5>
      <div class="form-group row">
         <div class="col-sm-7">
            <input type="file"  name="foto" id="foto">
            <input type="hidden"  name="username" id="username" value="{{ $username }}">
            <input type="hidden"  name="idusuario" id="idusuario" value="{{ $idusuario }}">
         </div>
      </div>
      <div class="form-group row">
         <div class="offset-sm-2 col-sm-7">
            <button type="submit" class="btn btn-info">Actualizar Fotografía</button>
         </div>
      </div>
   </form>
   <hr>
   <div class="alert alert-warning" role="alert">
      <h4 class="alert-heading">Elija Su ubicación dentro de la empresa: {{$ubiactual->nombre}}. <small class="text-danger">Obligatorio</small></h4>
      <hr>
      <form class="form-horizontal" action="{{ route('empresactualiza')}}" method="POST" enctype="multipart/form-data">
         @csrf
         <input type="hidden"  name="empresa_id" id="empresa_id" value="{{ $empresa }}">
         <input type="hidden"  name="user_id" id="user_id" value="{{ $idusuario }}">

         <div class="form-group row">
               <label for="sucursal" class="col-sm-5 col-form-label ">Sucursal</label>
               <div class="col-sm-7">
                  <select name="sucursal_id" id="sucursal_id" required>
                     @if ($ubiactual->sucursal!=NULL)
                        <option value="{{$ubiactual->sucursal_id}}-{{$ubiactual->sucursal}}">{{$ubiactual->sucursal}}</option>
                     @else
                        <option value="">Seleccione nueva sucursal...</option>
                     @endif
                     @foreach ($sucursales as $sucursal)
                        @if ($sucursal->id!=$ubiactual->sucursal_id)
                           <option value="{{$sucursal->id}}-{{$sucursal->nombre}}">{{$sucursal->nombre}}</option>
                        @endif
                     @endforeach
                  </select>
               </div>
         </div>

         <div class="form-group row">
               <label for="area" class="col-sm-5 col-form-label">Área</label>
               <div class="col-sm-7">
                  <select name="area_id" id="area_id" required>
                     @if ($ubiactual->area!=NULL)
                        <option value="{{$ubiactual->area_id}}-{{$ubiactual->area}}">{{$ubiactual->area}}</option>
                     @else
                        <option value="">Seleccione nueva área...</option>
                     @endif
                     @foreach ($areas as $area)
                        @if ($area->id!=$ubiactual->area_id)
                           <option value="{{$area->id}}-{{$area->area}}">{{$area->area}}</option>
                        @endif
                     @endforeach
                  </select>
               </div>
         </div>
         <div class="form-group row">
            <div class="offset-sm-5 col-sm-7">
               <button type="submit" class="btn btn-warning text-uppercase">Actualizar Ubicación</button>
            </div>
         </div>
      </form>
   </div>
   <hr>
   <form wire:submit.prevent='submit' method="POST" >
      @csrf
      <hr>
      <h5>Tus Datos  <small class="text-danger">Si eres funcionario de Somos Envíos y Diligencias S.A.S., es NECESARIO que registres estos datos</small></h5>
      <hr>
      <div class="form-group row">
         <label for="direccion" class="col-sm-5 col-form-label">Dirección</label>
         <div class="col-sm-7">
            <textarea name="direccion" id="direccion" wire:model='direccion' placeholder="{{$direccionact}}" required></textarea>
         </div>
      </div>
      <div class="form-group row">
         <label for="telefono" class="col-sm-5 col-form-label">Teléfono</label>
         <div class="col-sm-7">
            <input type="text" name="telefono" id="telefono" wire:model='telefono' placeholder="{{$telefonoact}}" required>
         </div>
      </div>
      <div class="form-group row">
         <div class="offset-sm-5 col-sm-7">
            <button type="submit" class="btn btn-info">Guardar</button>
         </div>
      </div>
      <div>
         @if (session()->has('mensdirec'))
               <div class="alert alert-success">
                  {{ session('mensdirec') }}
               </div>
         @endif
      </div>
   </form>
   <hr>
   <form >
      <div class="form-group row">
            <label for="sanguineo" class="col-sm-5 col-form-label">Grupo Sanguíneo</label>
            <div class="col-sm-7">
               <input type="text" name="sanguineo" id="sanguineo" placeholder="{{ $sanguineoact }}"
                     wire:model="sanguineo" wire:blur="modsanguineo">
            </div>
            <div>
               @if (session()->has('sanguimen'))
                     <div class="alert alert-success">
                        {{ session('sanguimen') }}
                     </div>
               @endif
            </div>
      </div>
      <div class="form-group row">
         <label for="nacimiento" class="col-sm-5 col-form-label">Fecha de Nacimiento </label>
         <div class="col-sm-7">

            <input type="date" name="nacimiento" id="nacimiento"
            wire:model="nacimiento" wire:blur="modcumple"> <strong>Valor registrado: {{ $nacimientoact }}</strong>
         </div>
         <div>
            @if (session()->has('nacimimen'))
                  <div class="alert alert-success">
                     {{ session('nacimimen') }}
                  </div>
            @endif
         </div>
      </div>
   </form>

</div>
