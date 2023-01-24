<div class="row justify-content-center">
   <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
      @if ($control!=2)
         @can('haveaccess','generaguias')
               <div class="col-12 col-sm-2">
                  <div class="info-box">
                     <span class="info-box-icon bg-teal elevation-1"><i class="fas fa-chalkboard"></i></span>
                     <div class="info-box-content">
                           <span class="info-box-text text-capitalize">Generar Guías</span>
                              <span class="info-box-number">
                                 Ver
                              </span>
                     </div>
                     <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
               </div>
         @endcan
      @endif
      @can('haveaccess','configcorres')
         @if ($control!=1)
            <div class="col-12 col-sm-2">
                  <div class="info-box">
                     <span class="info-box-icon bg-success elevation-1"><i class="fas fa-motorcycle"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text text-capitalize">Estado Envíos</span>
                              <span class="info-box-number">
                                 <form action="{{route('recorrido.show', Auth::user()->id)}}" method="GET">
                                    <input type="hidden" id="id" name="id" value="{{Auth::user()->id}}">
                                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                 </form>
                              </span>
                     </div>
                     <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
            </div>
         @endif
         @if ($control!=3)
               <div class="col-12 col-sm-2">
                  <div class="info-box">
                     <span class="info-box-icon bg-info elevation-1"><i class="far fa-paper-plane"></i></span>
                     <div class="info-box-content">
                           <span class="info-box-text text-capitalize">Envio fuera ciudad</span>

                              <span class="info-box-number">
                              <a href="/ciudadfuera">Enrutar</a>
                              </span>


                     </div>
                     <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
               </div>
         @endif
         @if ($control!=4)
               <div class="col-12 col-sm-2">
                  <div class="info-box">
                     <span class="info-box-icon bg-transparent elevation-1"><i class="fas fa-search-location"></i></span>
                     <div class="info-box-content">
                           <span class="info-box-text text-capitalize">Puntos Fijos</span>

                              <span class="info-box-number">
                                 Ver
                              </span>


                     </div>
                     <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
               </div>
         @endif
         @if ($control!=5)
               <div class="col-12 col-sm-2">
                  <div class="info-box">
                           <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-route"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text text-capitalize">Definir Recorrido</span>

                                 <span class="info-box-number">
                                       <a href="/recorridorden">Organizar</a>
                                 </span>
                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
               </div>
         @endif
         @if ($control!=6)
               <div class="col-12 col-sm-2">
                  <div class="info-box">
                           <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cogs"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text text-capitalize">Parámetros</span>

                                 <span class="info-box-number">
                                    <a href="/parametros">Configurar</a>
                                 </span>


                           </div>
                           <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
               </div>
         @endif

      @endcan

      </div>
   </nav>
</div>
