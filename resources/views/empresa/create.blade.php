@extends('adminlte::master')
@section('titulo')
   Crear Empresa
@endsection
@section('encabezado')
   CREAR NUEVA EMPRESA
@endsection

@section('link')
/empresa
@endsection
@section('modulo')
   PANEL DE CONTROL/DEFINICIÓN DE EMPRESAS
@endsection
@section('detallemodulo')
   Página creación empresa
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


               <form action="{{ route('empresa.store')}}" method="POST">
                  @csrf

               <div class="container">

                  <h3>Datos Requeridos</h3>

                     <div class="form-group">
                           <label for="nit">NIT <small>Sin digito de Verificación</small></label>
                           <input type="text" class="form-control"
                              id="nit"
                              placeholder="NIT"
                              name="nit"
                              value="{{ old('nit')}}"
                              autofocus
                           >
                     </div>
                     <div class="form-group">
                           <label for="nombre">Nombre</label>
                           <input type="text" class="form-control"
                              id="nombre"
                              placeholder="Nombre"
                              name="nombre"
                              value="{{ old('nombre')}}"
                           >
                     </div>
                     <div class="form-group">
                           <label for="direccion">Dirección</label>
                           <textarea class="form-control" placeholder="Dirección" name="direccion" id="direccion" rows="3"></textarea>
                     </div>
                     <div class="form-group">
                        <label for="tipo">Tipo de Empresa</label>
                        <select class="custom-select" id="tipo" name="tipo" aria-label="">
                           <option selected>Seleccione...</option>
                           <option value="Jurídico">Jurídico</option>
                           <option value="Natural">Natural</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="metodopago">Método de Pago</label>
                        <select class="custom-select" id="metodopago" name="metodopago" aria-label="">
                           <option selected>Seleccione...</option>
                           <option value="Efectivo">Efectivo</option>
                           <option value="Transferencia">Transferencia</option>
                        </select>
                     </div>


                     <hr>

                     <h3>Lista de Modulos</h3>

                     <hr>
                           <a class="btn btn-secondary" href="{{route('empresa.index')}}"><i class="fas fa-step-backward"></i></a>
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
