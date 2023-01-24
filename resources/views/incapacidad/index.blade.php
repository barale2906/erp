@extends('adminlte::master')
@section('titulo')
    Lista de Incapacidades
@endsection
@section('encabezado')
    LISTADO DE INCAPACIDADES
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

                        @can('haveaccess','edita.incapacidad')
                        <form class="form-inline" action="{{ route('incapacidad.store')}}" method="POST">
                            @csrf

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Empleado</div>
                                </div>
                                <input type="text" class="form-control" id="usu_id"
                                        name="usu_id" placeholder="Nombre" required autofocus>
                            </div>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Motivo</div>
                                </div>

                                <textarea name="motivo" id="motivo" cols="30" rows="2" required></textarea>
                            </div>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Inicia</div>
                                </div>
                                <input type="date" class="form-control" id="inicia"
                                        name="inicia"  required >
                            </div>


                            <input type="hidden"  name="estado" id="estado" value="1">
                            <input type="hidden"  name="registra_id" id="registra_id" value="{{Auth::user()->id }}">
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

                                <th scope="col">Empleado</th>
                                <th scope="col">Motivo</th>
                                <th scope="col">Fecha Inicio</th>
                                <th scope="col">Fecha Fin</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Pagador</th>
                                <th scope="col">Fecha Pago</th>
                                <th scope="col">Observación</th>
                                <th scope="col">estado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($incapacidads as $incapacidad)
                            <tr>
                                <td>{{ $incapacidad->usu_id}}</td>
                                <td>{{ $incapacidad->motivo}}</td>
                                <td>{{ $incapacidad->inicia}}</td>
                                <td>{{ $incapacidad->finaliza}}</td>
                                <td>{{ $incapacidad->valor}}</td>
                                <td>{{ $incapacidad->paga}}</td>
                                <td>{{ $incapacidad->fechaPago}}</td>
                                <td>{{ $incapacidad->observacion}}</td>
                                <td>

                                    @switch( $incapacidad['estado'] )
                                        @case(1)
                                            ACTIVA
                                            @break
                                        @case(2)
                                            PENDIENTE DE PAGO
                                            @break
                                        @case(3)
                                            CERRADA
                                            @break
                                        @default

                                    @endswitch
                                </td>
                                <td>

                                    <div class="btn-group" role="group" aria-label="Basic example">

                                        @if ($incapacidad['estado']!=3)
                                        @can('haveaccess','edita.incapacidad')
                                            <a class="btn btn-success" href="{{ route('incapacidad.edit',$incapacidad->id)}}"><i class="fas fa-highlighter"></i></a>
                                        @endcan
                                        @endif



                                    </div>


                                </td>
                            </tr>
                            @endforeach





                        </tbody>
                    </table>

                {{ $incapacidads->links() }}


                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->

        </div>
    </section>

@endsection

