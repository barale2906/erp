<div>
   @if ($idplanilla > 0)
      <!-- Main content -->
   <section class="content">
      <div class="card">
         <div class="card-header">
            <div>
               @if (session()->has('message'))
                  <div class="alert alert-success">
                        {{ session('message') }}
                  </div>
               @endif
            </div>
            <div>
               @if (session()->has('cierre'))
                  <div class="alert alert-warning">
                        {{ session('cierre') }}
                  </div>
               @endif
            </div>
            <h3 class="card-title text-uppercase text-bold text-center text-capitalize">Detalle planilla {{$idplanilla}}</h3>

            <table class="table table-bordered table-striped table-responsive">
               <thead>
                  <tr>
                     <th scope="col">ID</th>
                     <th scope="col">Empresa</th>
                     <th scope="col">Fecha</th>
                     <th scope="col">Operador</th>
                     <th scope="col">Ruta</th>
                     <th scope="col">Observaciones</th>
                     <th scope="col">Diligencias</th>
                     <th scope="col">Dinero Cliente</th>
                     <th scope="col">Cobro Interno</th>
                     <th scope="col">Estado</th>

                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>{{$planilla->id}}</td>
                     <td>{{$planilla->nombre}}</td>
                     <td>{{$planilla->fecha}}</td>
                     <td>
                        @if ($planilla->estado<=2)
                           <select class="custom-select" name="operador" id="operador"
                              wire:model="operador" wire:change="cambiaopera" required>
                              <option selected>{{$planilla->name}}</option>
                              @foreach ($operadores as $operador)
                                 @if ($operador->id != $planilla->iduser)
                                    <option value="{{$operador->id}}">{{$operador->name}}</option>
                                 @endif
                              @endforeach
                           </select>
                        @else
                           {{$planilla->name}}
                        @endif

                     </td>
                     <td>{{$planilla->ruta}}</td>
                     <td>{{$planilla->observaciones}}</td>
                     <td>{{$envios->count()}}</td>
                     <td>{{$envios->sum('cobrocliente')}}</td>
                     <td>{{$envios->sum('cobro')}}</td>
                     <td>
                        @switch($planilla->estado)
                           @case(1)
                              CONSTRUCCIÓN
                              @break
                           @case(2)
                              RECORRIDO
                              @break
                           @case(3)
                              CERRADA
                              @break
                        @endswitch
                     </td>

                  </tr>
               </tbody>
            </table>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <div class="row justify-content-center">
                     <table class="table table-bordered table-striped table-responsive">
                        <thead>
                           <tr>
                              <th scope="col"></th>
                              <th scope="col">ID</th>
                              @if (Auth::user()->empresa==2)
                                 <th scope="col">Factura</th>
                                 <th scope="col">Cobro cliente</th>
                                 <th scope="col">Cobro mensajería</th>
                              @endif
                              <th scope="col">Destinatario</th>
                              <th scope="col">Dirección</th>
                              <th scope="col">Ciudad</th>
                              <th scope="col">Observaciones</th>
                              <th scope="col">Estado</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($envios as $envio)
                              <tr>
                                 <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                       @if ($envio->control<3)
                                          @if (Auth::user()->empresa==2)
                                             <button type="button" wire:click="cerrar({{$envio->id}})" class="btn btn-warning"><i class="fas fa-door-closed"></i></button>
                                          @else
                                             <button type="button" wire:click="recibir({{$envio->id}})" class="btn btn-warning"><i class="fas fa-door-closed"></i></button>
                                          @endif
                                          <button type="button" wire:click="devolver({{$envio->id}})" class="btn btn-danger"><i class="fas fa-frown"></i></button>
                                          @if ($planillabier && $envios->count()>1)
                                             <select class="custom-select" name="nueplani" id="nueplani"
                                                wire:model="nueplani" wire:change="cambiaplani({{$envio->id}})" required>
                                                <option selected>{{$idplanilla}}</option>
                                                @foreach ($planillabier as $plabi)
                                                   @if ($plabi->id != $idplanilla)
                                                      <option value="{{$plabi->id}}">{{$plabi->id}}</option>
                                                   @endif
                                                @endforeach
                                             </select>
                                          @endif

                                       @endif
                                       <button type="button" wire:click="imagen({{$envio->id}})" class="btn btn-success" data-toggle="modal" data-target="#imagenes">
                                          <i class="fas fa-images"></i>
                                       </button>
                                    </div>
                                 </td>
                                 <td>{{$envio->id}}</td>
                                 @if (Auth::user()->empresa==2)
                                    <td>{{$envio->descripcion}}</td>
                                    <td>{{$envio->cobrocliente}}</td>
                                    <td>{{$envio->cobro}}</td>
                                 @endif
                                 <td>{{$envio->nombredestinatario}}</td>
                                 <td>{{$envio->nombresede}}</td>
                                 <td>{{$envio->nombreubicacion}}</td>
                                 <td>{{$envio->observaciones}}</td>

                                 <td>
                                    @switch($envio->control)
                                       @case(1)
                                          CONSTRUCCIÓN
                                          @break
                                       @case(2)
                                          RECORRIDO
                                          @break
                                       @case(3)
                                          No Entregada en esta planilla
                                          @break
                                       @case(4)
                                          CERRADA
                                          @break

                                    @endswitch
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
            </div>
            <hr>
         </div>
         <!-- /.card-body -->
         <div class="card-footer">
         </div>
      </div>
      <!-- /.card -->
   </section>
   <!-- /.content -->
   @endif

   <!-- Modal -->
   <div class="modal fade" id="imagenes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Imágenes cargadas para el envío {{$idenvio}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @if ($imagenes->count()>0)
                     @foreach ($imagenes as $imagen)
                        <img src="../{{$imagen->ruta}}" width="300" height="300">
                     @endforeach
               @else
                     <p>Este envío no tiene imágenes cargadas</p>
               @endif
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </div>
      </div>
   </div>
</div>


