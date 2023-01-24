<div>
   <div class="card">
      <div class="card-header">
         <h3 class="card-title center">Nuevo Esquema</h3>
         <div>
            @if (session()->has('message'))
                  <div class="alert alert-success">
                     {{ session('message') }}
                  </div>
            @endif
         </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
         <div class="row justify-content-center">
            <div class="col-12">
               <form wire:submit.prevent='submit' method="POST" class="form-inline" >
                  @csrf
                     <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">Esquema</div>
                        </div>
                        <input type="text" class="form-control" wire:model='esquema' name="esquema" id="esquema" required>
                     </div>
                     <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">Inicia</div>
                        </div>
                        <input type="date" class="form-control" wire:model='inicio' name="inicio" id="inicio" required>
                     </div>
                     <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">Termina</div>
                        </div>
                        <input type="date" class="form-control" wire:model='fin' name="fin" id="fin" required>
                     </div>
                     <button type="submit" class="btn btn-default">Crear</button>
               </form>
            </div>
         </div>
         <hr>
         <div class="row justify-content-center">
            @if (empty($idesquema))

               <div class="col-12 col-sm-6">
                  <table id="total" class="table table-bordered table-striped table-responsive">
                     <thead>
                        <tr>
                           <th colspan="4">
                              Esquemas activos o en proceso.
                           </th>
                        </tr>
                        <tr>
                           <th scope="col"></th>
                           <th scope="col">Esquema</th>
                           <th scope="col">Inicia</th>
                           <th scope="col">Finaliza</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($esquemas as $esquema)
                           <tr>
                              <td>
                                 <button type="button" class="btn" wire:click="ver({{$esquema->id}})"><i class="fas fa-highlighter"></i></button>
                              </td>
                              <td>{{$esquema->esquema}}</td>
                              <td>{{$esquema->inicio}}</td>
                              <td>{{$esquema->fin}}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            @else
               <div class="alert alert-info" role="alert">
                  <h4 align="center">Nombre esquema: <strong>{{$esquemaseleccionado->esquema}}</strong> Inicia: <strong>{{$esquemaseleccionado->inicio}}</strong>
                     Finaliza: <strong>{{$esquemaseleccionado->fin}}</strong>
                     Estado: <strong>
                        @switch($esquemaseleccionado->estado)
                           @case(1)
                              Elaboración.
                              @break
                           @case(2)
                              Activo.
                              @break
                           @case(3)
                              Inactivo.
                              @break
                        @endswitch
                     </strong>
                     <button type="button" class="btn btn-info btn-xs" wire:click="liberar()">
                        <i class="fas fa-backspace"></i>
                     </button>
                     @if ($pagosignados->count())
                        <button type="button" class="btn btn-success " wire:click="finalizar()">
                           <i class="fas fa-check"></i>
                        </button>
                     @endif
                  </h4>
               </div>
               <hr>
               <div class="col-12 col-sm-6">
                  <table id="total" class="table table-bordered table-striped table-responsive">
                     <thead>
                        <tr>
                           <th colspan="5" align="center">
                              TIPOS DE PAGO
                           </th>
                        </tr>
                        <tr>
                           <th scope="col">Nombre</th>
                           <th scope="col">Descripción</th>
                           <th scope="col">Tipo</th>
                           <th scope="col">Valor</th>
                           <th scope="col"></th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($pagos as $pago)
                           <tr>
                              <td>{{$pago->cargo}}</td>
                              <td>{{$pago->descripcion}}</td>
                              <td>{{$pago->tipo}}</td>
                              <td>
                                 <input wire:model="valor" size="6"/>
                              </td>
                              <td>
                                 <button type="button" class="btn btn-info btn-xs" wire:click="incluye({{$pago->id}})">
                                    <i class="fas fa-check"></i>
                                 </button>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="col-12 col-sm-6">
                  <div>
                     @if (session()->has('messadet'))
                           <div class="alert alert-success">
                              {{ session('messadet') }}
                           </div>
                     @endif
                  </div>
                  <div>
                     @if (session()->has('messavalor'))
                           <div class="alert alert-info">
                              {{ session('messavalor') }}
                           </div>
                     @endif
                  </div>
                  <div>
                     @if (session()->has('messaelim'))
                           <div class="alert alert-danger">
                              {{ session('messaelim') }}
                           </div>
                     @endif
                  </div>
                     <table id="total" class="table table-bordered table-striped table-responsive">
                        <thead>
                           <tr>
                              <th colspan="5" align="center">
                                 PAGOS ASIGNADOS A ESTE ESQUEMA
                              </th>
                           </tr>
                           <tr>
                              <th scope="col">Nombre</th>
                              <th scope="col">Descripción</th>
                              <th scope="col">Tipo</th>
                              <th scope="col">Valor</th>
                              <th scope="col"></th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($pagosignados as $pagosignado)
                              <tr>
                                 <td>{{$pagosignado->cargo}}</td>
                                 <td>{{$pagosignado->descripcion}}</td>
                                 <td>{{$pagosignado->tipo}}</td>
                                 <td>
                                    <input wire:blur="modval({{$pagosignado->id}})"
                                       wire:model="val" placeholder="$ {{number_format($pagosignado->valor, 0, ',', '.') }}" size="6"/>
                                 </td>
                                 <td>
                                    <button type="button" class="btn btn-danger btn-xs" wire:click="eliminar({{$pagosignado->id}})">
                                       <i class="far fa-trash-alt"></i>
                                    </button>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
               </div>
            @endif
         </div>

      </div>
      <!-- /.card-body -->
   </div>
   <!-- /.card -->
</div>
