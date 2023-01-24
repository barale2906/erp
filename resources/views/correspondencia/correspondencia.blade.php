@extends('adminlte::master')
@section('titulo')
   Programar Envíos
@endsection
@section('plugins.Datatables', true)

@section('encabezado')

   CREAR ENVIOS
@endsection

@section('link')
/micorrespondencia
@endsection
@section('modulo')
   CORRESPONDENCIA/MI CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Correspondencia
@endsection

@section('body')

<div id="app">
<!-- Main content -->
   <section class="content">

      <div class="container-fluid">
         <div class="row justify-content-center">
               <div class="col-5">
                  @include('custom.message')
               </div>
         </div>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="#"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <!-- Info boxes -->
                  <div class="col-12 col-sm-2">
                     <div class="info-box">
                           <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope-open-text"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text">Mis Diligencias</span>
                              @can('haveaccess','misdatos')
                                 <span class="info-box-number">
                                          <a class="btn btn-secondary" href="/misenvios"><i class="fas fa-search-plus"></i></a>
                                 </span>
                              @endcan
                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
                  <div class="col-12 col-sm-2 ">
                     <div class="info-box">
                           <span class="info-box-icon bg-teal elevation-1"><i class="fas fa-motorcycle"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text">Envío Externo</span>

                              @can('haveaccess','misdatos')
                                 <button type="button" class="btn btn-default" data-toggle="modal" data-target="#externo">
                                       Generar
                                 </button>
                              @endcan

                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
                  <div class="col-12 col-sm-2 ">
                     <div class="info-box">
                           <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-excel"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text">Cargar Envíos</span>

                              @can('haveaccess','misdatos')
                                 <button type="button" class="btn btn-default" data-toggle="modal" data-target="#excel">
                                       Cargar Excel
                                 </button>
                              @endcan

                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
                  @can('haveaccess','corres.index')
                     <div class="col-12 col-sm-2 ">
                        <div class="info-box">
                              <span class="info-box-icon bg-olive elevation-1"><i class="fab fa-phoenix-framework"></i></span>
                              <div class="info-box-content">
                                 <span class="info-box-text">Mis Entregas</span>
                                    <span class="info-box-number">
                                       <a class="btn btn-secondary" href="/misentregas"><i class="fas fa-search-plus"></i></a>
                                    </span>
                              </div>
                              <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                     </div>
                     <!-- /.col -->
                  @endcan
               </div>
            </nav>

               <!-- /.row -->

               <div class="row">
                  <div class="col-12">
                     <div class="info-box">
                           <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-microchip"></i></span>

                           <div class="info-box-content">
                              <span class="info-box-text">Diligencias sin recoger generadas hoy</span>
                              <table id="misenvios" class="table table-responsive table-bordered table-striped">
                                 <thead>
                                       <tr>
                                          <th></th>
                                          <th scope="col">ID</th>
                                          <th scope="col">Destinatario</th>
                                          <th scope="col">Sede/Dirección</th>
                                          <th scope="col">Área/Ciudad</th>
                                          <th scope="col">Horario</th>
                                          <th scope="col">Descripción</th>
                                          <th scope="col">Detalle</th>
                                       </tr>
                                 </thead>

                              </table>

                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                  </div>

               </div>
               <!-- /.row -->

               <div class="row">
                  <div class="col-12 col-sm-6">
                     <!-- /.row -->
                     <!-- Main content -->
                     <section class="content">
                           <div class="card">
                           <div class="card-header">
                              <h3 class="card-title center">Destinatarios Internos</h3>

                           </div>
                           <!-- /.card-header -->
                           <div class="card-body">
                              <table id="internos" class="table table-responsive table-bordered table-striped">
                                 <thead>
                                 <tr>
                                       <th></th>
                                       <th scope="col">Nombre</th>
                                       <th scope="col">Sucursal</th>
                                       <th scope="col">Área</th>

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
                  <div class="col-12 col-sm-6">
                     <!-- /.row -->
                     <!-- Main content -->
                     <section class="content">
                           <div class="card">
                              <div class="card-header">
                                 <h3 class="card-title center">Destinatarios Externos Frecuentes</h3>
                                 @can('haveaccess','misdatos')
                                       <button type="button" class="btn btn-default" data-toggle="modal" data-target="#frecuente">
                                          <i class="far fa-plus-square"></i>
                                       </button>
                                 @endcan
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body">
                                 <table id="frecuentes" class="table table-responsive table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th></th>
                                             <th scope="col">ID</th>
                                             <th scope="col">Destinatario</th>
                                             <th scope="col">Dirección</th>
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
               </div>

      </div>
   </section>
   @include('correspondencia.externo')
   @include('correspondencia.excel')
   @include('correspondencia.interno')
   @include('correspondencia.frecuente')

   </div>

