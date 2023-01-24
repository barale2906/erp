@extends('adminlte::master')
@section('titulo')
   Programar Envíos
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   MIS ENVIOS
@endsection

@section('link')
/misenvios
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

               <!-- Info boxes -->
               <div class="row">
                  <div class="col-12 col-sm-5"></div>

                  <div class="col-12 col-sm-2 ">
                     <div class="info-box mb-3">
                           <span class="info-box-icon bg-success elevation-1"><i class="fas fa-motorcycle"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text">Crear Envío</span>

                              @can('haveaccess','misdatos')
                              <a class="btn btn-secondary" href="/micorrespondencia"><i class="fas fa-fast-backward"></i></a>
                              @endcan

                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
               </div>
               <!-- /.row -->


               <div class="row">
                  <div class="col-12">
                     <div class="card">
                           <div class="card-header p-2">

                              <ul class="nav nav-pills">
                                 <li class="nav-item"><a class="nav-link active" href="#aminombre" data-toggle="tab">PARA MI</a></li>
                                 <li class="nav-item"><a class="nav-link" href="#amiarea" data-toggle="tab">PARA MI AREA</a></li>
                              </ul>
                           </div><!-- /.card-header -->
                           <div class="card-body">
                              <div class="tab-content">
                                 <div class="active tab-pane" id="aminombre">
                                       <div class="card">
                                          <div class="card-header p-2">
                                             <ul class="nav nav-pills">
                                                   <li class="nav-item"><a class="nav-link active" href="#envie" data-toggle="tab">Envíe</a></li>
                                                   <li class="nav-item"><a class="nav-link" href="#meenviaron" data-toggle="tab">Me Enviaron</a></li>
                                             </ul>
                                          </div><!-- /.card-header -->
                                          <div class="card-body">
                                             <div class="tab-content">
                                                   <div class="active tab-pane" id="envie">
                                                      <table id="mias" class="table table-bordered table-striped">
                                                         <thead>
                                                               <tr>
                                                                  <th colspan="1">Opciones</th>
                                                                  <th colspan="2">Destinatario</th>
                                                                  <th colspan="3">Actividad</th>
                                                               </tr>
                                                               <tr>
                                                                  <th></th>
                                                                  <th scope="col">ID</th>
                                                                  <th scope="col">Destinatario</th>
                                                                  <th scope="col">Descripción</th>
                                                                  <th scope="col">Detalle</th>
                                                                  <th scope="col">Observaciones</th>

                                                               </tr>
                                                         </thead>


                                                      </table>
                                                   </div>
                                                   <!-- /.tab-pane -->
                                                   <div class="tab-pane" id="meenviaron">
                                                      <table id="parami" class="table table-bordered table-striped">
                                                         <thead>
                                                               <tr>
                                                                  <th colspan="1">Opciones</th>
                                                                  <th colspan="3">Remitente</th>
                                                                  <th colspan="3">Actividad</th>
                                                               </tr>
                                                               <tr>
                                                                  <th></th>
                                                                  <th scope="col">ID</th>
                                                                  <th scope="col">Nombre</th>
                                                                  <th scope="col">Área</th>
                                                                  <th scope="col">Descripción</th>
                                                                  <th scope="col">Detalle</th>
                                                                  <th scope="col">Observaciones</th>
                                                               </tr>
                                                         </thead>
                                                      </table>
                                                   </div>
                                                   <!-- /.tab-pane -->


                                             </div>
                                             <!-- /.tab-content -->
                                          </div><!-- /.card-body -->
                                       </div>
                                          <!-- /.nav-tabs-custom -->
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane" id="amiarea">
                                       <div class="card">
                                          <div class="card-header p-2">
                                             <ul class="nav nav-pills">
                                                   <li class="nav-item"><a class="nav-link active" href="#enviamos" data-toggle="tab">Enviamos</a></li>
                                                   <li class="nav-item"><a class="nav-link" href="#nosenviaron" data-toggle="tab">Nos Enviaron</a></li>

                                             </ul>
                                          </div><!-- /.card-header -->
                                          <div class="card-body">
                                             <div class="tab-content">
                                                   <div class="active tab-pane" id="enviamos">
                                                      <table id="nuestras" class="table table-bordered table-striped">
                                                         <thead>
                                                               <tr>
                                                                  <th colspan="1">Opciones</th>
                                                                  <th colspan="2">Remitente</th>
                                                                  <th colspan="1">Destinatario</th>
                                                                  <th colspan="3">Actividad</th>
                                                               </tr>
                                                               <tr>
                                                                  <th></th>
                                                                  <th scope="col">ID</th>
                                                                  <th scope="col">Nombre</th>
                                                                  <th scope="col">Destinatario</th>
                                                                  <th scope="col">Descripción</th>
                                                                  <th scope="col">Detalle</th>
                                                                  <th scope="col">Observaciones</th>

                                                               </tr>
                                                         </thead>
                                                      </table>
                                                   </div>
                                                   <!-- /.tab-pane -->
                                                   <div class="tab-pane" id="nosenviaron">
                                                      <table id="paranosotros" class="table table-bordered table-striped">
                                                         <thead>
                                                               <tr>
                                                                  <th colspan="1">Opciones</th>
                                                                  <th colspan="2">Remitente</th>
                                                                  <th colspan="1">Destinatario</th>
                                                                  <th colspan="3">Actividad</th>
                                                               </tr>
                                                               <tr>
                                                                  <th></th>
                                                                  <th scope="col">ID</th>
                                                                  <th scope="col">Nombre</th>
                                                                  <th scope="col">Destinatario</th>
                                                                  <th scope="col">Descripción</th>
                                                                  <th scope="col">Detalle</th>
                                                                  <th scope="col">Observaciones</th>
                                                               </tr>
                                                         </thead>
                                                      </table>
                                                   </div>
                                                   <!-- /.tab-pane -->
                                             </div>
                                             <!-- /.tab-content -->
                                          </div><!-- /.card-body -->
                                       </div>
                                 </div>
                                 <!-- /.tab-pane -->
                              </div>
                              <!-- /.tab-content -->
                           </div><!-- /.card-body -->
                     </div>
                           <!-- /.nav-tabs-custom -->
                  </div>
               </div>
      </div>
   </section>
   </div>

