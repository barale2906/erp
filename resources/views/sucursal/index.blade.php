@extends('adminlte::master')
@section('titulo')
    Lista de Sucursales
@endsection
@section('encabezado')
    LISTADO DE SUCURSALES
@endsection

@section('link')
/sucursal
@endsection
@section('modulo')
    EMPRESA ACTUAL/SUCURSALES
@endsection
@section('detallemodulo')
    Sucursales / Página inicial
@endsection

@section('body')


  <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-5">
                    @include('custom.message')
                </div>

            </div>


            <!-- /.row -->
            <!-- Main content -->
            <section class="content">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title center">

                        @can('haveaccess','sucursale.create')
                            <form class="form-inline" action="{{ route('sucursale.store')}}" method="POST">
                                @csrf

                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Nombre</div>
                                    </div>
                                    <input type="text" class="form-control" id="nombre"
                                            name="nombre" placeholder="Sucursal Nombre" required autofocus>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Dirección</div>
                                    </div>
                                    <input type="text" class="form-control" id="direccion"
                                            name="direccion" placeholder="Dirección" required>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Ciudad</div>
                                    </div>

                                    <select  id="ciudad_id" name="ciudad_id" class="form-control" required>
                                            <option value="">Seleccione una ciudad...</option>
                                        @foreach ($ciudades as $ciudad)
                                            <option value="{{$ciudad->id}}">{{$ciudad->ciudad}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden"  name="empresa_id" id="empresa_id" value="{{Auth::user()->empresa }}">
                                <button type="submit" class="btn btn-default btn-sm">Nueva</button>
                            </form>
                        @endcan

                    </h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>

                                <th scope="col">Nombre</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Ciudad</th>
                                <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($sucursales as $sucursal)
                            <tr>

                                <td>{{ $sucursal->nombre}}</td>
                                <td>{{ $sucursal->direccion}}</td>
                                <td>{{ $sucursal->ciudad['ciudad']}}</td>

                                <td>

                                    <div class="btn-group" role="group" aria-label="Basic example">


                                        @can('haveaccess','sucursale.edit')
                                            <a class="btn btn-success" href="{{ route('sucursale.edit',$sucursal->id)}}"><i class="fas fa-highlighter"></i></a>

                                            <form action="{{ route('sucursale.update', $sucursal->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')


                                                @if ($sucursal['estado']==1)
                                                    <input type="hidden" name="estado" id="estado" value="2">
                                                    <button class="btn btn-danger"><i class="fas fa-redo"></i> <small> Inactivar</small></button>
                                                @else
                                                    <input type="hidden" name="estado" id="estado" value="1">
                                                    <button class="btn btn-warning"><i class="fas fa-redo"></i><small> Activar</small></button>
                                                @endif

                                            </form>
                                        @endcan


                                    </div>


                                </td>
                            </tr>
                            @endforeach





                        </tbody>
                    </table>

                {{ $sucursales->links() }}


                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->

        </div>
    </section>

@endsection

