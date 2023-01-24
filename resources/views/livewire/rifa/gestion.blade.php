<div>
   <div class="card-deck">
      @if ($idrifa=="")
         <div class="card">
            <div class="card-title"><h5 class="card-title">CREAR RIFA</h5></div>
            <div class="card-body">

               <form wire:submit.prevent='crear' method="POST" >
                     @csrf
                     <div class="form-group row">
                        <label for="fecha" class="col-sm-5 col-form-label">Fecha de Juego</label>
                        <div class="col-sm-7">
                           <input type="date" class="form-control" id="fecha" wire:model='fecha' required>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="premio" class="col-sm-5 col-form-label">Premio</label>
                        <div class="col-sm-7">
                           <textarea class="form-control" id="premio" wire:model='premio' required></textarea>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="boletas" class="col-sm-5 col-form-label">Números en juego</label>
                        <div class="col-sm-7">
                           <select class="custom-select" name="boletas" id="boletas"
                              wire:model="boletas" required>
                              <option selected>Seleccione...</option>
                              <option value="10">10</option>
                              <option value="100">100</option>
                              <option value="1000">1000</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="numeros" class="col-sm-5 col-form-label">Números por Boletas</label>
                        <div class="col-sm-7">
                           <input class="form-control" id="numeros" wire:model='numeros' required>
                           @if ($cantidadboletas)
                              <div class="alert alert-success" role="alert">
                                 Número de boletas a generar: {{number_format($cantidadboletas, 2)}}
                              </div>
                           @endif
                        </div>

                     </div>
                     <div class="form-group row">
                        <label for="responsable" class="col-sm-5 col-form-label">Responsable</label>
                        <div class="col-sm-7">
                           <textarea class="form-control" id="responsable" wire:model='responsable' required></textarea>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="valor" class="col-sm-5 col-form-label">Valor</label>
                        <div class="col-sm-7">
                           <input class="form-control" id="valor" wire:model="valor" required>
                           @if ($totalventa)
                              <div class="alert alert-success" role="alert">
                                 Máximo valor a recaudar: ${{number_format($totalventa, 2)}}
                              </div>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="valor" class="col-sm-5 col-form-label">Método de Juego</label>
                        <div class="col-sm-7">
                           <select wire:model='metodo' class="custom-select">
                                 <option selected>Elija método</option>
                                 <option value="loteria">Loteria</option>
                                 <option value="sorteo">Sorteo en vivo</option>
                           </select>

                        </div>
                     </div>
                     <div class="form-group row">
                        <div class="col-sm-10">
                           <button type="submit" class="btn btn-info">Crear</button>
                        </div>
                     </div>
               </form>
            </div>
               @if (session()->has('mensajecierre'))
                  <div class="alert alert-success">
                     {{ session('mensajecierre') }}
                  </div>
               @endif
            <div class="card-footer">
               <small class="text-muted">Datos Básicos de la Rifa</small>
            </div>
         </div>
         <div class="card">
            <div class="card-title"><h5 class="card-title">HISTORIAL DE RIFAS</h5></div>
            <div class="card-body">
               @foreach ($rifasin as $rifasi)
                  <div class="card" >
                     <div class="card-body">
                        <h5 class="card-title">{{$rifasi->fecha}}</h5>
                        <p class="card-text">{{$rifasi->premio}}</p>
                        @if ($rifasi->estado!=3)
                           <button class="btn btn-success" type="button" wire:click="seleccionar({{$rifasi->id}})">VER RIFA</button>
                        @endif
                     </div>
                  </div>
               @endforeach
            </div>
            <div class="card-footer">
               <small class="text-muted">Rifas sin finalizar</small>
            </div>
         </div>
      @else
         <div class="card">
            <div>
               @if (session()->has('message'))
                  <div class="alert alert-success">
                     {{ session('message') }}
                  </div>
               @else
                  <div class="alert alert-success">
                     Premio: {{$premio}} Juega el día: {{$fecha}}
                  </div>
               @endif
            </div>
            <div class="card-title"><h5 class="card-title">Cargar Fotos del Premio</h5></div>
            <div class="card-body">
               <form wire:submit.prevent='foto' method="POST" >
                  @csrf
                  <div class="form-group row">
                     <label for="numeros" class="col-sm-5 col-form-label">Números por Boletas</label>
                     <div class="col-sm-7">
                        <input class="form-control" type="file" name="foto" id="foto" wire:model="foto" required>
                        @if (session()->has('mensajefoto'))
                           <div class="alert alert-success">
                              {{ session('mensajefoto') }}
                           </div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group row">
                     <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Cargar</button>
                     </div>
                  </div>

               </form>
            </div>
            <div class="card-footer">
               <small class="text-muted">Last updated 3 mins ago</small>
            </div>
         </div>
         <div class="card">
            @if ($rifastado==1)
               <div class="card-body">
                  <h5 class="card-title">Asignar Números a las Boletas</h5>
                  @if ($total<$boletas)
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th scope="col">Boleta</th>
                           <th scope="col">Números{{$numeros}}</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($boletasig as $boletasi)
                              @if ($boletasi->asignados<$numeros)
                                 <tr>
                                    <td>{{$boletasi->idboleta}}</td>
                                    <td>
                                          {{$boletasi->asignados}}
                                          <button type="button" class="btn btn-default" wire:click="organiza({{$boletasi->idboleta}})">
                                             <i class="fas fa-sort-amount-up-alt"></i><span class="badge badge-light">{{$orga}}</span>
                                          </button>
                                    </td>
                                 </tr>
                              @endif
                           @endforeach
                        </tbody>
                     </table>
                  @else
                     <table class="table table-light">
                        <tbody>
                           <tr>
                                 <td><button class="btn btn-success" type="button" wire:click="fin">Finalizar</button></td>
                           </tr>
                        </tbody>
                     </table>
                  @endif
               </div>
            @else
            <div class="card">
               <div class="card-title"><h5 >Registre Ganador</h5></div>
               <div class="card-body">
                  <form wire:submit.prevent='fingana' method="POST" >
                     @csrf


                     <div class="form-group row">
                        <label for="numeros" class="col-sm-5 col-form-label">Número Ganador</label>
                        <div class="col-sm-7">
                           <input class="form-control" id="ganador" wire:model='ganador' required>
                        </div>
                     </div>
                     <div class="form-group row">
                        <div class="col-sm-10">
                           <button type="submit" class="btn btn-info">Asignar</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>

               @if ($mias)
                  <div class="card">
                     <div class="card-title"><h5 >Asignar boletas</h5></div>
                     <div class="card-body">
                           <form wire:submit.prevent='asignaboletas' method="POST" >
                              @csrf

                              <div class="form-group row">
                                 <label for="boletas" class="col-sm-5 col-form-label">Seleccione Usuario</label>
                                 <div class="col-sm-7">
                                    <select class="custom-select" name="usuarioven" id="usuarioven"
                                       wire:model="usuarioven" required>
                                       <option selected>Seleccione...</option>
                                       @foreach ($usuarios as $usuario)
                                          @if ($usuario->id!=Auth::user()->id)
                                             <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                          @endif
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="numeros" class="col-sm-5 col-form-label">Cantidad de Boletas</label>
                                 <div class="col-sm-7">
                                    <select class="custom-select" name="cant" id="cant"
                                       wire:model="cant" required>
                                       <option selected>Seleccione...</option>
                                       @for ($i = 1; $i <= $mias; $i++)
                                          <option value="{{$i}}">{{$i}}</option>
                                       @endfor
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-10">
                                    <button type="submit" class="btn btn-info">Asignar</button>
                                 </div>
                              </div>
                           </form>
                     </div>
                     <div class="card-footer">
                        @if (session()->has('cant'))
                           <div class="alert alert-success">
                              {{ session('cant') }}
                           </div>
                        @endif
                     </div>
                  </div>
               @endif
            @endif
            <div class="card-footer">
               <small class="text-muted">Se generan todas las boletas que van a estar en juego en el sistema</small>
            </div>
         </div>
      @endif
   </div>
</div>

