<div>
    @if (empty($idcuenta))
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
            @if ($cuentas->count())
               <p>Se encontrarón: {{$cuentas->total()}} cuentas de cobro </p>
            @endif
         </div>
            @if ($cuentas->count())
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
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('username')">
                            Cédula
                            @if ($ordena != 'username')
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
                        <th scope="col" style="cursor: pointer;" wire:click="ordena('valor')">
                           Valor
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
                     @foreach ($cuentas as $cuenta)
                        <tr>
                           <td>
                              @if ($cuenta->estado==1)
                                 <a class="btn btn-danger btn-sm" href="/cuentacobro" role="button"><i class="fas fa-industry"></i></a>
                              @else
                                 <div class="btn-group" role="group" aria-label="Basic example">                                    
                                    <button type="button" class="btn btn-info btn-sm" wire:click="selid({{$cuenta->id}})"><i class="fas fa-glasses"></i></button>
                                 </div>
                              @endif
                           </td>
                           <td>{{$cuenta->numero}}</td>
                           <td align="right"> {{ number_format($cuenta->username, 0, ',', '.')}}</td>
                           <td>{{$cuenta->name}}</td>                           
                           <td>{{$cuenta->fecha}}</td>
                           <td align="right"> $ {{ number_format($cuenta->valor, 0, ',', '.')}}</td>                           
                           <td>
                              @switch($cuenta->estado)
                                 @case(1)
                                    Proceso
                                    @break
                                 @case(2)
                                    Finalizada
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
                  Mostrando {{$cuentas->firstItem()}} a {{$cuentas->lastItem()}} de {{$cuentas->total()}} cuentas
               </p>
               <p>
                  {{$cuentas->links()}}
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
                     <th scope="col"><strong>N°</strong></th>
                     <th scope="col"><strong>Operador</strong></th>
                     <th scope="col"><strong>Fecha</strong></th>
                     <th scope="col"><strong>Valor</strong></th>
                     <th scope="col"><strong>Observaciones</strong></th>
                     <th scope="col"><strong>Fecha Pago</strong></th>
                     <th scope="col"><strong>Valor pagado</strong></th>
                     <th scope="col"><strong>Observaciones de pago</strong></th>
                  </tr>
               </thead>
               <tbody>
                  <tr>                     
                     <td class="text text-sm">{{$cuentasele->numero}}</td>
                     <td class="text text-sm">{{$cuentasele->name}}</td>
                     <td class="text text-sm">{{$cuentasele->fecha}}</td>                     
                     <td class="text text-sm">$ {{number_format($cuentasele->valor, 0, ',', '.')}}</td>
                     <td class="text text-sm">{{$cuentasele->observaciones}}</td>
                     <td class="text text-sm">{{$cuentasele->fechapago}}</td>
                     <td class="text text-sm">$ {{number_format($cuentasele->valorpagado, 0, ',', '.')}}</td>
                     <td class="text text-sm">{{$cuentasele->observacionespago}}</td>
                  </tr>                            
               </tbody>
            </table>
         </div>
         <div class="card-body">
            <table class="table table-bordered table-striped table-responsive">
               <thead>
                  <tr>
                     <th></th>
                  </tr>
               </thead>
               <tbody></tbody>
            </table>
         </div>
      </div>
   @endif
</div>
