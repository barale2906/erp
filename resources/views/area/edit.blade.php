@extends('adminlte::master')
@section('titulo')
   {{ $area->area }}
@endsection
@section('encabezado')
    EDITAR  {{ $area->area }}
@endsection

@section('link')
/areas
@endsection
@section('modulo')
    EMPRESA ACTUAL/AREAS
@endsection
@section('detallemodulo')
    Página Edición Areas
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

                <form action="{{ route('area.update', $area->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="container">



                        <div class="form-group">
                            <label for="nombre">ÁREA</label>
                            <input type="text" class="form-control"
                            id="area"
                            placeholder="Área"
                            name="area"
                            value="{{ old('area', $area->area)}}"
                            required
                            autofocus
                            >
                        </div>

                        <a class="btn btn-secondary" href="{{route('areas')}}"><i class="fas fa-step-backward"></i></a>
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
