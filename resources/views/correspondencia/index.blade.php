@extends('adminlte::master')
@section('titulo')
   Gestión de correspondencia
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
   LISTADO DE SOLICITUDES
@endsection

@section('link')
/gestioncorres
@endsection
@section('modulo')
   CORRRESPONDENCIA/GESTIÓN DE CORRESPONDENCIA
@endsection
@section('detallemodulo')
   Listado de Solicitudes
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
         @php
               $control='';
         @endphp
         @include('correspondencia.navegacion')


         <div class="row">
                  <div class="col-12 col-sm-12">
                     <!-- /.row -->
                     <!-- Main content -->
                     <section class="content">
                           <div class="card">
                           <div class="card-header">
                              <h3 class="card-title center">Listado de Solicitudes</h3>
                           </div>
                           <!-- /.card-header -->
                           <div class="card-body">
                              <table id="total" class="table table-bordered table-striped">
                                 <thead>
                                       <tr>
                                          <th colspan="1">Opciones</th>
                                          <th colspan="4">Remitente</th>
                                          <th colspan="3">Destinatario</th>
                                          <th colspan="1">Actividad</th>
                                       </tr>
                                       <tr>
                                          <th></th>
                                          <th scope="col">ID</th>
                                          <th scope="col">Nombre</th>
                                          <th scope="col">Sucursal</th>
                                          <th scope="col">Área</th>
                                          <th scope="col">Destinatario</th>
                                          <th scope="col">Sede/Dirección</th>
                                          <th scope="col">Área/Ciudad</th>
                                          <th scope="col">Descripción</th>
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
@endsection

@section('load_js')
   <script>
      $(function () {
      $("#total").DataTable({

               "serverSide":true,
               "ajax":"{{ url('todos') }}",
               "columns":[
                  {data: 'todos'},
                  {data: 'id'},
                  {data: 'name'},
                  {data: 'nombresucursal'},
                  {data: 'nombrearea'},
                  {data: 'nombredestinatario'},
                  {data: 'nombresede'},
                  {data: 'nombreubicacion'},
                  {data: 'descripcion'},
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
      defer
   </script>
   <script>
      function recibir(r){

         let id = r.id;
         let operador = r.name;

         const params = {
               correspondencia_id: id,
               operador: operador,

         };

         var url= 'recorrido';
         axios.post(url, params).then((response) =>{
               this.mensaje = response.data.nombre;

               id = '',
               operador = '',

               alert(this.mensaje)
         });
      }
   </script>
@endsection
