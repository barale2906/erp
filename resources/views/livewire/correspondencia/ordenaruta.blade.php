<div>
   @can('haveaccess','configcorres')
      @php
         $total=2;
      @endphp
   @endcan
   @can('haveaccess','configcorresuper')
      @php
         $total=1;
      @endphp
   @endcan

   <div class="col-12">
      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
         <div class="card">
               <div class="card-header">
                  <h3 class="card-title text-uppercase text-bold text-center text-capitalize">Organizar las Diligencias por ruta</h3>
                  <div class="card-tools">
                     <button type="button" wire:click="cerrar()"
                     class="btn btn-default"><i class="fas fa-times"></i></button>
                  </div>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form  class="form-inline" method="POST" >
                     @csrf
                           @if ($total==1)
                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                       <div class="input-group-text">Elegir Empresa</div>
                                 </div>
                                 <select wire:model='empr' name="empr[]" class="custom-select" multiple size="2">
                                       @foreach ($empresas as $empresa)
                                             <option value="{{$empresa->id}}">{{ $empresa->nombre}}</option>
                                       @endforeach
                                 </select>
                              </div>
                           @else
                              <select wire:model='empr' name="empr[]" class="custom-select" multiple size="2">
                                 <option selected>Seleccione Empresa...</option>
                                 <option value="{{Auth::user()->empresa}}">{{$empresactual->nombre}}</option>
                              </select>
                           @endif
                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">Elegir Ciudad</div>
                              </div>
                              <select wire:model='ciu' name="ciu[]" class="custom-select" multiple size="4">
                                 @foreach ($ciudades as $ciudad)
                                          <option value="{{$ciudad->nombreubicacion}}">{{ $ciudad->nombreubicacion}}</option>
                                 @endforeach
                              </select>
                           </div>
                  </form>
                  <hr>
                  <div class="row">
                     <div class="btn-group" role="group" aria-label="Basic example">
                           @foreach ($rutsels as $rutsel)
                              <button type="button" wire:click="mostrar({{$rutsel->id}})" class="btn btn-secondary">{{$rutsel->nombre}}</button>
                           @endforeach
                     </div>
                  </div>
                  <hr>
                  @if (!empty($solicitudes))
                     <div class="row">
                           <div class="col-12 col-sm-6">
                              @if ($solicitudes->count()>0)
                                 <h4>Se encontrarón {{$solicitudes->count()}} solicitudes</h4>
                                 <table class="table table-bordered table-striped table-responsive">
                                       <thead>
                                          <tr>
                                             <th scope="col" colspan="2">Ruta</th>
                                             @if (Auth::user()->empresa==2)
                                                <th scope="col">Factura</th>
                                             @endif
                                             <th scope="col">Dirección</th>
                                             <th scope="col">Ciudad</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($solicitudes as $solicitud)
                                          <tr>
                                             <td>
                                                   <select wire:model="ruta" wire:change="asignar({{$solicitud->id}})">
                                                               <option value="">Seleccione ruta</option>
                                                      @foreach ($rutas as $ruta)
                                                               <option value="{{$ruta->id}}">{{ $ruta->nombre}}</option>
                                                      @endforeach
                                                   </select>
                                             </td>
                                             <td>
                                                   @if (!empty($rutaeleg))
                                                      <button type="button" wire:click="asignar({{$solicitud->id}})"
                                                         class="btn btn-info btn-xs"><i class="far fa-edit"></i></button>
                                                   @endif
                                             </td>
                                             <td><p class="text text-capitalize">{{$solicitud->descripcion}}</p></td>
                                             <td><p class="text text-capitalize">{{$solicitud->nombresede}}</p></td>
                                             <td>{{$solicitud->nombreubicacion}}</td>

                                          </tr>
                                          @endforeach
                                       </tbody>

                                 </table>
                              @else
                                 <div class="alert alert-default alert-dismissible fade show" role="alert">
                                       <strong>¡Excelente {{Auth::user()->name}}!</strong> Asignaste todas las diligencias con estos parámetros de búsqueda
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                       </button>
                                 </div>
                              @endif

                           </div>
                           <div class="col-12 col-sm-6">
                              @if ($solisel->count()>0)
                              <h4>Total asignado {{$solisel->count()}} a {{$rutaeleg->nombre}}
                                 @if ($numeracion == $solisel->count())
                                       <button wire:click="planillar({{$rutaeleg->id}})"><i class="fas fa-list-ol"></i></button>
                                 @endif
                                 </h4>

                                 <table class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th></th>
                                             <th colspan="2">Ordenar</th>
                                             <th scope="col">°C</th>
                                             <th scope="col">Dirección</th>
                                             <th scope="col">Ciudad</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($solisel as $solis)
                                          <tr>
                                             <td>
                                                   <button type="button" wire:click="eliminar({{$solis->id}})"
                                                   class="btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></button></td>
                                             <td>
                                                   <input wire:blur="ordena({{$solis->id}})"
                                                      size="1" wire:model="ord" placeholder="{{$solis->orden}}">
                                             </td>
                                             <td>
                                                <button type="button" class="btn btn-default" wire:click="organiza({{$solis->id}})">
                                                   <i class="fas fa-sort-amount-up-alt"></i><span class="badge badge-light">{{$orga}}</span>
                                                </button>
                                             </td>
                                             <td>{{$solis->descripcion}}</td>
                                             <td><p class="text text-capitalize">{{$solis->nombresede}}</p></td>
                                             <td>{{$solis->nombreubicacion}}</td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                 </table>

                              @else
                                 <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                       <strong>{{Auth::user()->name}}</strong> ¡No has elegido ninguna diligencia!
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                       </button>
                                 </div>
                              @endif
                           </div>
                     </div>
                  @endif
                  <hr>
               </div>
               <!-- /.card-body -->
               <div class="card-footer">

               </div>
         </div>
         <!-- /.card -->
      </section>
      <!-- /.content -->
   </div>
</div>
