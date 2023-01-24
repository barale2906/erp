@extends('adminlte::master')
@section('titulo')
    Ver {{ $user->name }}
@endsection
@section('encabezado')
    Detalle del Usuario {{ $user->name}}
@endsection

@section('link')
/userindex
@endsection
@section('modulo')
    PANEL DE CONTROL/DEFINICIÓN DE USUARIOS
@endsection
@section('detallemodulo')
    Página Detalle Usuario
@endsection

@section('body')




        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- /.row -->
                <!-- Main content -->
                <section class="content">
                    <div class="card">
                    <div class="card-header">


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('custom.message')


                        <form action="" method="POST">



                            <div class="container">

                            <h3>Datos Requeridos</h3>

                                <div class="form-group">
                                    <input type="text" class="form-control"
                                    id="name"
                                    placeholder="Nombre"
                                    name="name"
                                    value="{{ old('name', $user->name)}}"
                                    readonly>
                                </div>
                                <div class="form-group">
                                    <input type="email"
                                    class="form-control"
                                    id="slug"
                                    placeholder="email"
                                    name="email"
                                    value="{{ old('email' , $user->email)}}"
                                    readonly>
                                </div>


                                <hr>


                                <h3>Lista de Roles y Empresas</h3>



                                <hr>

                                <a class="btn btn-secondary" href="/userindex"><i class="fas fa-step-backward"></i></a>


                            </div>
                    </form>

                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.content -->

            </div>
        </section>






@endsection
