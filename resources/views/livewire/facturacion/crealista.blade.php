<div>
   <div class="card">
      <div class="card-header">
         <h3 class="card-title center">Nueva Lista</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
         <div class="row">
            <div class="col-12">
               <div class="card bg-gradient-info">
                  <div class="card-body">
                     <form wire:submit.prevent='submit' method="POST" class="form-inline" >
                        @csrf
                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">Lista</div>
                              </div>
                              <input type="text" class="form-control" wire:model='lista' name="lista" id="lista" required>
                           </div>
                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">Inicia</div>
                              </div>
                              <input type="date" class="form-control" wire:model='inicio' name="inicio" id="inicio" required>
                           </div>
                           <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text">Termina</div>
                              </div>
                              <input type="date" class="form-control" wire:model='fin' name="fin" id="fin" required>
                           </div>
                           <button type="submit" class="btn btn-default">Crear</button>
                     </form>
                     <div>
                        @if (session()->has('message'))
                              <div class="alert alert-success">
                                 {{ session('message') }}
                              </div>
                        @endif
                     </div>
                     <div>
                        @if (session()->has('listaope'))
                              <div class="alert alert-warning">
                                 {{ session('listaope') }}
                              </div>
                        @endif
                     </div>
                  </div>
                  <!-- /.card-body -->
               </div>
               <hr>
            </div>
         </div>
         <div class="row justify-content-center">
            <div class="col-12 col-sm-4">
               <div class="card bg-gradient-success">
                  <!-- /.card-header -->
                  <div class="card-body">
                     <table class="table table-bordered table-striped table-responsive">
                        <thead>
                           <tr>
                              <th colspan="4">LISTAS ACTIVAS O EN PROCESO</th>
                           </tr>
                           <tr>
                              <th scope="col"></th>
                              <th scope="col">Lista</th>
                              <th scope="col">Inicia</th>
                              <th scope="col">Termina</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($listas as $lista)
                              <tr>
                                 <td>
                                    <button type="button" class="btn" wire:click="ver({{$lista->id}})"><i class="fas fa-highlighter"></i></button>
                                 </td>
                                 <td>{{$lista->lista}}</td>
                                 <td>{{$lista->inicio}}</td>
                                 <td>{{$lista->fin}}</td>
                              </tr>
                           @endforeach

                        </tbody>
                     </table>
                  </div>
                  <!-- /.card-body -->
               </div>
            </div>
            @if ($idlista>0)
               <div class="col-12 col-sm-7">
                  <div class="card bg-gradient-gray">
                     <div class="card-header">
                        <div class="row">
                           <div class="col-12 col-sm-6">
                              {{$listasel->lista}} Desde: {{$listasel->inicio}} Hasta: {{$listasel->fin}}.
                           </div>

                           <div class="col-12 col-sm-6">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                 @if ($listasel->estado == 2)
                                    <button type="button" class="btn btn-secondary" wire:click="accion(1)">Reutilizar</button>
                                    <button type="button" class="btn btn-secondary" wire:click="accion(3)">Inactivar</button>
                                 @endif
                                 @if ($listasel->estado == 1)
                                    @if ($productosels->count()>0 && $empreses->count()>0)
                                       <button type="button" class="btn btn-secondary" wire:click="accion(2)">Activar</button>
                                    @endif
                                    <button type="button" class="btn btn-secondary" wire:click="accion(4)">Eliminar</button>
                                 @endif
                              </div>
                           </div>
                        </div>
                        @if ($accion!="")
                           <hr>
                              @switch($accion)
                                 @case(1)
                                    <div class="row justify-content-center">
                                       <div class="col-lg-5 col-6">
                                          <!-- small box -->
                                          <div class="small-box bg-success">
                                             <div class="inner">
                                                   <h3 class="text-center"><i class="far fa-surprise"></i></h3>
                                                   <p>¡Deseas reutilizar esta lista!</p>
                                             </div>
                                             <div class="icon">
                                                   <i class="ion ion-pie-graph"></i>
                                             </div>
                                             <a class="small-box-footer">
                                                <button class="btn btn-success btn-xs" wire:click="reutilizalista">REUTILIZAR <i class="fas fa-arrow-circle-right"></i></button>
                                             </a>
                                          </div>
                                       </div>
                                       <!-- ./col -->
                                       <div class="col-1">
                                          <button class="btn btn-success" wire:click="noaccion"><i class="fas fa-backspace"></i></button>
                                       </div>
                                    </div>
                                    @if ($listar!="")
                                       <div class="row justify-content-center">
                                          <div class="col-lg-6 col-7">
                                             <form wire:submit.prevent='reuti' method="POST">
                                                @csrf
                                                   <div class="input-group mb-2 mr-sm-2">
                                                      <div class="input-group-prepend">
                                                         <div class="input-group-text">Lista</div>
                                                      </div>
                                                      <input type="text" class="form-control" wire:model='listar' name="listar" id="listar" required>
                                                   </div>
                                                   <div class="input-group mb-2 mr-sm-2">
                                                      <div class="input-group-prepend">
                                                         <div class="input-group-text">Inicia</div>
                                                      </div>
                                                      <input type="date" class="form-control" wire:model='inicior' name="inicior" id="inicior" required>
                                                      <span >*Debe ser mayor a la fecha de finalización actual de la lista ({{$listasel->fin}})</span>
                                                   </div>
                                                   <div class="input-group mb-2 mr-sm-2">
                                                      <div class="input-group-prepend">
                                                         <div class="input-group-text">Termina</div>
                                                      </div>
                                                      <input type="date" class="form-control" wire:model='finr' name="finr" id="finr" required>
                                                   </div>
                                                   <button type="submit" class="btn btn-default">Reutilizar</button>
                                             </form>
                                          </div>
                                       </div>
                                    @endif
                                    @break
                                 @case(2)
                                    <div class="row justify-content-center">
                                       <div class="col-lg-5 col-6">

                                          <!-- small box -->
                                          <div class="small-box bg-info">
                                             <div class="inner">
                                                   <h3 class="text-center"><i class="fas fa-hands-helping"></i></h3>
                                                   <p>¡Activar esta lista!</p>
                                             </div>
                                             <div class="icon">
                                                   <i class="ion ion-pie-graph"></i>
                                             </div>
                                             <a class="small-box-footer">
                                                <button class="btn btn-info btn-xs" wire:click="activalista">ACTIVAR <i class="fas fa-arrow-circle-right"></i></button>
                                             </a>
                                          </div>
                                       </div>
                                       <!-- ./col -->
                                       <div class="col-1">
                                          <button class="btn btn-info" wire:click="noaccion"><i class="fas fa-backspace"></i></button>
                                       </div>
                                    </div>
                                    @break
                                 @case(3)
                                    <div class="row justify-content-center">
                                       <div class="col-lg-5 col-6">
                                          <!-- small box -->
                                          <div class="small-box bg-warning">
                                             <div class="inner">
                                                   <h3 class="text-center"><i class="fas fa-cloud-download-alt"></i></h3>
                                                   <p>¡Inactivar esta lista!</p>
                                             </div>
                                             <div class="icon">
                                                   <i class="ion ion-pie-graph"></i>
                                             </div>
                                             <a class="small-box-footer">
                                                <button class="btn btn-warning btn-xs" wire:click='inactivalista'>INACTIVAR <i class="fas fa-arrow-circle-right"></i></button>
                                             </a>
                                          </div>
                                       </div>
                                       <!-- ./col -->
                                       <div class="col-1">
                                          <button class="btn btn-warning" wire:click="noaccion"><i class="fas fa-backspace"></i></button>
                                       </div>
                                    </div>
                                    @break
                                 @case(4)
                                    <div class="row justify-content-center">
                                       <div class="col-lg-5 col-6">
                                          <!-- small box -->
                                          <div class="small-box bg-danger">
                                             <div class="inner">
                                                   <h3 class="text-center"><i class="far fa-trash-alt"></i></h3>
                                                   <h5>¿Estas seguro(a) de eliminar esta Lista?</h5>
                                                   <p>¡ESTA ACCIÓN ES IRREVERSIBLE!</p>
                                             </div>
                                             <div class="icon">
                                                   <i class="ion ion-pie-graph"></i>
                                             </div>
                                             <a class="small-box-footer">
                                                <button class="btn btn-danger btn-xs" wire:click="eliminalista">ELIMINAR <i class="fas fa-arrow-circle-right"></i></button>
                                             </a>
                                          </div>
                                       </div>
                                       <!-- ./col -->
                                       <div class="col-1">
                                          <button class="btn btn-danger" wire:click="noaccion"><i class="fas fa-backspace"></i></button>
                                       </div>
                                    </div>
                                    @break
                              @endswitch
                           <hr>
                        @endif

                     </div>
                     <!-- /.card-header -->
                     <div class="card-body">
                        <div class="row">
                           <div class="col-12 col-sm-5">
                              <table class="table table-bordered table-striped table-responsive">
                                 <thead>
                                    <tr>
                                       <th scope="col"></th>
                                       <th scope="col">Empresa</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($empresas as $empresa)
                                       @if ($empresa->lp != $listasel->id)
                                          <tr>
                                             <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-info btn-xs" wire:click="detalle({{$empresa->id}})" data-toggle="modal" data-target="#empresa">
                                                   <i class="fas fa-plus"></i>
                                                </button>
                                             </td>
                                             <td>{{$empresa->nombre}}</td>
                                          </tr>
                                       @endif
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                           <div class="col-12 col-sm-7">
                              <table class="table table-bordered table-striped table-responsive">
                                 <thead>
                                    <tr>
                                       <th scope="col"></th>
                                       <th scope="col">Empresa</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($empreses as $emprese)
                                          <tr>
                                             <td>
                                                <button type="button" class="btn btn-secondary" wire:click="eliminar({{$emprese->id}})">
                                                   <i class="fas fa-times"></i>
                                                </button>
                                             </td>
                                             <td>{{$emprese->nombre}}</td>
                                          </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <!-- /.card-body -->
                  </div>
               </div>
            @endif
         </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
         @if ($idlista>0)
            <div class="card bg-gradient-secondary">
               <div class="card-header">
                  Seleccione los productos para esta lista
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <div class="row">
                     <div class="col-12 col-sm-6">
                        <table class="table table-bordered table-striped table-responsive">
                           <thead>
                              <tr>
                                 <th scope="col"></th>
                                 <th scope="col">Producto</th>
                                 <th scope="col">Descripción</th>
                                 <th scope="col">Tipo</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($productos as $producto)
                                    <tr>
                                       <td>
                                          <button type="button" class="btn btn-info btn-xs" wire:click="selproduc({{$producto->id}})">
                                             {{$producto->id}}
                                          </button>
                                       </td>
                                       <td>{{$producto->producto}}</td>
                                       <td>{{$producto->descripcion}}</td>
                                       <td>{{$producto->tipo}}</td>
                                    </tr>
                                 @if ($idproduct==$producto->id)
                                    <tr>
                                       <td colspan="4">
                                          @if ($estadoproduc>0)
                                             <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong>{{$producto->producto}}</strong> Ya esta asignado a esta lista.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                             </div>
                                          @else
                                             <form wire:submit.prevent='carga' method="POST" class="form-inline" >
                                                @csrf
                                                   <div class="input-group mb-2 mr-sm-2">
                                                      <div class="input-group-prepend">
                                                         <div class="input-group-text">Alias</div>
                                                      </div>
                                                      <input type="text" class="form-control" wire:model='alias' name="alias" id="alias" required>
                                                   </div>
                                                   <div class="input-group mb-2 mr-sm-2">
                                                      <div class="input-group-prepend">
                                                         <div class="input-group-text">Valor</div>
                                                      </div>
                                                      <input class="form-control" wire:model='valor' name="valor" id="valor" required>
                                                   </div>
                                                   <button type="submit" class="btn btn-default btn-xs">Asignar</button>
                                             </form>
                                          @endif

                                       </td>
                                    </tr>
                                 @endif
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     <div class="col-12 col-sm-6">
                        <table class="table table-bordered table-striped table-responsive">
                           <thead>
                              <tr>
                                 <th scope="col"></th>
                                 <th scope="col">Producto</th>
                                 <th scope="col">alias</th>
                                 <th scope="col">Valor</th>
                                 <th scope="col">Tipo</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($productosels as $productosel)
                                 <tr>
                                    <td>

                                       <button type="button" class="btn btn-danger btn-xs" wire:click="elimproduc({{$productosel->id}})">
                                          <i class="far fa-trash-alt"></i>
                                       </button>
                                    </td>
                                    <td>{{$productosel->producto}}</td>
                                    <td>
                                       <input wire:blur="modalias({{$productosel->id}})"
                                       wire:model="alia" placeholder="{{$productosel->alias}}"/>
                                    </td>
                                    <td>
                                       <input wire:blur="modvalor({{$productosel->id}})"
                                       wire:model="valo" placeholder="{{$productosel->valor}}"/>
                                    </td>
                                    <td>{{$productosel->tipo}}</td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!-- /.card-body -->
            </div>
         @endif
      </div>
   </div>
   <!-- /.card -->
   @if (!empty($empresaagreg))
      <!-- Modal -->
      <div class="modal fade" id="empresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
         <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                  @foreach ($empresaagreg as $empresaagre)
                     {{$empresaagre->nombre}}
                  @endforeach
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @if ($detalles == "" && !empty($listasel))
                  <h4>Puede asignar esta empresa a la lista: <strong class="text-uppercase">{{$listasel->lista}}</strong></h4>
               @endif
               <div>
                  @if (session()->has('actual'))
                        <div class="alert alert-success">
                           {{ session('actual') }}
                        </div>
                  @endif
               </div>
               <div>
                  @if (session()->has('asigno'))
                        <div class="alert alert-success">
                           {{ session('asigno') }}
                        </div>
                  @endif
               </div>
               <div>
                  @if (session()->has('debajo'))
                        <div class="alert alert-success">
                           {{ session('debajo') }}
                        </div>
                  @endif
               </div>
               <div>
                  @if (session()->has('encima'))
                        <div class="alert alert-success">
                           {{ session('encima') }}
                        </div>
                  @endif
               </div>
               <div>
                  @if (session()->has('dentro'))
                        <div class="alert alert-success">
                           {{ session('dentro') }}
                        </div>
                  @endif
               </div>
               <div>
                  @if (session()->has('contiene'))
                        <div class="alert alert-success">
                           {{ session('contiene') }}
                        </div>
                  @endif
               </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               @if ($detalles == "")
                  <button type="button" class="btn btn-info" wire:click="seleccionar({{$idemp}})">
                     Asignar esta lista
                  </button>
               @endif
            </div>
         </div>
         </div>
      </div>
   @endif
</div>

