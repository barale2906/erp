<div>
    <div class="row">
        <form class="form-inline">
            <div class="input-group mb-2 mr-sm-2">
               <div class="input-group-prepend">
                  <div class="input-group-text">Producto:</div>
               </div>
               <select class="custom-select" id="financieroid" wire:model='financierosel' wire:change='seleccionafinanciero'>
                  <option selected>Seleccione ...</option>
                  @foreach ($financieros as $finan)
                    <option value="{{$finan->id}}">{{$finan->nombre}}</option>
                  @endforeach                  
               </select>
            </div>
            @if ($financieroid)
                <div class="btn-group" role="group" aria-label="Basic example">                   
                    @if ($financieroid==1)
                        <button type="button" class="btn btn-secondary" >
                            Saldo: $ {{ number_format($saldo->sum('valor'), 0, ',', '.')}}
                        </button>    
                    @else
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cargapago">
                            Saldo: $ {{ number_format($saldo->sum('valor'), 0, ',', '.')}}
                        </button>
                    @endif
                    @if ($financieroid!=1)
                        <button type="button" class="btn btn-success" wire:click='movimientomuestra'>
                            Movimientos
                        </button>
                    @endif                    
                </div>
            @endif                      
        </form>
    </div>
    <div class="row">        
        @if ($financieroid==1)            
            @foreach ($saldoindi as $indi)
                <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">{{$indi->usuario}}: .</h5>
                            <div class="btn-group" role="group" aria-label="Basic example">    
                                <button type="button" wire:click="ususele({{$indi->saldo}}, {{$indi->user_id}})" class="btn btn-info btn-xs" data-toggle="modal" data-target="#cargapago">
                                    $ {{ number_format($indi->saldo, 0, ',', '.')}}
                                </button>
                                <button type="button" class="btn btn-success btn-xs" wire:click='movimientomuestra({{$indi->user_id}})'>
                                    Movimientos
                                </button>
                            </div>
                      </div>
                    </div>
                </div>
            @endforeach
        @endif          
    </div>
    @if ($muestramovimi)
        <div class="row">
            <div class="row mb-4">
                <div class="col form-inline">
                    Por Página: &nbsp;
                    <select wire:model="porpagina" class="form-control">                            
                            <option>10</option>
                            <option>20</option>
                            <option>50</option>
                            <option>70</option>
                            <option>100</option>
                    </select>
                </div>
                <div class="col input-group">
                    <input wire:model.debounce.300ms="buscar" class="form-control" type="text" placeholder="Buscar">                    
                </div>
    
                <p>Se encontrarón: {{$movimientos->total()}} registros </p>
    
            </div>
            <table class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th colspan="4"><strong>TOTAL</strong></th>
                    <th><strong>$ {{ number_format($movimientos->sum('valor'), 0, ',', '.')}}</strong></th>
                </tr>
                <tr>
                    <th scope="col" style="cursor: pointer;" wire:click="ordena('created_at')">
                        Fecha
                        @if ($ordena != 'created_at')
                        <i class="fas fa-sort"></i>
                        @else
                        @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                        @else
                        <i class="fas fa-sort-down"></i>
                        @endif
                        @endif
                    </th>
                    <th scope="col" style="cursor: pointer;" wire:click="ordena('movimiento')">
                        Movimiento
                        @if ($ordena != 'movimiento')
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
                    <th scope="col">Soporte</th>                                        
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
                </tr>
                </thead>
                <tbody>
                @foreach ($movimientos as $item)
                    <tr>
                        <td>
                            {{$item->created_at}}
                        </td>
                        <td>
                            <small>{{$item->movimiento}}</small>
                        </td>
                        <td>
                            <small>{{$item->descripcion}}</small>
                        </td>
                        <td>                            
                            <a href="{{$item->imagen}}" class="brand-link" target="_blank">
                                <i class="fas fa-folder-open"></i>    
                            </a>
                        </td>
                        <td class="text-right">
                            $ {{ number_format($item->valor, 0, ',', '.')}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p>
                Mostrando {{$movimientos->firstItem()}} a {{$movimientos->lastItem()}} de {{$movimientos->total()}} registros
            </p>
            <p>
                {{$movimientos->links()}}
            </p>
        </div>
    @endif    
    @if ($financieroid)
        <!-- Modal fecha actual-->
        <div class="modal fade" id="cargapago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    PRODUCTO: <strong>{{$financieroid}} - {{$financieronombre}} </strong> {{$usuarioid}}, {{$usuario}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" wire:click='cancelar' aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @switch($movimiento)
                    @case(1)
                    <div class="alert alert-info" role="alert">
                    @break
                    @case(2)
                    <div class="alert alert-warning" role="alert">
                    @break
                    @default
                    <div class="alert alert-default" role="alert">
                @endswitch
            
            
                    <form class="form-inline" wire:submit.prevent="cargar">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Mov:</div>
                            </div>
                            <select class="custom-select" id="movimiento" wire:model='movimiento'>
                                <option selected>Seleccione ...</option>
                                <option value="1">Recibe dinero</option>
                                <option value="2">Entrega dinero</option>
                            </select>
                        </div>

                        @if (!empty($movimiento))
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Descripción</div>
                                </div>
                                <textarea class="form-control" id="descripcion" wire:model='descripcion' rows="3" required></textarea>
                                @error('descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Valor</div>
                                </div>
                                <input type="number" class="form-control" id="valor" wire:model='valor' placeholder="cantidad recibida" required>
                                @error('valor') <span class="error text-danger">{{ $message }}</span> @enderror
                                <span class="text-default"><strong>Sin puntos, ni comas</strong></span>
                            </div>
                            <h5>Movimiento entre productos</h5>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Producto:</div>
                                                                 
                                </div>
                                <select class="custom-select" id="efectivo" wire:model='efectivo'>
                                    <option selected>Seleccione producto...</option>
                                    <option value="1">Efectivo</option>
                                    <option value="2">Otros productos</option>
                                </select>
                            </div>
                            
                            @if (!empty($efectivo))
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        @if ($movimiento==1)
                                            <div class="input-group-text">De:</div>
                                        @endif
                                        @if ($movimiento==2)
                                            <div class="input-group-text">A:</div>
                                        @endif                                    
                                    </div>
                                    @switch($efectivo)
                                        @case(1)
                                            <select class="custom-select" id="usude" wire:model='usude'>
                                                <option selected>Seleccione caja...</option>
                                                @foreach ($saldoindi as $pos)
                                                    @if ($usuarioid != $pos->user_id)
                                                        <option value="{{$pos->user_id}}-{{$pos->usuario}}">{{$pos->usuario}} $ {{ number_format($pos->saldo, 0, ',', '.')}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @break
                                        @case(2)
                                            <select class="custom-select" id="usude" wire:model='usude'>
                                                <option selected>Seleccione producto...</option>
                                                @foreach ($saldoproductos as $pos)
                                                    @if ($financieroid != $pos->financiero_id)
                                                        <option value="{{$pos->financiero_id}}">{{$pos->financiero->nombre}} $ {{ number_format($pos->saldo, 0, ',', '.')}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @break
                                    @endswitch                                    
                                </div>
                            @endif                                               
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Soporte:</div>
                                </div>
                                <input type="file" class="form-control" id="foto" wire:model='foto' required>
                                @error('foto') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-default mb-2">Registrar</button>
                        @endif
            
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click='cancelar'>Cerrar</button>                
                <div>
                    @if (session()->has('suceso'))
                       <div class="alert alert-warning" role="alert">
                          <strong>¡Importante!</strong> {{ session('suceso') }}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                    @endif
                 </div>
            </div>
            </div>
            </div>
        </div>
    @endif    
</div>
