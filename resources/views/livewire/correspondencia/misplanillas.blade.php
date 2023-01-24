<div>
   <div class="row justify-content-center">
      <div>
         @if (session()->has('message'))
               <div class="alert alert-success">
                  {{ session('message') }}
               </div>
         @endif
      </div>
      @if ($misplanillas->count()>0)
         @if ($mostrar!=1)
            <div class="col-lg-3 col-6">
               <!-- small box -->
               <div class="small-box bg-warning">
                  <div class="inner">
                     <h3>{{$misplanillas->count()}}</h3>
                     <p>¡Tienes planillas asignadas!</p>
                  </div>
                  <div class="icon">
                     <i class="fas fa-list-ol"></i>
                  </div>
                  <div class="small-box-footer">
                     <button type="button" wire:click="mostrar()"
                        class="btn btn-warning">¡Recíbelas!</button>
                  </div>
               </div>
            </div>
            <!-- ./col -->
         @else
            <div class="col-12">

               <section class="content">
                  <div class="card">
                     <div class="card-header">
                           <h3 class="card-title text-uppercase text-bold text-center text-capitalize">Planillas a su nombre sin recoger
                              <small class="text text-danger">De clic en la planilla para recibir los envíos asignados</small>
                           </h3>
                           <div class="card-tools">
                              <button type="button" wire:click="ocultar()"
                              class="btn btn-default"><i class="fas fa-times"></i></button>
                           </div>
                     </div>
                     <!-- /.card-header -->
                     <div class="card-body">
                           <div class="row justify-content-center">
                              <div class="col-12 col-sm-6">
                                 <table class="table table-bordered table-striped table-responsive">
                                       <thead>
                                          <tr>
                                             <th></th>
                                             <th scope="col">Empresa</th>
                                             <th scope="col">Fecha</th>
                                             <th scope="col">Observaciones</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($misplanillas as $mispla)
                                          <tr>
                                             <td>
                                                   <button type="button" wire:click="detalle({{$mispla->id}})"
                                                   class="btn btn-info btn-xs"><i class="fas fa-search-plus"></i></button>
                                             </td>
                                             <td>{{$mispla->nombre}}</td>
                                             <td>{{$mispla->fecha}}</td>
                                             <td>{{$mispla->observaciones}}</td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                 </table>
                              </div>
                           </div>
                           @if ($detalles->count()>0)
                              <div class="row">
                                 <div class="col-12">
                                       <hr>
                                       <h5>Planilla N° {{$detallenca->id}} con fecha {{$detallenca->fecha}}</h5>
                                       <table class="table table-bordered table-striped table-responsive">
                                          <thead>
                                             <tr>
                                                   <th></th>
                                                   <th scope="col">id</th>
                                                   <th scope="col">Destinatario</th>
                                                   <th scope="col">Dirección</th>
                                                   <th scope="col">Ciudad</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @foreach ($detalles as $deta)
                                             <tr>
                                                   <td>
                                                      <button type="button" wire:click="recibir({{$deta->id}})"
                                                         class="btn btn-success btn-xs"><i class="fas fa-motorcycle"></i></button>
                                                   </td>
                                                   <td>{{$deta->id}}</td>
                                                   <td>{{$deta->nombredestinatario}}</td>
                                                   <td>{{$deta->nombresede}}</td>
                                                   <td>{{$deta->nombreubicacion}}</td>
                                             </tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                 </div>
                              </div>
                           @endif
                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer">
                     </div>
                  </div>
                  <!-- /.card -->
               </section>
            </div>
         @endif
      @endif
      @if ($planimprimir->count()>0)
         <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
               <div class="inner">
                  <h3>{{$planimprimir->count()}}</h3>
                     <table class="table table-striped table-responsive">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th scope="col">Fecha</th>
                              <th scope="col">Empresa</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($planimprimir as $planimp)
                           <tr>
                              <td>
                                    <button type="button" wire:click="imprimir({{$planimp->id}})"
                                    class="btn btn-default btn-xs">{{$planimp->id}}</button>
                              </td>
                              <td>{{$planimp->fecha}}</td>
                              <td>{{$planimp->nombre}}</td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
               </div>
               <div class="icon">
                  <i class="fas fa-list-ol"></i>
               </div>
               <div class="small-box-footer">
                  ¡Haz clic en el ID para generar la planilla!
               </div>
            </div>
         </div>
         <!-- ./col -->
      @endif

   </div>
</div>
