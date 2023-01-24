<div>
    @if ($listados->count())
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th colspan="1"></th>
                    <th colspan="1">Tipo</th>
                    <th colspan="1">Número</th>
                    <th colspan="1">Fecha</th>
                    <th colspan="1">Identificación</th>
                    <th colspan="1">Nombre</th>
                    <th colspan="1">Pago</th>
                    <th colspan="1">Banco</th>
                    <th colspan="1">Cuenta</th>
                    <th colspan="1">Tipo de Cuenta</th>                    
                    <th colspan="1">Observaciones</th>
                    <th colspan="1">Soporte</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listados as $item)
                    <tr>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <!-- Button trigger modal -->
                                @if ($item->tipo>3)
                                 <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#editaobligacion" wire:click='cargadatos({{$item->id}}, 1)'>
                                    <i class="fas fa-trash-alt"></i>
                                 </button>
                                @endif
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editaobligacion" wire:click='cargadatos({{$item->id}}, 2)'>
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </button>                                                      
                            </div>
                        </td>
                        <td>
                            @switch($item->tipo)
                            @case(1)
                                Cuentas de Cobro OPS
                                @break
                            @case(2)
                                Pago Nomina
                                @break
                                @case(3)
                                Provisiones de Nomina
                                @break
                                @case(4)
                                Cuentas de Cobro Terceros
                                @break
                                @case(5)
                                Facturas
                                @break
                                @case(6)
                                Servicios Públicos
                                @break
                                @case(7)
                                Productos Financieros
                                @break
                                @case(8)
                                Impuestos
                                @break
                                @case(9)
                                Otros
                                @break
                            @endswitch
                        </td>
                        <td>{{$item->numerotipo}}</td>
                        <td>{{$item->fecha}}</td>
                        <td>{{$item->identificacion}}</td>                        
                        <td>{{$item->nombre}}</td>
                        <td class="text-right">
                            $ {{ number_format($item->pago, 0, ',', '.')}}
                        </td>
                        <td>{{$item->banco}}</td>
                        <td>{{$item->cuenta}}</td>
                        <td>{{$item->tipocuenta}}</td>
                        <td>{{$item->observaciones}}</td>
                        <td>
                            <a href="{{$item->soporte}}" class="brand-link" target="_blank">
                                <i class="fas fa-folder-open"></i>    
                            </a>
                        </td>
                    </tr>
                @endforeach                
            <tbody>
        </table>
    @else
        <h5>No hay obligaciones en Proceso</h5>
    @endif  
    <!-- Modal -->
    <div class="modal fade" id="editaobligacion" tabindex="-1" aria-labelledby="editaobligacionLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="editaobligacionLabel">Gestionar Obligación</h5>
  
              <button type="button" class="close" data-dismiss="modal" wire:click='cerrar' aria-label="Close">
                 <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body">
                  <div class="alert {{$alerta}}" role="alert">
                     {{$mensaje}}
                  </div>
                  @if ($control==2)
                                          
                        <div class="form-group">
                           <label for="pago">Valor a pagar:</label>                           
                           <span class="text">$ {{ number_format($obligasel->pago, 0, ',', '.')}}</span>
                        </div>
                        <div class="form-group">
                           <label for="pago">Seleccione producto financiero</label>                           
                           <select class="custom-select" id="financieroid" wire:model='financierosel'>
                              <option selected>Seleccione ...</option>
                              @foreach ($financieros as $finan)
                                <option value="{{$finan->financiero_id}}-{{$finan->financiero->nombre}}">{{$finan->financiero->nombre}}-{{$finan->saldo}}</option>
                              @endforeach                  
                           </select>
                        </div>  
                        <div class="form-group">
                           <label for="soporte">Soporte:</label>
                           <input type="file" class="form-control" id="soporte" wire:model='soporte' required>
                       </div>                  
                  @endif
                    
  
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" wire:click='cerrar' data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn {{$clase}}" wire:click='{{$funcion}}'>{{$actividad}}</button>                                              
                  <div>
                     @if (session()->has('messagelim'))
                        <div class="alert {{$alerta}}" role="alert">
                           {{ session('messagelim') }}
                        </div>
                     @endif
                 </div>
              </div>
           </div>
        </div>
    </div>  
</div>
