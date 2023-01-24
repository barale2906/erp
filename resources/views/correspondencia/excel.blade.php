<!-- Modal -->
<div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Cargar Envíos desde Excel</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div id="externoform">

                  <form class="form-inline" action="{{ route('importarcorres')}}" method="POST" enctype="multipart/form-data">
                     @csrf

                           <div class="modal-body">

                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                       <div class="input-group-text">Archivo</div>
                                 </div>
                                 <input type="file" class="form-control" name="excel" id="excel" required autofocus>
                              </div>

                              @can('haveaccess','misdatos')
                                 <button type="submit" class="btn btn-success mb-2"><i class="far fa-plus-square"></i></button>
                              @endcan

                  </form>

                           </div>
                           <div class="modal-footer">
                              <a href="../soportes/correspondencia.xlsx">Descargar plantilla</a>
                           </div>

               </div>

      </div>
   </div>
</div>

