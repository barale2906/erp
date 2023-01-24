<div class="col-12">
   <!-- /.row -->
   <!-- Main content -->
   <section class="content">
      <div class="card">
            <div class="card-header">
               <h3 class="card-title text-uppercase text-bold">Seleccione Operador:</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <div wire:loading>
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     <strong>¡¡Procesando la información!!</strong> Por favor espera, esta operación puede tardar unos minutos.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
               </div>
               <div class="row justify-content-center">
                  @if (empty($operador))
                     <form class="form-inline">
                        <div class="input-group mb-2 mr-sm-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">Operador</div>
                           </div>
                           <select wire:model="operador" class="custom-select">
                              <option selected>Seleccione operador</option>
                              @foreach ($operadores as $operador)
                                 <option value="{{$operador->id}}">{{$operador->name}}</option>
                              @endforeach
                           </select>
                        </div>
                        @if ($cuentapro==1)
                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">Cuentas en Proceso</div>
                              </div>
                              <select wire:model="proceso" class="custom-select" wire:change="seleccionacuenta">
                                 <option selected>Seleccione cuenta</option>
                                 @foreach ($cuentaproceso as $cuentaproce)
                                    <option value="{{$cuentaproce->id}}">{{$cuentaproce->name}} - {{$cuentaproce->fecha}}</option>
                                 @endforeach
                              </select>
                           </div>
                        @endif
                     </form>
                  @else
                     {{$opeseleccionado->name}}
                     <button type="button" class="btn btn-danger btn-xs" wire:click="cambiaoperador">
                        <i class="fas fa-backspace"></i>
                     </button>
                  @endif
               </div>
               <div class="row justify-content-center">
                  @if (session()->has('periodo'))
                        <div class="alert alert-success">
                           {{ session('periodo') }}
                        </div>
                  @endif
               </div>
               @if (!empty($numerocuenta))
                  <div class="row justify-content-center">
                     CUENTA DE COBRO {{$numerocuenta}}
                  </div>
               @endif

               @if (!empty($idcuenta))
                  <div class="row justify-content-center">
                     @switch($puerta)
                        @case(1)
                           <table class="table table-bordered table-striped table-responsive">
                              <thead>
                                 <tr>
                                    <th scope="col" colspan="5">DATOS BÁSICOS DE LA CUENTA ACTUAL</th>
                                 </tr>
                                 <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Operador</th>
                                    <th scope="col">Fecha de Cuenta</th>
                                    <th scope="col">Total</th>
                                    <th scope="col" >Observaciones</th>

                                 </tr>
                              </thead>
                              <tbody>
                                    <tr>
                                       <td>
                                          @if ($cuentabase->estado == 1)
                                             <button type="button" class="btn btn-danger btn-xs" wire:click="abrir('2')">
                                                <i class="far fa-trash-alt"></i>
                                             </button>
                                             @if ($cuentadetalles->count()>0)
                                                <button type="button" class="btn btn-success btn-xs" wire:click="abrir('3')">
                                                   <i class="fas fa-receipt"></i>
                                                </button>
                                             @endif
                                          @endif
                                       </td>
                                       <td>{{$cuentabase->name}}</td>
                                       <td>{{$cuentabase->fecha}}</td>
                                       <td>$ {{ number_format($cuentabase->valor, 0, ',', '.')}}</td>
                                       <td><small>{{$cuentabase->observaciones}}</small>
                                          @if ($cuentabase->estado == 1)
                                             <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#observaciones">
                                                <i class="fas fa-exchange-alt"></i>
                                             </button>
                                          @endif
                                       </td>
                                    </tr>
                              </tbody>
                           </table>
                           <!-- Modal Observaciones-->
                           <div class="modal fade" id="observaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
                              <div class="modal-dialog">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                       AGREGAR OBSERVACIONES A LA CUENTA DE COBRO
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <textarea wire:model='observaciones' id="observaciones" name="observaciones"></textarea>

                                    <div>
                                       @if (session()->has('observacionescambia'))
                                             <div class="alert alert-success">
                                                {{ session('observacionescambia') }}
                                             </div>
                                       @endif
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-warning" wire:click="insertaobervaciones">Registrar Observaciones</button>
                                 </div>
                              </div>
                              </div>
                           </div>
                           @break
                        @case(2)
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>¡Esta seguro(a) de eliminar esta cuenta!. Esta operación es IRREVERSIBLE</strong>
                                 <button type="button" class="btn btn-default" wire:click="eliminarcuenta">
                                    ELIMINAR
                                 </button>
                              <button type="button" class="close"  aria-label="Close" wire:click="cerrar">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           @break
                        @case(3)
                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>De clic en generar cuenta para finalizar</strong>
                              @if (!empty($banco) && !empty($cuentapago) && !empty($tipocuentapago))
                                 <button type="button" class="btn btn-warning btn-group-sm" wire:click="finalizacuenta">
                                    GENERAR CUENTA
                                 </button>
                              @else
                                 <h4>No tiene datos de pago</h4>
                                 <div class="form-group">
                                    <label for="bancoc">Banco</label>
                                    <input type="text" class="form-control" id="bancoc" wire:model='bancoc' placeholder="Banco del operador" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="tipocuentapagoc">Tipo Cuenta</label>
                                    <input type="text" class="form-control" id="tipocuentapagoc" wire:model='tipocuentapagoc' placeholder="daviplata, ahorros, etc" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="cuentapago">Cuenta</label>
                                    <input type="text" class="form-control" id="cuentapagoc" wire:model='cuentapagoc' placeholder="Número cuenta" required>
                                 </div>                                 
                                 <button type="button" class="btn btn-warning btn-group-sm" wire:click="creadatospago">
                                    Crear Datos de Pago
                                 </button>
                              @endif                                 
                              <button type="button" class="close"  aria-label="Close" wire:click="cerrar">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           @break

                     @endswitch
                  </div>
               @endif

               <hr>
                  <div class="row justify-content-center">
                     <div class="col-12 col-sm-6">

                        @switch($serviciocrt)
                           @case(1)
                              <p>!No hay resultados para esta búsqueda!</p>
                              @break
                           @case(2)
                              @if ($seleccionados->count()>0)
                                 <table class="table table-bordered table-striped table-responsive">
                                    <thead>
                                       <tr>
                                          <th scope="col" colspan="5">Registros Encontrados: {{$seleccionados->count()}}</th>
                                       </tr>
                                       <tr>
                                          <th scope="col">id / fecha / Comentarios</th>
                                          <th scope="col">Observaciones</th>
                                          <th scope="col">Guías</th>
                                          <th scope="col" colspan="2">Costo</th>

                                       </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($seleccionados as $seleccionado)
                                          <tr>
                                             <td><small>{{$seleccionado->numerodili}} - {{$seleccionado->fecha}} - {{$seleccionado->comentarios}}</small></td>
                                             <td><small>{{$seleccionado->observaciones}}</small></td>
                                             <td><small>{{$seleccionado->guias}}</small></td>
                                             <td>
                                                @if (empty($idcuenta))
                                                   <small>
                                                      <select wire:model='cobros' wire:change="seleccionacobro({{$seleccionado->id}})">
                                                         <option value="">...</option>
                                                         @foreach ($costos as $costo)
                                                            <option value="{{$costo->pago_id}}-{{$costo->valor}}">{{ $costo->cargo}} - {{$costo->valor}}</option>
                                                         @endforeach
                                                      </select>
                                                   </small>
                                                @else
                                                   @if ($cuentabase->estado == 1)
                                                      <small>
                                                         <select wire:model='cobros' wire:change="seleccionacobro({{$seleccionado->id}})">
                                                            <option value="">...</option>
                                                            @foreach ($costos as $costo)
                                                               <option value="{{$costo->pago_id}}-{{$costo->valor}}">{{ $costo->cargo}} - {{$costo->valor}}</option>
                                                            @endforeach
                                                         </select>
                                                      </small>
                                                   @endif
                                                @endif
                                             </td>
                                             <td><small></small></td>
                                          </tr>
                                       @endforeach
                                    </tbody>
                                 </table>

                              @else
                                 <h4>¡No hay resultados para esta consulta!</h4>
                              @endif
                              <hr>
                              <table class="table table-bordered table-striped table-responsive">
                                 <thead>
                                    <tr>
                                       <th scope="col" colspan="5">COSTOS ADICIONALES SIN FACTURAR</th>
                                    </tr>
                                    <tr>
                                       <th scope="col">Costo</th>
                                       <th scope="col">Unitario</th>
                                       <th scope="col">Cantidad</th>
                                       <th scope="col">Valor</th>
                                       <th scope="col"></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($costos as $costo)
                                       <tr>
                                          <td>{{$costo->cargo}}</td>
                                          <td>{{$costo->valor}}</td>
                                          <td>
                                             <input wire:model="cantidad" size="1"/>
                                          </td>
                                          <td>
                                             @php
                                                if(!empty($cantidad)){
                                                   $totalitem = $cantidad*$costo->valor;
                                                   echo number_format($totalitem,0, ',', '.');
                                                };
                                             @endphp
                                          </td>
                                          <td>
                                             <button type="button" class="btn btn-info btn-xs" wire:click="adicionales({{$costo->id}})">
                                                <i class="fas fa-check"></i>
                                             </button>
                                          </td>
                                       </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                              @break
                        @endswitch
                     </div>
                     <div class="col-12 col-sm-6">
                        @if (!empty($idcuenta))
                           <table class="table table-bordered table-striped table-responsive">
                              <thead>
                                 <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Valor Unitario</th>
                                    <th scope="col">Valor Total</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($cuentadetalles as $cuentadetalle)
                                    <tr>
                                       <td>
                                          @if ($cuentabase->estado == 1 && $cuentadetalles->count()>1)
                                             <button type="button" class="btn btn-danger btn-xs" wire:click="eliminaitem({{$cuentadetalle->id}})">
                                                <i class="far fa-trash-alt"></i>
                                             </button>
                                          @endif
                                       </td>
                                       <td>{{$cuentadetalle->cargo}}</td>
                                       <td>{{$cuentadetalle->tipo}}</td>
                                       <td>{{$cuentadetalle->cantidad}}</td>
                                       <td>$ {{ number_format($cuentadetalle->vr_unitario, 0, ',', '.')}}</td>
                                       <td>$ {{number_format($cuentadetalle->vr_total, 0, ',', '.')}}</td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        @endif
                     </div>
                  </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
      </div>
      <!-- /.card -->
   </section>
   <!-- /.content -->
</div>

