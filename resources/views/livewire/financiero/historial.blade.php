<div>
    <div class="row mb-4">
       <div class="col form-inline">
          Por Página: &nbsp;
          <select wire:model="porpagina" class="form-control">             
             <option>5</option>
             <option>10</option>
             <option>20</option>
             <option>50</option>
             <option>100</option>
          </select>
       </div>
 
       <div class="col">
          <input wire:model.debounce.300ms="buscar" class="form-control" type="text" placeholder="Buscar">
       </div>
       <div class="col">
            <input wire:model.debounce.300ms='fechaini' class="form-control" type="date">
            <input wire:model.debounce.300ms='fechafin' class="form-control" type="date">
        </div>
 
       <p>Se encontrarón: {{$obligaciones->total()}} diligencias</p>
    </div>
    @if ($obligaciones->count())
 
       <table class="table table-bordered table-striped table-responsive">
          <thead>
            <tr>
                <th scope="col">                    
                </th>
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
                <th scope="col" style="cursor: pointer;" wire:click="ordena('nombre')">
                    Nombre
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
                <th scope="col" style="cursor: pointer;" wire:click="ordena('identificacion')">
                    Identificación
                    @if ($ordena != 'identificacion')
                    <i class="fas fa-sort"></i>
                    @else
                    @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                    @else
                        <i class="fas fa-sort-down"></i>
                    @endif
                    @endif
                </th>
                <th scope="col" style="cursor: pointer;" wire:click="ordena('banco')">
                    Banco
                    @if ($ordena != 'banco')
                    <i class="fas fa-sort"></i>
                    @else
                    @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                    @else
                        <i class="fas fa-sort-down"></i>
                    @endif
                    @endif
                </th>
                <th scope="col" style="cursor: pointer;" wire:click="ordena('cuenta')">
                    Cuenta
                    @if ($ordena != 'cuenta')
                    <i class="fas fa-sort"></i>
                    @else
                    @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                    @else
                        <i class="fas fa-sort-down"></i>
                    @endif
                    @endif
                </th>
                <th scope="col" style="cursor: pointer;" wire:click="ordena('tipocuenta')">
                    Tipo de Cuenta
                    @if ($ordena != 'tipocuenta')
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
                <th scope="col" style="cursor: pointer;" wire:click="ordena('tipo')">
                    Tipo
                    @if ($ordena != 'tipo')
                    <i class="fas fa-sort"></i>
                    @else
                    @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                    @else
                        <i class="fas fa-sort-down"></i>
                    @endif
                    @endif
                </th>
                <th scope="col" style="cursor: pointer;" wire:click="ordena('numerotipo')">
                    Numero 
                    @if ($ordena != 'numerotipo')
                    <i class="fas fa-sort"></i>
                    @else
                    @if ($ordenado=='ASC')
                        <i class="fas fa-sort-up"></i>
                    @else
                        <i class="fas fa-sort-down"></i>
                    @endif
                    @endif
                </th>
                <th scope="col" style="cursor: pointer;" wire:click="ordena('pago')">
                    Pago 
                    @if ($ordena != 'pago')
                    <i class="fas fa-sort"></i>
                    @else
                    @if ($ordenado=='ASC')
                    <i class="fas fa-sort-up"></i>
                    @else
                    <i class="fas fa-sort-down"></i>
                    @endif
                    @endif
                </th>
                <th scope="col" style="cursor: pointer;" wire:click="ordena('observaciones')">
                    Observaciones 
                    @if ($ordena != 'observaciones')
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
                <th scope="col" >
                    Soporte                        
                </th>                   
            </tr>
          </thead>
          <tbody>
             @foreach ($obligaciones as $obligacione)
                <tr>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" wire:click='consulta({{$obligacione->id}})' data-toggle="modal" data-target="#editaobligacion">
                        <i class="fas fa-images"></i>
                        </button>
                    </td>
                    <td>{{$obligacione->id}}</td>
                    <td>{{$obligacione->nombre}}</td>
                    <td>{{$obligacione->identificacion}}</td>
                    <td>{{$obligacione->banco}}</td>
                    <td>{{$obligacione->cuenta}}</td>
                    <td>{{$obligacione->tipocuenta}}</td>
                    <td>{{$obligacione->fecha}}</td>
                    <td>
                        @switch($obligacione->tipo)
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
                    <td>{{$obligacione->numerotipo}}</td>
                    <td>{{$obligacione->pago}}</td>
                    <td>{{$obligacione->observaciones}}</td>
                    <td>
                        @switch($obligacione->estado)
                            @case(1)
                                Creada
                                @break
                            @case(2)
                                Abonado
                                @break
                            @case(3)
                                Pagado
                                @break
                            @case(4)
                                Cancelado
                                @break
                            @case(5)
                                Anulado
                                @break
                        @endswitch                        
                    </td>
                    <td>
                        <a href="{{$obligacione->soporte}}" class="brand-link" target="_blank">
                            <i class="fas fa-folder-open"></i>    
                        </a>
                    </td>                      
                </tr>
             @endforeach
          </tbody>
       </table>
       <p>
          Mostrando {{$obligaciones->firstItem()}} a {{$obligaciones->lastItem()}} de {{$obligaciones->total()}} diligencias
       </p>
       <p>
          {{$obligaciones->links()}}
       </p>
    @else
       <div class="col-sm-4">
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
             <strong><i class="far fa-surprise"></i></strong></strong> ¡No se hallaron resultados para esta búsqueda!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
             </button>
          </div>
       </div>
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
