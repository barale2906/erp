@extends('adminlte::master')
@section('titulo')
    Lista de Empresas
@endsection
@section('encabezado')
    LISTADO DE EMPRESAS
@endsection

@section('link')
/empresa
@endsection
@section('modulo')
    PANEL DE CONTROL/DEFINICIÓN DE EMPRESAS
@endsection
@section('detallemodulo')
    Empresas / Página inicial
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

                        @can('haveaccess','role.create')
                                <a href="{{route('empresa.create')}}" class="btn btn-info float-right" >
                                    Crear
                                </a>
                        @endcan

                    </h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                            <tr>

                                <th scope="col">Logo</th>
                                <th scope="col">NIT</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Correo Electrónico</th>
                                <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($empresas as $empresa)
                            <tr>

                                <td> <img src=  {{ $empresa->logo}}  alt="Somos Envíos y Diligencias S.A.S." class="img-circle img-fluid brand-image-xs" width="100" height="100"></td>
                                <td>{{ $empresa->nit}}</td>
                                <td>{{ $empresa->nombre}}</td>
                                <td>{{ $empresa->direccion}}</td>
                                <td>{{ $empresa->telefono}}</td>
                                <td>{{ $empresa->email}}</td>
                                <td>

                                    <div class="btn-group" role="group" aria-label="Basic example">


                                        @can('haveaccess','empresa.edit')
                                            @if ($empresa['estado']==1)
                                            <a class="btn btn-success" href="{{ route('empresa.edit',$empresa->id)}}"><i class="fas fa-highlighter"></i></a>
                                            @endif

                                            <form action="{{ route('empresa.update',$empresa->id)}}" method="POST" class="form-inline">
                                                @csrf
                                                @method('PUT')


                                                @if ($empresa['estado']==1)
                                                    <input type="hidden" name="estado" id="estado" value="2">
                                                    <button class="btn btn-danger"><i class="fas fa-redo"></i> Inactivar</button>
                                                @else
                                                    <input type="hidden" name="estado" id="estado" value="1">
                                                    <button class="btn btn-warning"><i class="fas fa-redo"></i> Activar</button>
                                                @endif

                                            </form>
                                        @endcan


                                    </div>


                                </td>
                            </tr>
                            @endforeach





                        </tbody>
                    </table>

                {{ $empresas->links() }}


                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->

        </div>
    </section>

@endsection

