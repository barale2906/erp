@extends('adminlte::master')
@section('titulo')
   {{ $sucursale->nombre }}
@endsection
@section('encabezado')
    EDITAR  {{ $sucursale->nombre }}
@endsection

@section('link')
/sucursal
@endsection
@section('modulo')
    EMPRESA ACTUAL/SUCURSALES
@endsection
@section('detallemodulo')
    Página Edición Sucursales
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

                <form action="{{ route('sucursale.update', $sucursale->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="container">



                        <div class="form-group">
                            <label for="nombre">NOMBRE</label>
                            <input type="text" class="form-control"
                            id="nombre"
                            placeholder="Nombre"
                            name="nombre"
                            value="{{ old('nombre', $sucursale->nombre)}}"
                            required
                            autofocus
                            >
                        </div>

                        <div class="form-group">
                            <label for="direccion">DIRECCIÓN</label>
                            <textarea class="form-control" placeholder="Dirección"
                            name="direccion" id="direccion" rows="3" required>{{old('direccion', $sucursale->direccion)}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="ciudad">CIUDAD</label>
                            <input type="text" class="form-control"
                            id="ciudad_id"
                            placeholder="Ciudad"
                            name="ciudad_id"
                            value="{{ old('ciudad_id', $sucursale->ciudad['ciudad'])}}"
                            required
                            >
                        </div>



                        <a class="btn btn-secondary" href="{{route('sucursal')}}"><i class="fas fa-step-backward"></i></a>
                        <input class="btn btn-success" type="submit" value="Actualizar">

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
