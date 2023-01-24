@extends('adminlte::master')
@section('titulo')
    Editar Usuario {{ $user->name }}
@endsection
@section('encabezado')
    Editar Usuario
@endsection

@section('link')
/userindex
@endsection
@section('modulo')
    PANEL DE CONTROL/DEFINICIÓN DE USUARIOS
@endsection
@section('detallemodulo')
    Página Edición Usuario
@endsection

@section('body')
   @php

      // Definir variables de control de acceso y operación
      $empresActual = Auth::user()->empresa;
      $idActual = Auth::user()->id;
      $empresaUsu = $user->empresa;
      $idUsu = $user->id;



   @endphp
   @can('haveaccess','modificatodo')
      @php
         $empresActual = $empresaUsu;
         $idUsu = $idActual;

      @endphp
   @endcan
   @if ($empresActual == $empresaUsu)
      <!-- Main content -->
         <section class="content">
               <div class="container-fluid">
                  <div class="row justify-content-center">
                     <div class="col-5">
                           @include('custom.message')
                     </div>

                  </div>
                  <div class="row">
                     <div class="col-md-3">
                              <!-- Profile Image -->
                              <div class="card card-info card-outline">
                                 <div class="card-body box-profile">
                                 <div class="text-center">
                                       <img class="profile-user-img img-fluid img-circle"
                                          src="../{{ $user->foto}}"
                                          alt="{{ $user->name}}">
                                 </div>

                                 <h3 class="profile-username text-center">{{$user->name}}</h3>

                                       <ul class="list-group list-group-unbordered mb-3">
                                          @if (!empty($direactual))
                                          <li class="list-group-item">
                                             <b>Dirección:</b> <a class="float-right">{{ $direactual->direccion }}</a>
                                          </li>
                                          <li class="list-group-item">
                                             <b>Teléfono(s):</b> <a class="float-right">{{ $direactual->telefono }}</a>
                                          </li>
                                          @endif
                                          @if (!empty($adicional))
                                             <li class="list-group-item">
                                                <b>Grupo RH:</b> <a class="float-right">{{ $adicional->sanguineo }}</a>
                                             </li>
                                             <li class="list-group-item">
                                                <b>Fecha de Nacimiento:</b> <a class="float-right">{{ $adicional->nacimiento }}</a>
                                             </li>
                                             <li class="list-group-item">
                                                <b>Correo Electrónico:</b> <a class="float-right">{{ $user->email }}</a>
                                             </li>
                                          @endif
                                          @can('haveaccess','salario.create')
                                             <livewire:usuarios.activar :userid="$user"/>
                                          @endcan
                                          <livewire:usuarios.contrasena :userid="$user"/>
                                       </ul>


                                 </div>
                                 <!-- /.card-body -->
                              </div>
                              <!-- /.card -->
                              @if (!empty($adicional))
                                 <!-- About Me Box -->
                                 <div class="card card-gray">
                                       <div class="card-header">
                                       <h3 class="card-title">Datos Complementarios</h3>
                                       </div>
                                       <!-- /.card-header -->
                                       <div class="card-body">
                                          <strong><i class="fas fa-map-marker-alt mr-1"></i>Ubicación de Correspondencia</strong>
                                          <p class="text-muted">{{ $ubicacion->sucnombre." - ".$ubicacion->area}}</p>
                                          <hr>
                                             @if ($adicional['conductor'] == 1)
                                                   <strong><i class="fas fa-book mr-1"></i> Vehiculo</strong>
                                                   <p class="text-muted">placa del vehiculo</p>
                                                   <hr>
                                             @endif

                                       </div>
                                       <!-- /.card-body -->
                                 </div>
                                 <!-- /.card -->
                              @endif
                              @if (empty($adicional))
                                 <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                       <strong>Holaaa!</strong>  Actualiza tu información dentro del sistema, eso te permitirá navegar sin restricciones.
                                          Dirigete a la pestaña: <strong>Datos básicos</strong>
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                       </button>
                                 </div>
                              @endif
                     </div>
                     <!-- /.col -->
                     @if ($user['estado']!=3)
                           <div class="col-md-9">
                              <div class="card">
                                 <div class="card-header p-2">
                                       <ul class="nav nav-pills">
                                          @if (!empty($adicional))
                                                      <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Soportes</a></li>
                                                      <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Salario - Empresas</a></li>
                                                   @if ($adicional['conductor']== 1)
                                                      <li class="nav-item"><a class="nav-link" href="#pesv" data-toggle="tab">PESV</a></li>
                                                   @endif



                                                      <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Actualizar Datos</a></li>
                                                   @else
                                                   <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Actualizar Datos</a></li>


                                          @endif

                                       </ul>
                                 </div><!-- /.card-header -->
                                 <div class="card-body">
                                       <div class="tab-content">
                                       @if (!empty($adicional))
                                          <div class="active tab-pane" id="activity">
                                          @else
                                          <div class="tab-pane" id="activity">
                                          @endif
                                          <div class="card">
                                             <div class="card-header">
                                                   <h3 class="card-title center">

                                                      @if ($idUsu == $idActual)
                                                         @can('haveaccess','misdatos')
                                                               <form class="form-inline" action="{{ route('soporte.store')}}" method="POST" enctype="multipart/form-data">
                                                                  @csrf

                                                                  <div class="input-group mb-2 mr-sm-2">
                                                                     <div class="input-group-prepend">
                                                                           <div class="input-group-text">Documento</div>
                                                                     </div>
                                                                     <input type="text" class="form-control" id="documento"
                                                                              name="documento" placeholder="documento Nombre" required autofocus>
                                                                  </div>
                                                                  <div class="input-group mb-2 mr-sm-2">
                                                                     <div class="input-group-prepend">
                                                                           <div class="input-group-text">Expedición</div>
                                                                     </div>
                                                                     <input type="date" class="form-control" id="expedicion"
                                                                              name="expedicion"  required >
                                                                  </div>
                                                                  <div class="input-group mb-2 mr-sm-2">
                                                                     <div class="input-group-prepend">
                                                                           <div class="input-group-text">Vencimiento</div>
                                                                     </div>
                                                                     <input type="date" class="form-control" id="vencimiento"
                                                                              name="vencimiento"  required >
                                                                  </div>
                                                                  <div class="input-group mb-2 mr-sm-2">
                                                                     <div class="input-group-prepend">
                                                                           <div class="input-group-text">Cargar</div>
                                                                     </div>
                                                                     <input type="file" class="form-control" id="ruta"
                                                                              name="ruta" required >
                                                                     <input type="hidden" name="username" id="username" value="{{ $user->username}}">
                                                                  </div>

                                                                  <input type="hidden"  name="user_id" id="user_id" value="{{$user->id }}">
                                                                  <input type="hidden"  name="usucarga" id="usucarga" value="{{Auth::user()->id }}">
                                                                  <button type="submit" class="btn btn-default btn-sm">Nuevo</button>
                                                               </form>
                                                         @endcan
                                                      @endif


                                                   </h3>

                                             </div>
                                             <!-- /.card-header -->
                                             <div class="card-body">

                                                   <table class="table table-hover table-bordered">
                                                      <thead>
                                                         <tr>

                                                               <th scope="col">Documento</th>
                                                               <th scope="col">Fecha de Expedición</th>
                                                               <th scope="col">Fecha de Vencimiento</th>
                                                               <th scope="col">Fecha de Carga</th>
                                                               <th colspan="3"></th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>


                                                         @foreach ($soportes as $soporte)
                                                         <tr>

                                                               <td>{{ $soporte->documento}}</td>
                                                               <td>{{ $soporte->expedicion}}</td>
                                                               <td>{{ $soporte->vencimiento}}</td>
                                                               <td>{{ $soporte->created_at}}</td>


                                                               <td>

                                                                  <div class="btn-group" role="group" aria-label="Basic example">


                                                                           <a class="btn btn-info" target="blank" href="../{{ $soporte->ruta }}"><i class="fas fa-search"></i></a>


                                                                     @can('haveaccess','soporte.destroy')
                                                                           <form action="{{ route('soporte.destroy',$soporte->id)}}" method="POST">
                                                                              @csrf
                                                                              @method('DELETE')
                                                                              <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                                           </form>
                                                                     @endcan


                                                                  </div>


                                                               </td>
                                                         </tr>
                                                         @endforeach





                                                      </tbody>
                                                   </table>

                                                   {{ $soportes->links() }}


                                             </div>
                                             <!-- /.card-body -->
                                          </div>
                                          <!-- /.card -->
                                       </div>
                                       <!-- /.tab-pane -->
                                       <div class="tab-pane" id="timeline">
                                          <!-- Default box -->
                                          <div class="card card-gray collapsed-card">
                                             <div class="card-header">
                                                   <h3 class="card-title">Empresas Asignadas</h3>

                                                   <div class="card-tools">
                                                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                         <i class="fas fa-plus"></i></button>
                                                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                      <i class="fas fa-times"></i></button>
                                                   </div>
                                             </div>
                                             <div class="card-body">

                                                   <div class="row">
                                                      <div class="col-lg-12">
                                                         <div class="card">
                                                               <div class="card-header">
                                                                  <h3 class="card-title center">

                                                                     @can('haveaccess','empresa.asigna')
                                                                           <div id="asignaempresa">
                                                                              <form class="form-inline" action="{{ route('empresauser.store')}}" method="POST">
                                                                                 @csrf

                                                                                 <div class="input-group mb-2 mr-sm-2">
                                                                                       <div class="input-group-prepend">
                                                                                          <div class="input-group-text">Empresa</div>
                                                                                       </div>
                                                                                       <select v-model="empresaSeleccionada" @change="cargarSucursales" name="empresa_id" id="empresa_id" class="form-control" required>
                                                                                             <option value="">Seleccione una empresa...</option>
                                                                                          @foreach ($disponibles as $disponible)
                                                                                             <option value="{{$disponible->dispoid}}">{{$disponible->nombre}} </option>
                                                                                          @endforeach
                                                                                       </select>
                                                                                 </div>
                                                                                 <div class="input-group mb-2 mr-sm-2">
                                                                                       <div class="input-group-prepend">
                                                                                          <div class="input-group-text">Sucursal</div>
                                                                                       </div>
                                                                                       <select v-model="sucursalSeleccionada" @change="cargarAreas" name="sucursal_id" id="sucursal_id" class="form-control" required>
                                                                                             <option value="">Seleccione un sucursal...</option>

                                                                                             <option v-for="(sucursal, index) in sucursales" v-bind:value="index">
                                                                                                   @{{ sucursal }}
                                                                                             </option>

                                                                                       </select>
                                                                                 </div>
                                                                                 <div class="input-group mb-2 mr-sm-2">
                                                                                       <div class="input-group-prepend">
                                                                                          <div class="input-group-text">Área</div>
                                                                                       </div>
                                                                                       <select v-model="areaSeleccionada" name="area_id" id="area_id" class="form-control" required>
                                                                                             <option value="">Seleccione un área...</option>
                                                                                             <option v-for="(area, index) in areas" v-bind:value="index">
                                                                                                   @{{ area }}
                                                                                             </option>
                                                                                       </select>
                                                                                 </div>
                                                                                 <div class="input-group mb-2 mr-sm-2">
                                                                                       <div class="input-group-prepend">
                                                                                          <div class="input-group-text">Rol</div>
                                                                                       </div>
                                                                                       <select name="role_id" id="role_id" class="form-control" required>
                                                                                             <option value="">Seleccione un rol...</option>
                                                                                          @foreach ($roles as $rol)
                                                                                             <option value="{{$rol->id}}">{{$rol->name}} </option>
                                                                                          @endforeach
                                                                                       </select>
                                                                                 </div>

                                                                                 <input type="hidden"  name="user_id" id="user_id" value="{{$user->id }}">
                                                                                 <input type="hidden" name="nombre_usuario" id="nombre_usuario" value="{{$user->name}}">
                                                                                 <input type="hidden" name="asignaempresa" id="asignaempresa" value="1">

                                                                                 <button type="submit" class="btn btn-default btn-sm">Asignar</button>
                                                                              </form>
                                                                           </div>
                                                                     @endcan

                                                                  </h3>

                                                               </div>
                                                               <!-- /.card-header -->
                                                               <div class="card-body">
                                                                  <div class="row">
                                                                     @foreach ($empresas as $empresa)
                                                                           <!-- /.col -->
                                                                           <div class="col-md-4">
                                                                              @if ($user->empresa == $empresa->emid)
                                                                              <div class="ribbon-wrapper ribbon-xl">
                                                                                 <div class="ribbon bg-warning text-lg">
                                                                                 ¡ESTAS AQUÍ!
                                                                                 </div>
                                                                              </div>
                                                                              @endif

                                                                              <!-- Widget: user widget style 1 -->
                                                                              <div class="card card-widget widget-user">
                                                                                 <!-- Add the bg color to the header using any of the bg-* classes -->

                                                                                 <div class="widget-user-header bg-info">


                                                                                       @if ($idActual == $idUsu)
                                                                                       <form  action="{{ route('user.update', $user->id)}}" method="POST">
                                                                                          @csrf
                                                                                          @method('PUT')
                                                                                          <input type="hidden" name="empresa" id="empresa" value="{{ $empresa->emid}}">
                                                                                          <input type="hidden" name="nombremp" id="nombremp" value="{{ $empresa->emnombre}}">
                                                                                          <input type="hidden" name="role_id" id="role_id" value="{{ $empresa->rolid}}">
                                                                                          <input type="hidden" name="sucursal" id="sucursal" value="2">

                                                                                          <button class="widget-user-username btn-info" ><h3 >{{ $empresa->emnombre}}</h3></button>
                                                                                       </form>
                                                                                       @else
                                                                                          <button class="widget-user-username btn-info" ><h3 >{{ $empresa->emnombre}}</h3></button>
                                                                                       @endif





                                                                                 </div>
                                                                                 <div class="widget-user-image">
                                                                                       <img class="img-circle elevation-2" src="../{{ $empresa->logo}}" alt="User Avatar">
                                                                                 </div>

                                                                                 <div class="card-footer">
                                                                                       <div class="row">
                                                                                       <div class="col-sm-4 border-right">
                                                                                          <div class="description-block">
                                                                                          <h5 class="description-header">{{ $empresa->name}}</h5>
                                                                                          <span class="description-text">rol</span>
                                                                                          </div>
                                                                                          <!-- /.description-block -->
                                                                                       </div>
                                                                                       <!-- /.col -->
                                                                                       <div class="col-sm-4 border-right">
                                                                                          <div class="description-block">
                                                                                          <h5 class="description-header">{{ $empresa->sucnombre}}</h5>
                                                                                          <span class="description-text">sucursal</span>
                                                                                          </div>
                                                                                          <!-- /.description-block -->
                                                                                       </div>
                                                                                       <!-- /.col -->
                                                                                       <div class="col-sm-4">
                                                                                          <div class="description-block">
                                                                                          <h5 class="description-header">{{ $empresa->area}}</h5>
                                                                                          <span class="description-text">área</span>
                                                                                          </div>
                                                                                          <!-- /.description-block -->
                                                                                       </div>
                                                                                       <!-- /.col -->
                                                                                       </div>
                                                                                       <!-- /.row -->
                                                                                 </div>
                                                                              </div>
                                                                              <!-- /.widget-user -->
                                                                           </div>
                                                                     @endforeach


                                                                  </div>
                                                               </div>
                                                               <!-- /.card-body -->
                                                         </div>
                                                         <!-- /.card -->
                                                      </div>

                                                   </div>
                                             </div>
                                             <!-- /.card-body -->
                                             <div class="card-footer">

                                             </div>
                                             <!-- /.card-footer-->
                                          </div>
                                          <!-- /.card -->
                                          <!-- Default box -->
                                          <div class="card card-olive collapsed-card">
                                             <div class="card-header">
                                                   <h3 class="card-title">Salarios</h3>

                                                   <div class="card-tools">
                                                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                         <i class="fas fa-plus"></i></button>
                                                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                      <i class="fas fa-times"></i></button>
                                                   </div>
                                             </div>
                                             <div class="card-body">

                                                   <div class="row">
                                                      <div class="col-lg-12">
                                                         <div class="card">
                                                               <div class="card-header">
                                                                  <h3 class="card-title center">

                                                                     @can('haveaccess','salario.create')
                                                                           <form class="form-inline" action="{{ route('salario.store')}}" method="POST">
                                                                              @csrf

                                                                              <div class="input-group mb-2 mr-sm-2">
                                                                                 <div class="input-group-prepend">
                                                                                       <div class="input-group-text">Salario</div>
                                                                                 </div>
                                                                                 <input type="text" class="form-control" id="salario"
                                                                                          name="salario" placeholder="Valor" required autofocus>
                                                                              </div>
                                                                              <div class="input-group mb-2 mr-sm-2">
                                                                                 <div class="input-group-prepend">
                                                                                       <div class="input-group-text">Rodamiento</div>
                                                                                 </div>
                                                                                 <input type="text" class="form-control" id="rodamiento"
                                                                                          name="rodamiento">
                                                                              </div>
                                                                              <div class="input-group mb-2 mr-sm-2">
                                                                                 <div class="input-group-prepend">
                                                                                       <div class="input-group-text">Bono</div>
                                                                                 </div>
                                                                                 <input type="text" class="form-control" id="bono"
                                                                                          name="bono" >
                                                                              </div>
                                                                              <div class="input-group mb-2 mr-sm-2">
                                                                                 <div class="input-group-prepend">
                                                                                       <div class="input-group-text">Comisión</div>
                                                                                 </div>
                                                                                 <input type="text" class="form-control" id="comision"
                                                                                          name="comision"  >
                                                                              </div>

                                                                              <input type="hidden"  name="user_id" id="user_id" value="{{$user->id }}">
                                                                              <button type="submit" class="btn btn-default btn-sm">Nuevo</button>
                                                                           </form>
                                                                     @endcan

                                                                  </h3>

                                                               </div>
                                                               <!-- /.card-header -->
                                                               <div class="card-body">

                                                                  <table class="table table-hover table-bordered">
                                                                     <thead>
                                                                           <tr>

                                                                              <th scope="col">Salario</th>
                                                                              <th scope="col">Rodamiento</th>
                                                                              <th scope="col">Bono</th>
                                                                              <th scope="col">Comisión</th>
                                                                              <th scope="col">estado</th>

                                                                           </tr>
                                                                     </thead>
                                                                     <tbody>


                                                                           @foreach ($salarios as $salario)
                                                                           <tr>

                                                                              <td>{{  number_format($salario['salario'], 0) }}</td>
                                                                              <td>{{ number_format($salario['rodamiento'], 0) }}</td>
                                                                              <td>{{ number_format($salario['bono'], 0) }}</td>
                                                                              <td>{{ $salario->comision}}</td>
                                                                              <td>
                                                                                 @if ($salario->estado == 2)
                                                                                       No vigente
                                                                                 @else
                                                                                       Vigente
                                                                                 @endif
                                                                              </td>
                                                                           </tr>
                                                                           @endforeach
                                                                     </tbody>
                                                                  </table>

                                                                  {{ $salarios->links() }}


                                                               </div>
                                                               <!-- /.card-body -->
                                                         </div>
                                                         <!-- /.card -->
                                                      </div>

                                                   </div>
                                             </div>
                                             <!-- /.card-body -->
                                             <div class="card-footer">

                                             </div>
                                             <!-- /.card-footer-->
                                          </div>
                                          <!-- /.card -->
                                       </div>
                                       <!-- /.tab-pane -->

                                       <!-- /.tab-pane -->
                                       <div class="tab-pane" id="pesv">

                                       </div>
                                       <!-- /.tab-pane -->

                                       <!-- /.tab-pane -->
                                       @if (empty($adicional))
                                          <div class="active tab-pane" id="settings">
                                          @else
                                          <div class="tab-pane" id="settings">
                                          @endif
                                       @if ($idUsu == $idActual)

                                          <!-- Default box -->
                                          <div class="card card-gray">
                                             <div class="card-header">
                                                <h3 class="card-title">Datos Básicos</h3>
                                                <div class="card-tools">
                                                   <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                      <i class="fas fa-plus"></i></button>
                                                   <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                   <i class="fas fa-times"></i></button>
                                                </div>
                                             </div>
                                             <div class="card-body">
                                                   <div class="row">
                                                      <div class="col-lg-12">
                                                         <div class="card">
                                                               <div class="card-body">
                                                                  @can('haveaccess','misdatos')
                                                                     <livewire:usuarios.detalle :userid="$user"/>
                                                                  @endcan
                                                               </div>
                                                               <!-- /.card-header -->
                                                         </div>
                                                         <!-- /.card -->
                                                      </div>
                                                   </div>
                                             </div>
                                             <!-- /.card-body -->
                                             <div class="card-footer">
                                             </div>
                                             <!-- /.card-footer-->
                                          </div>
                                          <!-- /.card -->
                                       @endif
                                          <!-- Default box -->
                                          @if (!empty($adicional))

                                             @can('haveaccess','salario.create')
                                                   <div class="card card-olive collapsed-card">
                                                         <div class="card-header">
                                                               <h3 class="card-title">Datos Internos</h3>

                                                               <div class="card-tools">
                                                                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                                     <i class="fas fa-plus"></i></button>
                                                                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                                  <i class="fas fa-times"></i></button>
                                                               </div>
                                                         </div>
                                                         <div class="card-body">
                                                               <div class="row">
                                                                  <div class="col-lg-12">
                                                                     <div class="card">
                                                                           <div class="card-header">
                                                                              <h3 class="card-title center">
                                                                                 <form class="form-horizontal" action="{{ route('adicionals.update', $user->id)}}" method="POST">
                                                                                       @csrf
                                                                                       @method('PUT')

                                                                                       <hr>
                                                                                       <h5>Datos de Contratación</h5>
                                                                                       <hr>

                                                                                       <div class="form-group row">
                                                                                          <label for="contrato" class="col-sm-5 col-form-label">Contrato</label>
                                                                                          <div class="col-sm-7">
                                                                                          <textarea name="contrato" id="contrato" >{{ $adicional->contrato }}</textarea>

                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="form-group row">
                                                                                          <label for="eps" class="col-sm-5 col-form-label">EPS</label>
                                                                                          <div class="col-sm-7">
                                                                                          <input type="text" name="eps" id="eps" value="{{ $adicional->eps }}" >

                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="form-group row">
                                                                                          <label for="pension" class="col-sm-5 col-form-label">Pensiones</label>
                                                                                          <div class="col-sm-7">
                                                                                          <input type="text" name="pension" id="pension" value="{{ $adicional->pension }}" >

                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="form-group row">
                                                                                          <label for="cesantia" class="col-sm-5 col-form-label">Cesantías</label>
                                                                                          <div class="col-sm-7">
                                                                                          <input type="text" name="cesantia" id="cesantia" value="{{ $adicional->cesantia }}" >

                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="form-group row">
                                                                                          <label for="conductor" class="col-sm-5 col-form-label">Conductor</label>
                                                                                          <div class="col-sm-7">
                                                                                             <div class="custom-control custom-radio custom-control-inline">
                                                                                                   <input type="radio" id="no" name="conductor" class="custom-control-input" value="0"
                                                                                                   @if ($adicional['conductor'] == 0)
                                                                                                      checked
                                                                                                   @endif
                                                                                                   >
                                                                                                   <label class="custom-control-label" for="no">NO</label>
                                                                                             </div>
                                                                                             <div class="custom-control custom-radio custom-control-inline">
                                                                                                   <input type="radio" id="si" name="conductor" class="custom-control-input" value="1"
                                                                                                   @if ($adicional['conductor'] == 1)
                                                                                                      checked
                                                                                                   @endif
                                                                                                   >
                                                                                                   <label class="custom-control-label" for="si">SI</label>
                                                                                             </div>
                                                                                          </div>
                                                                                       </div>

                                                                                       <div class="form-group row">
                                                                                          <label for="runt" class="col-sm-5 col-form-label">N° RUNT</label>
                                                                                          <div class="col-sm-7">
                                                                                          <input type="text" name="runt" id="runt" value="{{ $adicional->runt }}" >

                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="form-group row">
                                                                                          <label for="egreso" class="col-sm-5 col-form-label">Fecha de Retiro</label>
                                                                                          <div class="col-sm-7">
                                                                                          <input type="text" name="egreso" id="egreso" value="{{ $adicional->egreso }}" >

                                                                                          </div>
                                                                                       </div>

                                                                                       <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                                                                       <input type="hidden" name="empresa_id" id="empresa_id" value="{{ $user->empresa}}">
                                                                                       <input type="hidden" name="sucursal_id" id="sucursal_id" value="{{ $ubicacion->sucid }}-{{ $ubicacion->sucnombre}}">
                                                                                       <input type="hidden" name="area_id" id="area_id" value="{{ $ubicacion->areaid}}-{{ $ubicacion->area}}">

                                                                                       <div class="form-group row">
                                                                                       <div class="offset-sm-5 col-sm-7">
                                                                                          <button type="submit" class="btn btn-success">Actualizar</button>
                                                                                       </div>
                                                                                       </div>
                                                                                 </form>
                                                                              </h3>

                                                                           </div>
                                                                           <!-- /.card-header -->

                                                                     </div>
                                                                     <!-- /.card -->
                                                                  </div>

                                                               </div>
                                                         </div>
                                                         <!-- /.card-body -->
                                                         <div class="card-footer">

                                                         </div>
                                                         <!-- /.card-footer-->
                                                   </div>
                                             @endcan

                                          @endif

                                          <!-- /.card -->
                                       </div>
                                       <!-- /.tab-pane -->


                                       </div>
                                       <!-- /.tab-content -->
                                 </div><!-- /.card-body -->
                              </div>
                           <!-- /.nav-tabs-custom -->
                     </div>
                     <!-- /.col -->
                     @else
                           <div class="col-9">
                              <div class="alert alert-danger alert-dismissible" role="alert">
                                 <strong>Upps!</strong>  ¡Este usuario se encuentra inactivo!, si tienes perfil de administrador lo podrás activar de nuevo.
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              @can('haveaccess','salario.create')
                                 <hr>
                                 <h5 class="text text-center">¿Desea Activar de nuevo este usuario?</h5>
                                 <h4 class="text text-center"><i class="fas fa-arrow-circle-left"></i> ¡Dale cambiar de estado!</h4>
                                 <hr>
                              @endcan
                           </div>
                     @endif

                  </div>
                  <!-- /.row -->

               </div>

         </section>
   @else
      <section class="content">
         <div class="container-fluid">
               <div class="alert alert-info alert-dismissible" role="alert">
                  <strong>NO TIENES ACCESO A LOS USUARIOS DE ESTA EMPRESA</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>

         </div>
      </section>
   @endif





@endsection
