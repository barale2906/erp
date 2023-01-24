<div>
   @if ($idfactura==0)
      <div class="card">
         <div class="row mb-4">
            <div class="col form-inline">
                  Por Página: &nbsp;
                  <select wire:model="porpagina" class="form-control">
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                  </select>
            </div>
            <div class="col input-group">
                  <input wire:model.debounce.300ms="buscar" class="form-control" type="text" placeholder="Buscar">
                  <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary form-control" wire:click='limpiar'><i class="fas fa-eraser"></i></button>
                  </div>
            </div>
            @if ($facturas->count())
               <p>Se encontrarón: {{$facturas->total()}} solicitudes activas </p>
            @endif
         </div>
            @if ($facturas->count())
               <table class="table table-bordered table-striped table-responsive">
                  <thead>
                     <tr>
                        <th scope="col"></th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('numero')">
                           No
                           @if ($ordena != 'numero')
                              <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('valor')">
                           Valor Total
                           @if ($ordena != 'valor')
                              <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('fecha')">
                           Fecha
                           @if ($ordena != 'fecha')
                              <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('nit')">
                           NIT
                           @if ($ordena != 'nit')
                              <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('nombre')">
                           Cliente
                           @if ($ordena != 'nombre')
                              <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('sucursal')">
                           Sucursal
                           @if ($ordena != 'sucursal')
                              <i class="fas fa-sort"></i>
                           @else
                              @if ($ordenado=='ASC')
                                 <i class="fas fa-sort-up"></i>
                              @else
                                 <i class="fas fa-sort-down"></i>
                              @endif
                           @endif
                        </th>
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('estado')">
                           Estado
                           @if ($ordena != 'estado')
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
                  <tbody>
                     @foreach ($facturas as $factura)
                        <tr>
                           <td>
                              @if ($factura->estado==1)
                                 <a class="btn btn-danger btn-sm" href="/factura" role="button"><i class="fas fa-industry"></i></a>
                              @else
                                 <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-warning btn-sm" wire:click="selid({{$factura->id}}, 1)"><i class="fas fa-pencil-alt"></i></button>
                                    <button type="button" class="btn btn-info btn-sm" wire:click="selid({{$factura->id}}, 2)"><i class="fas fa-glasses"></i></button>
                                 </div>
                              @endif
                           </td>
                           <td>{{$factura->numero}}</td>
                           <td align="right"> $ {{ number_format($factura->valor, 0, ',', '.')}}</td>
                           <td>{{$factura->fecha}}</td>
                           <td>{{number_format($factura->nit, 0, ',', '.')}}</td>
                           <td>{{$factura->nombre}}</td>
                           <td>{{$factura->sucursal}}</td>
                           <td>
                              @switch($factura->estado)
                                 @case(1)
                                    Proceso
                                    @break
                                 @case(2)
                                    Facturado
                                    @break
                                 @case(3)
                                    Abonada
                                    @break
                                 @case(4)
                                    Pagada
                                    @break
                                 @case(5)
                                    Anulada
                                    @break
                              @endswitch
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
               <p>
                  Mostrando {{$facturas->firstItem()}} a {{$facturas->lastItem()}} de {{$facturas->total()}} Facturas
               </p>
               <p>
                  {{$facturas->links()}}
               </p>
            @else
            <h4 class="p-1 m-1">No se encontrarón Registros</h4>
            @endif
         </div>
      </div>
   @else
      <div class="card">
         <div class="card-header text-lg">
            <table class="table table-bordered table-striped table-responsive">
               <thead>
                  <tr>
                     <th scope="col"><strong>Propiedad</strong></th>
                     <th scope="col"><strong>Valor</strong></th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Factura N°: </strong></td>
                     <td class="text text-sm">{{$actual->numero}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>NIT: </strong></td>
                     <td class="text text-sm">{{$actual->nit}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Cliente: </strong></td>
                     <td class="text text-sm">{{$actual->nombre}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>sucursal: </strong></td>
                     <td class="text text-sm">{{$actual->sucursal}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Dirección: </strong></td>
                     <td class="text text-sm">{{$actual->direccion}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Fecha: </strong></td>
                     <td class="text text-sm">{{$actual->fecha}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Vence: </strong></td>
                     <td class="text text-sm">{{$actual->fechavence}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Valor: </strong></td>
                     <td class="text text-sm">$ {{number_format($actual->valor, 0, ',', '.')}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Valor Pagado: </strong></td>
                     <td class="text text-sm">$ {{number_format($actual->valorpagado, 0, ',', '.')}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Impuesto Deducido: </strong></td>
                     <td class="text text-sm">$ {{number_format($actual->impuesto, 0, ',', '.')}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Total: </strong></td>
                     <td class="text text-sm">
                        @php
                            $total = $actual->impuesto+$actual->valorpagado;
                        @endphp
                        $ {{number_format($total, 0, ',', '.')}}
                     </td>
                  </tr>
                  @if ($actual->estado>=3 && $actual->estado<=4)
                     <tr>
                        <td scope="col" class="text text-maroon text-sm"><strong>Registro de pagos: </strong></td>
                        <td class="text text-sm">

                           <table class="table table-bordered table-striped table-responsive">
                              <thead>
                                 <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Soporte</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($actual->cajas as $caja)
                                    <tr>
                                       <td>{{$caja->documento}}</td>
                                       <td align="right">$ {{number_format($caja->valor, 0, ',', '.')}}</td>
                                       <td>
                                          <button type="button" class="btn btn-sm"><a href="/{{$caja->imagen}}" target="_blank"><i class="fas fa-download"></i></a></button>
                                       </td>
                                    </tr>
                                 @endforeach                                 
                              </tbody>
                           </table>                           
                        </td>
                     </tr>
                  @endif                  
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Observaciones de pago: </strong></td>
                     <td class="text text-sm">{{$actual->observacionespago}}</td>
                  </tr>
                  <tr>
                     <td scope="col" class="text text-maroon text-sm"><strong>Observaciones Factura: </strong></td>
                     <td class="text text-sm">{{$actual->observacionesfactura}}</td>
                  </tr>
                  @if ($zip)
                     <tr>
                        <td scope="col" class="text text-maroon text-sm"><strong>Descargar: </strong></td>
                        <td class="text text-sm"><button type="button" class="btn btn-success btn-sm"><a href="/{{$zip->ruta}}"><i class="fas fa-download"></i></a></button></td>
                     </tr>
                  @endif
               </tbody>
            </table>
         </div>
         <div class="card-body">
            @if ($control==1)
               <div>
                  @if (session()->has('suceso'))
                        <div class="alert alert-warning">
                           {{ session('suceso') }}
                        </div>
                  @endif
               </div>
               @if ($actual->estado!=1 && $actual->estado!=5)
                  <!-- Small boxes (Stat box) -->
                  <div class="row">
                     @if ($actual->estado!=4)
                        <div class="col-xs-12 col-sm-6">
                           <!-- small box -->
                           <div class="small-box bg-info">
                              <div class="inner">
                                 <h4>Registrar Pago</h4>

                                 <form wire:submit.prevent="cargapago">                                    
                                    <div class="form-group">
                                       <label for="entrego">Seleccione a donde ingreso el pago</label>
                                       <select class="custom-select" id="financiero" wire:model='financiero' aria-label="Example select with button addon" required>
                                          <option selected>Elija cuenta...</option>
                                          @foreach ($cuentas as $cuenta)
                                             <option value="{{$cuenta->id}}">{{$cuenta->nombre}}</option>
                                          @endforeach                                                                                    
                                       </select>
                                       @error('financiero') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                       <label for="entrego">Fecha pago</label>
                                       <input class="form-control-file" type="date" id="fechapago" wire:model='fechapago' required>
                                       @error('fechapago') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                       <label for="entrego">Valor pagado</label>
                                       <input class="form-control-file" id="valorpago" wire:model="valorpago" required>
                                       <span class="error text-danger">sin puntos ni comas.</span>
                                       @error('valorpago') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                       <label for="entrego">Impuesto descontado</label>
                                       <input class="form-control-file" id="valorimpu" wire:model="valorimpu" required>
                                       <span class="error text-danger">sin puntos ni comas.</span>
                                       @error('valorimpu') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                       <label for="observaciones">Observaciones de pago:</label>
                                       <textarea class="form-control" id="observaciones" rows="3" wire:model='observaciones' required></textarea>
                                       @error('observaciones') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                       <label for="foto">Cargar Soporte (solamente PDF)</label>
                                       <input type="file" class="form-control-file" id="soporte" wire:model='soporte' required>
                                       @error('soporte') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>                                    
                                    @can('haveaccess','financiero.gest')
                                       <button type="submit" class="btn btn-warning">Guarda Registro</button>
                                    @endcan
                                    <div>
                                       @if (session()->has('factura'))
                                          <div class="alert {{$class}}" role="alert">
                                             <strong>¡Importante!</strong> {{ session('factura') }}
                                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                       @endif
                                    </div>
                                 </form>
                              </div>                              
                           </div>
                        </div> 
                     @endif
                     @if ($actual->estado!=3 && $actual->estado!=4)
                        <!-- ./col -->
                        <div class="col-xs-12 col-sm-6">
                           <!-- small box -->
                           <div class="small-box bg-warning">
                              <div class="inner">
                                 <h4>Anular la Factura</h4>
                                 <textarea class="form-control" id="obsanular" wire:model='obsanular' rows="2"></textarea>
                              </div>
                              @if ($obsanular)
                                 <a class="small-box-footer">
                                    <button type="button" class="btn btn-danger mb-2" wire:click='anula'>
                                       Anular <small><strong>¡CUIDADO!</strong> Está operación es irreversible!</small>
                                    </button>
                                 </a>
                              @endif
                           </div>
                        </div>
                     @endif
                  </div>
               @endif
            @endif
            <table class="table table-bordered table-striped table-responsive">
               <thead>
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
                     <th scope="col" style="cursor: pointer;" wire:click="ordena('producto')">
                        Producto
                        @if ($ordena != 'producto')
                           <i class="fas fa-sort"></i>
                        @else
                           @if ($ordenado=='ASC')
                              <i class="fas fa-sort-up"></i>
                           @else
                              <i class="fas fa-sort-down"></i>
                           @endif
                        @endif
                     </th>
                     <th scope="col" style="cursor: pointer;" wire:click="ordena('descripcion')">
                        Descripción
                        @if ($ordena != 'descripcion')
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
                        Valor Unitario
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
                     <th scope="col" style="cursor: pointer;" wire:click="ordena('vr_total')">
                        Valor Total
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
               <tbody>
                  @foreach ($detalles as $detalle)
                     <tr>
                        <td>{{$detalle->id}}</td>
                        <td>{{$detalle->producto}}</td>
                        <td>{{$detalle->descripcion}}</td>
                        <td>{{$detalle->alias}}</td>
                        <td>{{$detalle->cantidad}}</td>
                        <td align="right"> $ {{ number_format($detalle->vr_unitario, 0, ',', '.')}}</td>
                        <td align="right"> $ {{ number_format($detalle->vr_total, 0, ',', '.')}}</td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   @endif
</div>
