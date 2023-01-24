@extends('adminlte::master')
@section('titulo')
   Lista de Usuarios
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   LISTADO DE USUARIOS
@endsection

@section('link')
/userindex
@endsection
@section('modulo')
   PANEL DE CONTROL/DEFINICIÓN DE USUARIOS
@endsection
@section('detallemodulo')
   Usuarios / Página inicial
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

               <!-- /.card-header -->
               <div class="card-body">

                  <table id="usuarios" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th scope="col">ID</th>
                           <th scope="col">Nombre</th>
                           <th scope="col">Email</th>
                           <th></th>

                        </tr>
                     </thead>


                  </table>


               </div>
               <!-- /.card-body -->
               </div>
               <!-- /.card -->
         </section>
         <!-- /.content -->

      </div>
   </section>

@endsection

@section('load_js')

   <script>
      $(function () {
      $("#usuarios").DataTable({

               "serverSide":true,
               "ajax":"{{ url('user') }}",


               "columns":[
                  {data: 'id'},
                  {data: 'name'},
                  {data: 'email'},
                  {data: 'accion'},
               ],
               "language": {
                  "info":"_TOTAL_ registros",
                  "search": "Buscar",
                  "paginate": {
                     "next": "Siguiente",
                     "previous": "Anterior",
                  },
                  "lengthMenu": 'Mostrar <select>'+
                              '<option value="5">5</option>'+
                              '<option value="20">20</option>'+
                              '<option value="50">50</option>'+
                              '<option value="100">100</option>'+
                              '<option value="-1">Todos</option>'+
                              '</select> registros',
                  "loadingRecords": "Cargando...",
                  "processing": "Procesando...",
                  "emptyTable": "La Consulta no Genero registros",
                  "ZeroRecords":"No hay coincidencias",
                  "infoempty": "",
                  "infofiltered": ""

               }



      });

      });
   </script>


@endsection

