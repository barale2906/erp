@extends('adminlte::master')
@section('titulo')
    Editar Empresa {{ $empresa->nombre }}
@endsection
@section('encabezado')
    EDITAR EMPRESA {{ $empresa->nombre }}
@endsection

@section('link')
/empresa
@endsection
@section('modulo')
    PANEL DE CONTROL/DEFINICIÓN DE EMPRESAS
@endsection
@section('detallemodulo')
   Página Edición Empresa
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
                    <div class="row justify-content-center">
                        <div class="col-5">
                            @include('custom.message')
                        </div>

                    </div>
                    <form action="{{ route('empresa.update', $empresa->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="container">
                            <hr>
                            <h3>Cargar Logo</h3>
                            <div class="form-group">
                                <label for="logo">Cargar Logo</label>
                                <input type="file" name="logo" id="logo" >
                            </div>

                            <input class="btn btn-info" type="submit" value="Cargar Logo">
                            <hr>
                        </div>

                    </form>


                <form action="{{ route('empresa.update', $empresa->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="container">


                        <h3>Datos Requeridos</h3>

                        <div class="form-group">
                            <label for="nit">NIT</label>
                            <input type="text" class="form-control"
                            id="nit"
                            placeholder="NIT"
                            name="nit"
                            value="{{ $empresa->nit}}"
                            readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text"
                            class="form-control"
                            id="nombre"
                            placeholder="nombre"
                            name="nombre"
                            value="{{ old('nombre' , $empresa->nombre)}}"
                            autofocus
                            >
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección Principal</label>
                            <textarea class="form-control" placeholder="Dirección" name="direccion" id="direccion" rows="3">{{$empresa->direccion}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control"
                            id="telefono"
                            placeholder="telefono"
                            name="telefono"
                            value="{{ old('telefono', $empresa->telefono)}}"

                            >
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control"
                            id="email"
                            placeholder="email"
                            name="email"
                            value="{{ old('email', $empresa->email)}}"

                            >
                        </div>



                        <hr>
                        <h3>Datos de conexion</h3>
                        <div class="form-group">
                            <input type="text" class="form-control"
                            id="bd"
                            placeholder="Base de Datos"
                            name="bd"
                            value="{{ old('bd', $empresa->bd)}}"

                            >
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control"
                            id="usubd"
                            placeholder="Usuario Base de Datos"
                            name="usubd"
                            value="{{ old('usubd', $empresa->usubd)}}"

                            >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"
                            id="contrabd"
                            placeholder="Contraseña Base de Datos"
                            name="contrabd"
                            value="{{ old('contrabd', $empresa->contrabd)}}"

                            >
                        </div>

                        <hr>




                        <h3>Lista de Modulos</h3>


                        <hr>
                        <a class="btn btn-secondary" href="{{route('empresa.index')}}"><i class="fas fa-step-backward"></i></a>
                        <input class="btn btn-success" type="submit" value="Actualizar">

                    </div>

                </form>
                <hr>
                <form  action="{{ route('user.update', Auth::user()->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="empresa" id="empresa" value="{{ $empresa->id}}">
                    <input type="hidden" name="nombremp" id="nombremp" value="{{ $empresa->nombre}}">
                    <input type="hidden" name="empresactual" id="empresactual" value="{{ Auth::user()->empresa }}">
                    <input type="hidden" name="name" id="name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="sucursal" id="sucursal" value="1">
                    <input type="hidden" name="sucurnom" id="sucurnom" value="{{ $sucursales->nombre }}">
                    <input type="hidden" name="sucurid" id="sucurid" value="{{ $sucursales->id }}">
                    <input type="hidden" name="areanom" id="areanom" value="{{ $areas->area }}">
                    <input type="hidden" name="areaid" id="areaid" value="{{ $areas->id }}">


                    <button class="btn-info btn-sm" >Asignar sucursales y áreas <small>Cambiara a Empresa Actual</small></button>
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