@endsection

@section('load_js')

   <script>


      $(function () {
      $("#misenvios").DataTable({

               "serverSide":true,
               "ajax":"{{ url('miashoy') }}",


               "columns":[

                  {data: 'actividad'},
                  {data: 'id'},
                  {data: 'nombredestinatario'},
                  {data: 'nombresede'},
                  {data: 'nombreubicacion'},
                  {data: 'horario'},
                  {data: 'descripcion'},
                  {data: 'detalle'},


               ],

               "language": {
                  "info":"_TOTAL_ registros",
                  "search": "Buscar",
                  "paginate": {
                     "next": "Siguiente",
                     "previous": "Anterior",
                  },
                  'data-show': 5,
                  "lengthMenu": 'Mostrar <select>'+
                              '<option value="5">5</option>'+
                              '<option value="20">20</option>'+
                              '</select> registros',

                  "loadingRecords": "Cargando...",
                  "processing": "Procesando...",
                  "emptyTable": "No has creado envíos para hoy",
                  "ZeroRecords":"No hay coincidencias",
                  "infoempty": "",
                  "infofiltered": "",


               }



      });

      });
   </script>
   <script>
      $(function () {
      $("#internos").DataTable({

               "serverSide":true,
               "ajax":"{{ url('destinatarios') }}",


               "columns":[

                  {data: 'accion'},
                  {data: 'name'},
                  {data: 'sucursal'},
                  {data: 'area'},

               ],
               "language": {
                  "info":"_TOTAL_ registros",
                  "search": "Buscar",
                  "paginate": {
                     "next": "Siguiente",
                     "previous": "Anterior",
                  },
                  'data-show': 5,
                  "lengthMenu": 'Mostrar <select>'+
                              '<option value="5">5</option>'+
                              '<option value="20">20</option>'+
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
   <script>
      $(function () {
      $("#frecuentes").DataTable({

               "serverSide":true,
               "ajax":"{{ url('frecuentes') }}",


               "columns":[
                  {data: 'elegir'},
                  {data: 'id'},
                  {data: 'destinatario'},
                  {data: 'direccion'},

               ],
               "language": {
                  "info":"_TOTAL_ registros",
                  "search": "Buscar",
                  "paginate": {
                     "next": "Siguiente",
                     "previous": "Anterior",
                  },
                  'data-show': 5,
                  "lengthMenu": 'Mostrar <select>'+
                              '<option value="5">5</option>'+
                              '<option value="20">20</option>'+
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
   <script>
      function obtener(b){

         let id = b.id;

         var url= 'empresauser/'+id;
         axios.get(url).then((response) =>{

               destinatarioi = response.data.empresauser;
               sessionStorage.setItem('destinatario', destinatarioi.user_id);
               sessionStorage.setItem('nombredestinatario', destinatarioi.name);
               sessionStorage.setItem('sede', destinatarioi.sucursal_id);
               sessionStorage.setItem('nombresede', destinatarioi.sucursal);
               sessionStorage.setItem('ubicacion', destinatarioi.area_id);
               sessionStorage.setItem('nombreubicacion', destinatarioi.area);
               sessionStorage.setItem('horario', '');

               $('#interno').modal('show'); // abrir
         });
      }
   </script>
   <script>
      function frecuente(d){

         let id = d.id;

         var url= 'frecuente/'+id;
         axios.get(url).then((response) =>{

               destinatarioi = response.data.frecuente;
               sessionStorage.setItem('destinatario', '');
               sessionStorage.setItem('nombredestinatario', destinatarioi.destinatario);
               sessionStorage.setItem('sede', '');
               sessionStorage.setItem('nombresede', destinatarioi.direccion);
               sessionStorage.setItem('ubicacion', '');
               sessionStorage.setItem('nombreubicacion', destinatarioi.ciudad);
               sessionStorage.setItem('horario', destinatarioi.horario);

               $('#interno').modal('show'); // abrir
         });
      }
   </script>
   <script>
      function eliminar(e){

         let id = e.id;

         var url= 'corres/'+id;
         axios.delete(url).then((response) =>{
               this.mensaje = response.data.nombre;

               alert(this.mensaje)
         });
      }
   </script>

@endsection

