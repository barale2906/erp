@extends('adminlte::master')
@section('titulo')
    Lista de Roles
@endsection
@section('encabezado')
    LISTADO DE ROLES
@endsection


@section('link')
/role
@endsection
@section('modulo')
    PANEL DE CONTROL/DEFINICIÓN DE ROLES
@endsection
@section('detallemodulo')
    Roles / Página inicial
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
                                <a href="{{route('role.create')}}" class="btn btn-info float-right" >
                                    Crear
                                </a>
                        @endcan

                    </h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Acceso Total</th>
                                <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $role->id}}</th>
                                <td>{{ $role->name}}</td>
                                <td>{{ $role->slug}}</td>
                                <td>{{ $role->description}}</td>
                                <td>{{ $role['full-access']}}</td>
                                <td>

                                    <div class="btn-group" role="group" aria-label="Basic example">

                                        @can('haveaccess','role.show')
                                            <a class="btn btn-info" href="{{ route('role.show',$role->id)}}"><i class="fas fa-search"></i></a>
                                        @endcan
                                        @can('haveaccess','role.edit')
                                            <a class="btn btn-success" href="{{ route('role.edit',$role->id)}}"><i class="fas fa-user-edit"></i></a>
                                        @endcan
                                        @can('haveaccess','role.destroy')
                                            <form action="{{ route('role.destroy',$role->id)}}" method="POST">
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

                {{ $roles->links() }}


                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->

        </div>
    </section>

@endsection

