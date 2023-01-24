<div>
    <div class="btn-group" role="group" aria-label="Basic example">
       <!-- Button trigger modal -->
       <button type="button" class="btn btn-success" data-toggle="modal" data-target="#creaobligacion">
          Crear
       </button>
       <!-- Button trigger modal -->
       <button type="button" class="btn btn-info" wire:click='periomuestra'>
          Períodica
       </button>
       <a class="btn btn-primary" href="/obligahist" role="button">Historial</a>
    </div>
 
 @if ($periodica==2)
    <div class="card m-1">
       <div class="card-header">
          Obligaciones Períodicas programadas
       </div>
       <ul class="list-group list-group-flush">
          @foreach ($periodicas as $perio)
             <li class="list-group-item">
                <small>
                   <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#creaobligacion" wire:click='obligasele({{$perio->id}})'>
                      <i class="fas fa-check"></i>
                   </button>
                   <strong>Tipo:</strong> 
                   @switch($perio->estado)
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
                   
                   <strong>Nombre:</strong> {{$perio->nombre}}
                   <strong>Documento:</strong> {{$perio->identificacion}}
                   <strong>Banco:</strong> {{$perio->banco}}
                   <strong>Cuenta:</strong> {{$perio->cuenta}}
                   <strong>Tipo Cuenta:</strong> {{$perio->tipocuenta}}
                   <strong>Observaciones:</strong> {{$perio->observaciones}}                   
                </small>                
             </li>
          @endforeach
       </ul>
    </div>
 @endif
 
    <!-- Modal -->
    <div class="modal fade" id="creaobligacion" tabindex="-1" aria-labelledby="creaobligacionLabel" aria-hidden="true" wire:ignore.self>
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
             <h5 class="modal-title" id="creaobligacionLabel">Crear Obligación</h5>
 
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
             </button>
             </div>
             <div class="modal-body">
                   <div class="form-group">
                      <label for="tipo">Tipo</label>
                      <select class="custom-select" id="tipo" wire:model='tipo'>
                         <option selected>Tipo de Obligación...</option>
                         <option value="1">Cuentas de Cobro OPS</option>
                         <option value="2">Pago Nomina</option>
                         <option value="3">Provisiones de Nomina</option>
                         <option value="4">Cuentas de Cobro Terceros</option>
                         <option value="5">Facturas</option>
                         <option value="6">Servicios Públicos</option>
                         <option value="7">Productos Financieros</option>
                         <option value="8">Impuestos</option>
                         <option value="9">Otros</option>
                      </select>
                   </div> 
                   @if (!empty($tipo))                      
                      <div class="form-group">
                         <label for="numerotipo">Número Tipo</label>
                         <input type="text" class="form-control" id="numerotipo" wire:model='numerotipo' placeholder="numero documento" required>
                      </div>
                   @endif    
                   @if (!empty($tipo))                      
                      <div class="form-group">
                         <label for="nombre">Nombre</label>
                         <input type="text" class="form-control" id="nombre" wire:model='nombre' placeholder="Nombre aplicable a la obligación" required>
                      </div>
                   @endif 
                   @if (!empty($nombre))                      
                      <div class="form-group">
                         <label for="identificacion">Número de Identificación</label>
                         <input type="text" class="form-control" id="identificacion" wire:model='identificacion' placeholder="Cédula - NIT" required>
                      </div>
                   @endif 
                   @if (!empty($identificacion))                      
                      <div class="form-group">
                         <label for="banco">Banco</label>
                         <input type="text" class="form-control" id="banco" wire:model='banco' placeholder="Entidad donde se hace el pago" required>
                      </div>
                   @endif
                   @if (!empty($banco))                      
                      <div class="form-group">
                         <label for="cuenta">N° Cuenta</label>
                         <input type="text" class="form-control" id="cuenta" wire:model='cuenta' placeholder="Número producto" required>
                      </div>
                   @endif 
                   @if (!empty($cuenta))                      
                      <div class="form-group">
                         <label for="tipocuenta">Tipo Cuenta</label>
                         <input type="text" class="form-control" id="tipocuenta" wire:model='tipocuenta' placeholder="Número producto" required>
                      </div>
                   @endif                   
                   @if (!empty($nombre))
                      <hr>
                      <div class="form-group">
                         <label for="exampleInputPassword1">Fecha:</label>
                         <input type="date" class="form-control" id="fecha" wire:model='fecha' required>
                      </div>
                   @endif
                   @if (!empty($fecha))                      
                      <div class="form-group">
                         <label for="pago">Valor:</label>
                         <input type="text" class="form-control" id="pago" wire:model='pago' placeholder="Costo de la obligación" required>
                      </div>
                   @endif  
                   @if (!empty($pago))
                      <hr>
                      <div class="form-group">
                         <label for="observaciones">Observaciones:</label>
                         <textarea class="form-control" id="observaciones" wire:model='observaciones'></textarea>
                      </div>                       
                        <hr>               
                        <div class="form-group">
                            <label for="soporte">Soporte:</label>
                            <input type="file" class="form-control" id="soporte" wire:model='soporte' required>
                        </div>
                    @endif
 
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click='cerrar' data-dismiss="modal">Cerrar</button>
                @if (!empty($pago))
                   <button type="button" class="btn btn-success" wire:click='crear'>Crear Obligación</button>
                   @if ($periodica!=2)
                      <div class="form-control form-check">
                         <input class="form-check-input" type="checkbox" value="1" id="periodica" wire:model='periodica'>
                         <label class="form-check-label" for="periodica">
                            Diligencia Períodica
                         </label>
                      </div>
                   @endif
                @endif
                <div>
                   @if (session()->has('messagelim'))
                         <div class="alert alert-success">
                            {{ session('messagelim') }}
                         </div>
                   @endif
                </div>
             </div>
          </div>
       </div>
    </div>
 
 </div>