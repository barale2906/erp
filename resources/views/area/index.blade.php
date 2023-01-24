@extends('adminlte::master')
@section('titulo')
    Lista de Áreas
@endsection
@section('encabezado')
    LISTADO DE ÁREAS
@endsection

@section('link')
/areas
@endsection
@section('modulo')
    EMPRESA ACTUAL/AREAS
@endsection
@section('detallemodulo')
    Areas / Página Inicial
@endsection

@section('body')

<div class="row justify-content-center">
    <div class="col-6">
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

                            @can('haveaccess','area.create')
                                <form class="form-inline" action="{{ route('area.store')}}" method="POST">
                                    @csrf

                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Área</div>
                                        </div>
                                        <input type="text" class="form-control" id="area"
                                                name="area" placeholder="Área Nombre" required autofocus>
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
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($areas as $area)
                                <tr>

                                    <td>{{ $area->area}}</td>


                                    <td>

                                        <div class="btn-group" role="group" aria-label="Basic example">


                                            @can('haveaccess','area.edit')
                                                <a class="btn btn-success" href="{{ route('area.edit',$area->id)}}"><i class="fas fa-highlighter"></i></a>

                                                <form action="{{ route('area.update', $area->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')


                                                    @if ($area['estado']==1)
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

                        {{ $areas->links() }}


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->

        </div>
    </section>
    </div>
</div>


@endsection

