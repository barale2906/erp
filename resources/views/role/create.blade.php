@extends('adminlte::master')
@section('titulo')
    Crear Rol
@endsection
@section('encabezado')
CREAR NUEVO ROL
@endsection


@section('link')
/role
@endsection
@section('modulo')
    PANEL DE CONTROL/DEFINICIÓN DE ROLES
@endsection
@section('detallemodulo')
    Página Creación Rol
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


                <form action="{{ route('role.store')}}" method="POST">
                    @csrf

                    <div class="container">

                    <h3>Datos Requeridos</h3>

                        <div class="form-group">
                            <input type="text" class="form-control"
                            id="name"
                            placeholder="Nombre"
                            name="name"
                            value="{{ old('name')}}"
                            autofocus
                            >
                        </div>
                        <div class="form-group">
                            <input type="text"
                            class="form-control"
                            id="slug"
                            placeholder="Slug"
                            name="slug"
                            value="{{ old('slug')}}"
                            >
                        </div>

                        <div class="form-group">

                        <textarea class="form-control" placeholder="Descripción" name="description" id="description" rows="3">
                            {{ old('description')}}
                        </textarea>
                        </div>

                        <hr>

                        <h3>Acceso Total</h3>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="fullaccessyes" name="full-access" class="custom-control-input" value="yes"
                                @if (old('full-access')=="yes")
                                    checked
                                @endif
                                >
                                <label class="custom-control-label" for="fullaccessyes">Si</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="fullaccessno" name="full-access" class="custom-control-input" value="no"
                                @if (old('full-access')=="no")
                                    checked
                                @endif
                                @if (old('full-access')===null)
                                    checked
                                @endif

                                >
                                <label class="custom-control-label" for="fullaccessno">No</label>
                            </div>

                        <hr>


                        <h3>Lista de Permisos</h3>


                        @foreach($permissions as $permission)


                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                            class="custom-control-input"
                            id="permission_{{$permission->id}}"
                            value="{{$permission->id}}"
                            name="permission[]"

                            @if( is_array(old('permission')) && in_array("$permission->id", old('permission'))    )
                            checked
                            @endif
                            >
                            <label class="custom-control-label"
                                for="permission_{{$permission->id}}">
                                {{ $permission->id }}
                                -
                                {{ $permission->name }}
                                <em>( {{ $permission->description }} )</em>

                            </label>
                        </div>


                        @endforeach
                        <hr>
                        <a class="btn btn-secondary" href="{{route('role.index')}}"><i class="fas fa-step-backward"></i></a>
                        <input class="btn btn-info" type="submit" value="Guardar">

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
