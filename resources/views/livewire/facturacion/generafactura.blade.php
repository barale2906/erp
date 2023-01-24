<div>
   <div class="card">
      <div class="card-header text-lg">
         ¡¡DATOS BÁSICOS DE LA FACTURA!!
         <div>
            @if (session()->has('messagelim'))
                  <div class="alert alert-success">
                     {{ session('messagelim') }}
                  </div>
            @endif
         </div>
      </div>
      <div class="card-body">
         @if ($final != 1)
            <div class="row justify-content-center">
               <div class="col-12 col-sm-3">
                  <div class="info-box">
                     <span class="info-box-icon bg-info elevation-1"><i class="fas fa-industry"></i></span>
                     <div class="info-box-content">
                        @if (!empty($nit))
                           <h5>{{$clieselec->nombre}}</h5>
                        @else
                           <span class="info-box-text text-capitalize">Cliente a Facturar</span>
                           <span class="info-box-number">
                              <select class="custom-select" name="nit" id="nit"
                                 wire:model="nit" >
                                 <option selected>Seleccione cliente</option>
                                 @foreach ($clientes as $cliente)
                                    @if ($cliente->id!=3)
                                       <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                                    @endif
                                 @endforeach
                              </select>
                           </span>
                        @endif

                     </div>
                     <!-- /.info-box-content -->
                  </div>
               </div>
               @if (empty($nit))
                  <div class="col-12 col-sm-3">
                     <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-microchip"></i></span>
                        <div class="info-box-content">
                              <span class="info-box-text text-capitalize">Facturas en Proceso</span>
                              <span class="info-box-number">
                                 @if ($factuproces->count())
                                    <select class="custom-select" name="nite" id="nite"
                                       wire:model="nite" wire:change="seleccionafactura">
                                       <option selected>Seleccione Factura</option>
                                       @foreach ($factuproces as $factuproce)
                                          <option value="{{$factuproce->id}}">{{$factuproce->empresa}} - {{$factuproce->nombre}}</option>
                                       @endforeach
                                    </select>
                                 @else
                                    <p>No hay Facturas en Proceso</p>
                                 @endif

                              </span>
                        </div>
                        <!-- /.info-box-content -->
                     </div>
                  </div>
               @endif
               @if (!empty($nit))
                  <div class="col-12 col-sm-3">
                     <div class="info-box">
                        <span class="info-box-icon bg-green elevation-1"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                              <span class="info-box-text text-capitalize">Sucursal</span>
                                 <span class="info-box-number">
                                    <select class="custom-select" name="sucursal" id="sucursal"
                                       wire:model="sucursal" >
                                       <option selected>Seleccione sucursal</option>
                                       @foreach ($sucursales as $sucursale)
                                             <option value="{{$sucursale->id}}">{{$sucursale->nombre}}</option>
                                       @endforeach
                                    </select>
                                 </span>
                        </div>
                        <!-- /.info-box-content -->
                     </div>
                  </div>
                  @if (!empty($sucursal))
                     <div class="col-12 col-sm-2">
                        <div class="info-box">
                           <span class="info-box-icon bg-maroon elevation-1"><i class="fas fa-stopwatch"></i></span>
                           <div class="info-box-content">
                                 <span class="info-box-text text-capitalize">Fecha de Factura</span>
                                    <span class="info-box-number">
                                       <input type="date" id="fechafac" name="fechafac" wire:model="fechafac">
                                    </span>
                           </div>
                           <!-- /.info-box-content -->
                        </div>
                     </div>
                     @if (!empty($fechafac))
                        <div class="col-12 col-sm-4">
                           <div class="info-box">
                              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-check-alt"></i></span>
                              <div class="info-box-content">
                                    <span class="info-box-text text-capitalize">Lista de Precios</span>
                                       <span class="info-box-number">
                                          @if ($lpsel==1)
                                             <h5>{{$lps->lista}}</h5>
                                             <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-secondary xs" wire:click="tipofac('1')">
                                                   <i class="fas fa-hand-holding-usd"></i> Tarifa
                                                </button>
                                                <button type="button" class="btn btn-secondary xs" wire:click="tipofac('2')">
                                                   <i class="fas fa-concierge-bell"></i> Servicio
                                                </button>
                                                <button type="button" class="btn btn-secondary xs" wire:click="tipofac('5')">
                                                   <i class="fas fa-dolly"></i> Diligencia
                                                </button>
                                             </div>
                                          @else
                                             <h5>No se ha definido Lista de precios</h5>
                                          @endif
                                       </span>
                              </div>
                              <!-- /.info-box-content -->
                           </div>
                        </div>
                     @endif
                  @endif
               @endif
            </div>
         @endif
      </div>
   </div>
   <div class="row justify-content-center">
      @if ($idfactura)
         <div class="col-10">
            @if ($puerta==1)
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>¡Esta seguro(a) de eliminar esta factura!. Esta operación es IRREVERSIBLE</strong>
                     <button type="button" class="btn btn-default" wire:click="eliminarfactura">
                        ELIMINAR
                     </button>
                  <button type="button" class="close"  aria-label="Close" wire:click="cerrar">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            @else
               <table class="table table-bordered table-striped table-responsive">
                  <thead>
                     <tr>
                        <th scope="col" colspan="7" align="center">
                           ENCABEZADO DE LA FACTURA
                        </th>
                     </tr>
                     <tr>
                        <th scope="col"></th>
                        <th scope="col">Fecha:</th>
                        <th scope="col">Vence:</th>
                        <th scope="col">Total:</th>
                        <th scope="col">Impuesto:</th>
                        <th scope="col">Itemes:</th>
                        <th scope="col">Observaciones:</th>
                     </tr>
                  </thead>
                  <tbody>
                     @if ($basicosfactura->estado!=2)
                        <tr>
                           <td>
                              <button type="button" class="btn btn-danger btn-xs" wire:click="abrir">
                                 <i class="far fa-trash-alt"></i>
                              </button>
                              @if ($detallesfactura->count()>0)
                                 <button type="button" class="btn btn-info btn-xs" wire:click="tipofac('3')">
                                    <i class="fas fa-palette"></i>
                                 </button>
                                 <button type="button" class="btn btn-success btn-xs" wire:click="tipofac('4')">
                                    <i class="fas fa-receipt"></i>
                                 </button>
                              @endif
                           </td>
                           <td>
                              {{$basicosfactura->fecha}}
                              <!-- Button trigger modal -->
                              <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#fechactual">
                                 <i class="fas fa-exchange-alt"></i>
                              </button>
                           </td>
                           <td>
                              {{$basicosfactura->fechavence}}
                              <!-- Button trigger modal -->
                              <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#vencera">
                                 <i class="fas fa-exchange-alt"></i>
                              </button>
                           </td>
                           <td>$ {{ number_format($basicosfactura->valor, 0, ',', '.')}}</td>
                           <td>$ {{number_format($basicosfactura->impuesto, 0, ',', '.')}}</td>
                           <td>{{$detallesfactura->count()}}</td>
                           <td>
                                 {{$basicosfactura->observacionesfactura}}
                                 <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#observaciones">
                                    <i class="fas fa-exchange-alt"></i>
                                 </button>
                           </td>
                        </tr>
                     @else
                        <tr>
                           <td>
                           </td>
                           <td>
                              {{$basicosfactura->fecha}}
                           </td>
                           <td>
                              {{$basicosfactura->fechavence}}
                           </td>
                           <td>$ {{ number_format($basicosfactura->valor, 0, ',', '.')}}</td>
                           <td>$ {{number_format($basicosfactura->impuesto, 0, ',', '.')}}</td>
                           <td>{{$detallesfactura->count()}}</td>
                           <td>
                              {{$basicosfactura->observacionesfactura}}
                           </td>
                        </tr>
                     @endif

                  </tbody>
               </table>
               <!-- Modal fecha actual-->
               <div class="modal fade" id="fechactual" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
                  <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                           Fecha Actual: <strong>{{$basicosfactura->fecha}}</strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <input wire:model="fechacam" type="date" id="fechacam" name="fechacam" />
                        <div>
                           @if (session()->has('cambia'))
                                 <div class="alert alert-success">
                                    {{ session('cambia') }}
                                 </div>
                           @endif
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-warning" wire:click="fechacambia({{$idfactura}})">Cambia Fecha</button>
                     </div>
                  </div>
                  </div>
               </div>
               <!-- Modal fecha vencimiento-->
               <div class="modal fade" id="vencera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
                  <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                           Fecha de Vencimiento Actual: <strong>{{$basicosfactura->fechavence}}</strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <input wire:model="fechacamven" type="date" id="fechacamven" name="fechacamven" />
                        <div>
                           @if (session()->has('cambiavence'))
                                 <div class="alert alert-success">
                                    {{ session('cambiavence') }}
                                 </div>
                           @endif
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-warning" wire:click="fechavencecambia({{$idfactura}})">Cambia Fecha Vencimiento</button>
                     </div>
                  </div>
                  </div>
               </div>
               <!-- Modal Observaciones-->
               <div class="modal fade" id="observaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
                  <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                           AGREGAR OBSERVACIONES A LA FACTURA
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
                        <button type="button" class="btn btn-warning" wire:click="insertaobervaciones({{$idfactura}})">Registrar Observaciones</button>
                     </div>
                  </div>
                  </div>
               </div>
            @endif
         </div>
      @endif
   </div>
   <div class="row justify-content-center">
      @switch($tipo)
         @case(1)
            <div class="col-12 col-sm-6">
               <div class="card border-success">
                  <!-- /.card-header -->
                  <div class="card-header bg-success text-lg">
                     <select class="custom-select" name="opesel" id="opesel"


                        wire:model="opesel" >
                        <option selected>Seleccione Operador</option>
                        @foreach ($operadores as $operadore)
                              <option value="{{$operadore->user_id}}">{{$operadore->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="card-body">
                     @if (!empty($opesel))
                        <table class="table table-bordered table-striped table-responsive">
                           <thead>
                              <tr>
                                 <th scope="col">Alias</th>
                                 <th scope="col">Descripción</th>
                                 <th scope="col">Tipo</th>
                                 <th scope="col">Valor</th>
                                 <th scope="col">Cantidad</th>
                                 <th scope="col">Total</th>
                                 <th scope="col"></th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($lppros as $lppro)
                                 <tr>
                                    <td>{{$lppro->alias}}</td>
                                    <td>{{$lppro->descripcion}}</td>
                                    <td>{{$lppro->tipo}}</td>
                                    <td align="right">{{ number_format($lppro->valor, 0, ',', '.') }}</td>
                                    <td>
                                       <input wire:model="cantidad" size="1"/>
                                    </td>
                                    <td>
                                       @php
                                          if(!empty($cantidad)){
                                             $totalitem = $cantidad*$lppro->valor;
                                             echo number_format($totalitem,0, ',', '.');
                                          };
                                       @endphp
                                    </td>
                                    <td>
                                       <button type="button" class="btn btn-info btn-xs" wire:click="incluye({{$lppro->id}})">
                                          <i class="fas fa-check"></i>
                                       </button>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     @endif
                  </div>
                  <!-- /.card-body -->
               </div>
            </div>
         @break
         @case(2)
            <div class="col-12 col-sm-6">
               <div class="card bg-gradient-warning">
                  <div class="card-header text-lg">
                     <form class="form-inline">
                        <div class="input-group mb-2 mr-sm-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">Desde</div>
                           </div>
                           <input type="date" class="form-control" id="fechadesde" name="fechadesde" wire:model="fechadesde">
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">Hasta</div>
                           </div>
                           <input type="date" class="form-control" id="fechahasta" name="fechahasta" wire:model="fechahasta">
                        </div>
                     </form>
                     <div>
                        @if (session()->has('periodo'))
                              <div class="alert alert-success">
                                 {{ session('periodo') }}
                              </div>
                        @endif
                     </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     @switch($serviciocrt)
                        @case(1)
                           <h5>No hay resultados</h5>
                           @break
                        @case(2)
                           <table class="table table-bordered table-striped table-responsive">
                              <thead>
                                 <tr>
                                    <td colspan="7">
                                       Mostrando {{$seleccionados->firstItem()}} a {{$seleccionados->lastItem()}} de {{$seleccionados->total()}} solicitudes
                                    </td>
                                 </tr>
                                 <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Ciudad</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col" colspan="2"></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($seleccionados as $seleccionado)
                                    <tr>
                                       <td><small>{{$seleccionado->created_at}}</small></td>
                                       <td>

                                          @switch($seleccionado->entregado)
                                             @case(1)
                                             <i class="fas fa-laugh-beam"></i>
                                                @break
                                             @case(2)
                                                <i class="far fa-sad-tear"></i>
                                                @break
                                          @endswitch

                                       </td>
                                       <td><small>{{$seleccionado->detalle}} - {{$seleccionado->descripcion}}</small></td>
                                       <td><small>{{$seleccionado->nombreubicacion}}</small></td>
                                       <td><small>{{$seleccionado->observaciones}}</small></td>
                                       <td>
                                          <small>
                                             <select wire:model='productos' wire:change="seleccionaproducto({{$seleccionado->id}})">
                                                <option value="">...</option>
                                                <option value="0">Descarta</option>
                                                @foreach ($lppros as $lppro)
                                                         <option value="{{$lppro->id}}">{{ $lppro->alias}}</option>
                                                @endforeach
                                             </select>
                                          </small>
                                       </td>
                                       <td>
                                          @if ($productos)
                                             <button type="button" class="btn btn-info btn-xs" wire:click="incl({{$seleccionado->id}})">
                                                <i class="fas fa-check"></i>
                                             </button>
                                          @endif
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           {{ $seleccionados->links() }}
                           @break
                  @endswitch
                  </div>
                  <!-- /.card-body -->
               </div>
            </div>
         @break
         @case(3)
            <div class="col-12 col-sm-6">
               <div class="card border-success">
                  <!-- /.card-header -->
                  <div class="card-header text-lg">
                     Resumen de Productos Facturados
                  </div>
                  <div class="card-body">
                     <table class="table table-bordered table-striped table-responsive">
                        <thead>
                           <tr>
                              <th scope="col">Can</th>
                              <th scope="col">Descripción</th>
                              <th scope="col">Valor Unitario</th>
                              <th scope="col">Valor Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($prefactura as $prefact)
                              <tr>
                                 <td align="center">{{$prefact->cantidad}}</td>
                                 <td>{{$prefact->alias}}</td>
                                 <td align="right">{{ number_format($prefact->vr_unitario, 0, ',', '.')}}</td>
                                 <td align="right">{{number_format($prefact->total, 0, ',', '.')}}</td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  <!-- /.card-body -->
               </div>
            </div>
         @break
         @case(4)
            <div class="col-12 col-sm-6">
               <div class="card border-success">
                  <!-- /.card-header -->
                  <div class="card-header text-lg">
                     FINALIZAR FACTURA
                  </div>
                  @if ($final==1)
                     <div class="card-body">
                        <table class="table table-bordered table-striped table-responsive">
                           <thead>
                              <tr>
                                 <th scope="col">Can</th>
                                 <th scope="col">Descripción</th>
                                 <th scope="col">Valor Unitario</th>
                                 <th scope="col">Valor Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($prefactura as $prefact)
                                 <tr>
                                    <td align="center">{{$prefact->cantidad}}</td>
                                    <td>{{$prefact->alias}}</td>
                                    <td align="right">{{ number_format($prefact->vr_unitario, 0, ',', '.')}}</td>
                                    <td align="right">{{number_format($prefact->total, 0, ',', '.')}}</td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     <div class="card-footer">
                        <div class="info-box">
                           <span class="info-box-icon bg-danger elevation-1"><i class="far fa-file-archive"></i></span>
                           <div class="info-box-content">
                                 <span class="info-box-text text-capitalize">CARGAR ZIP DE LA FACTURA</span>
                                    <span class="info-box-number">
                                       <form class="form-inline" action="{{ route('cargazip')}}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                             <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                   <div class="input-group-text">Seleccione el archivo</div>
                                                </div>
                                                <input type="file"  name="zip" id="zip" required>
                                             </div>
                                             <input type="hidden" name="factura_id" id="factura_id" value="{{$idfactura}}" >
                                             <input type="hidden" name="factura_numero" id="factura_numero" value="{{$numerofactura}}" >


                                             <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-truck"></i>
                                             </button>
                                       </form>
                                    </span>
                           </div>
                           <!-- /.info-box-content -->
                        </div>
                     </div>
                  @else
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
                                 <div class="input-group-text">N° de Factura propuesto: {{$numfactura}}</div>
                                 </div>
                                 <input type="text" class="form-control" wire:model='numerofactura' name="numerofactura" id="numerofactura"
                                    required autofocus>
                              </div>
                              <hr>
                              <h5>Seleccione cargos para esta factura:</h5>
                              @foreach ($cargos as $cargo)
                                 <div class="form-check">
                                 <input class="form-check-input" type="checkbox" value="{{$cargo->id}}" id="cargosel[]" name="cargosel[]" wire:model="cargosel">
                                    <label class="form-check-label" for="defaultCheck1">
                                       {{$cargo->cargo}}-{{$cargo->descripcion}}
                                    </label>
                                 </div>
                              @endforeach
                              <hr>


                              <button type="submit" class="btn btn-default">FINALIZAR</button>
                        </form>
                        <div>
                           @if (session()->has('messagerepe'))
                                 <div class="alert alert-warning">
                                    {{ session('messagerepe') }}
                                 </div>
                           @endif
                        </div>
                     </div>
                  @endif
                  <!-- /.card-body -->
               </div>
            </div>
         @break
         @case(5)
            <div class="col-12 col-sm-6">
               <div class="card bg-gradient-success">
                  <div class="card-header text-lg">                     
                     <div>
                        @if (session()->has('periodo'))
                              <div class="alert alert-success">
                                 {{ session('periodo') }}
                              </div>
                        @endif
                     </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     @if ($seleccionados)
                        <table class="table table-bordered table-striped table-responsive">
                           <thead>
                              <tr>
                                 <td colspan="7">
                                    Mostrando {{$seleccionados->firstItem()}} a {{$seleccionados->lastItem()}} de {{$seleccionados->total()}} solicitudes
                                 </td>
                              </tr>
                              <tr>
                                 <th scope="col">Fecha</th>
                                 <th scope="col">Comentarios</th>
                                 <th scope="col">Observaciones</th>
                                 <th scope="col">Vueltas</th>                                    
                                 <th scope="col" colspan="2"></th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($seleccionados as $seleccionado)
                                 <tr>
                                    <td><small>{{$seleccionado->fecha}}</small></td>
                                    <td><small>[{{$seleccionado->id}}] {{$seleccionado->comentarios}}</small></td>                                                                              
                                    <td><small>{{$seleccionado->observaciones}}</small></td>
                                    <td><small>{{$seleccionado->guias}}</small></td>
                                    <td>
                                       <small>
                                          <select wire:model='productos' wire:change="selecdiligencia({{$seleccionado->id}}, {{$seleccionado->guias}})">
                                             <option value="">...</option>
                                             <option value="0">Descarta</option>
                                             @foreach ($lppros as $lppro)
                                                      <option value="{{$lppro->id}}">{{ $lppro->alias}}</option>
                                             @endforeach
                                          </select>
                                       </small>
                                    </td>
                                    <td>
                                       @if ($productos)
                                          <button type="button" class="btn btn-default btn-xs" wire:click="selecdiligencia({{$seleccionado->id}}, {{$seleccionado->guias}})">
                                             <i class="fas fa-check"></i>
                                          </button>
                                       @endif
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                        {{ $seleccionados->links() }}
                     @else
                         <h5>Esta todo facturado</h5>
                     @endif                     
                  </div>
                  <!-- /.card-body -->
               </div>
            </div>
         @break
      @endswitch
      @if ($idfactura)
      <div class="col-12 col-sm-6">
         <div class="card bg-gradient-info">
            <div class="card-header">
               Detalle de la Factura
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <table class="table table-bordered table-striped table-responsive">
                  <thead>
                     <tr>
                        <td colspan="7">
                           Mostrando {{$detallesfactura->firstItem()}} a {{$detallesfactura->lastItem()}} de {{$detallesfactura->total()}} regisros
                        </td>
                     </tr>
                     <tr>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('id')">
                           ID
                           @if ($ordena != 'id')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('name')">
                           Operador
                           @if ($ordena != 'name')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('alias')">
                           Alias
                           @if ($ordena != 'alias')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('cantidad')">
                           Cantidad
                           @if ($ordena != 'cantidad')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('vr_unitario')">
                           Unitario
                           @if ($ordena != 'vr_unitario')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('recorrido_id')">
                           Recorrido
                           @if ($ordena != 'recorrido_id')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('vr_total')">
                           Total
                           @if ($ordena != 'vr_total')
                           <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                     </tr>
                  </thead>
                  @if ($basicosfactura->estado!=2)
                     <tbody>
                        @foreach ($detallesfactura as $detallefactu)
                           <tr>
                              <td>
                                 <button type="button" class="btn btn-danger btn-xs" wire:click="elimproduc({{$detallefactu->id}})">
                                    <i class="far fa-trash-alt"></i>
                                 </button>
                              </td>
                              <td>
                                 <small>{{$detallefactu->name}}</small>
                              </td>
                              <td>
                                 <small>{{$detallefactu->alias}}</small>
                              </td>
                              <td align="center">
                                 <small>
                                    <input wire:blur="modcan({{$detallefactu->id}})"
                                    wire:model="cant" placeholder="{{ $detallefactu->cantidad }}" size="1"/>
                              </small>
                              </td>
                              <td align="right">
                                 <small>{{ number_format($detallefactu->vr_unitario, 0, ',', '.') }}</small>
                              </td>
                              <td align="right">
                                 <small>{{ $detallefactu->recorrido_id }}</small>
                              </td>
                              <td align="right">
                                 <small>{{ number_format($detallefactu->vr_total, 0, ',', '.') }}</small>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  @else
                     <tbody>
                        @foreach ($detallesfactura as $detallefactu)
                           <tr>
                              <td>
                              </td>
                              <td>
                                 <small>{{$detallefactu->name}}</small>
                              </td>
                              <td>
                                 <small>{{$detallefactu->alias}}</small>
                              </td>
                              <td align="center">
                                 <small>{{ $detallefactu->cantidad }}</small>
                              </td>
                              <td align="right">
                                 <small>{{ number_format($detallefactu->vr_unitario, 0, ',', '.') }}</small>
                              </td>
                              <td align="right">
                                 <small>{{ $detallefactu->recorrido_id }}</small>
                              </td>
                              <td align="right">
                                 <small>{{ number_format($detallefactu->vr_total, 0, ',', '.') }}</small>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  @endif
               </table>
               {{ $detallesfactura->links() }}
            </div>
            <!-- /.card-body -->
         </div>
      </div>
      @endif
   </div>

</div>