@endsection

@section('load_js')

<script>


   $(function () {
   $("#mias").DataTable({

         "serverSide":true,
         "ajax":"{{ url('mias') }}",


         "columns":[

               {data: 'todos'},
               {data: 'id'},
               {data: 'nombredestinatario'},
               {data: 'descripcion'},
               {data: 'detalle'},
               {data: 'observaciones'},


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
   $("#parami").DataTable({

         "serverSide":true,
         "ajax":"{{ url('parami') }}",


         "columns":[

               {data: 'todos'},
               {data: 'id'},
               {data: 'name'},
               {data: 'nombrearea'},
               {data: 'descripcion'},
               {data: 'detalle'},
               {data: 'observaciones'},


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
   $("#nuestras").DataTable({

         "serverSide":true,
         "ajax":"{{ url('nuestras') }}",


         "columns":[

               {data: 'todos'},
               {data: 'id'},
               {data: 'name'},
               {data: 'nombredestinatario'},
               {data: 'descripcion'},
               {data: 'detalle'},
               {data: 'observaciones'},

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
   $("#paranosotros").DataTable({

         "serverSide":true,
         "ajax":"{{ url('paranosotros') }}",


         "columns":[

               {data: 'todos'},
               {data: 'id'},
               {data: 'name'},
               {data: 'nombredestinatario'},
               {data: 'descripcion'},
               {data: 'detalle'},
               {data: 'observaciones'},
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
   function cerrar(c){

      let id = c.id;
      let url= 'corres/'+id;
      const params = {
         id: id,
         control: 1,
      };

      axios.put(url, params).then((response) =>{
         this.mensaje = response.data.nombre;


         id = '',

         alert(this.mensaje)
      });
   }
</script>

@endsection

