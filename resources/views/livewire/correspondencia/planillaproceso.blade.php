<div>
   @can('haveaccess','configcorres')
      @php
         $total=2;
      @endphp
   @endcan
   @can('haveaccess','configcorresuper')
      @php
         $total=1;
      @endphp
   @endcan
   <div class="col-12">
      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
         <div class="card">
               <div class="card-header">
                  <h3 class="card-title text-uppercase text-bold text-center text-capitalize">Ver Planillas</h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                           @if ($total==1)
                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                       <div class="input-group-text">Elegir Empresa</div>
                                 </div>
                                 <select wire:model='empr' name="empr[]" class="custom-select" multiple size="2">
                                       @foreach ($empresas as $empresa)
                                             <option value="{{$empresa->id}}">{{ $empresa->nombre}}</option>
                                       @endforeach
                                 </select>
                              </div>
                              <hr>
                           @else
                              <input wire:model='empr' name="empr[]" type="hidden" value="{{Auth::user()->empresa}}">
                           @endif
                           <div class="row justify-content-center">
                                 @if ($planillas->count()>0)
                                    <table class="table table-bordered table-striped table-responsive">
                                       <thead>
                                          <tr>
                                             <th scope="col">ID</th>
                                             <th scope="col">Empresa</th>
                                             <th scope="col">Fecha</th>
                                             <th scope="col">Operador</th>
                                             <th scope="col">Ruta</th>
                                             <th scope="col">Observaciones</th>
                                             <th scope="col">Estado</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($planillas as $planilla)
                                          <tr>
                                             <td>
                                                <button wire:click="editar({{$planilla->id}})">{{$planilla->id}}</button>
                                             </td>
                                             <td>{{$planilla->nombre}}</td>
                                             <td>{{$planilla->fecha}}</td>
                                             <td>{{$planilla->name}}</td>
                                             <td>{{$planilla->ruta}}</td>
                                             <td>{{$planilla->observaciones}}</td>
                                             <td>
                                                @switch($planilla->estado)
                                                   @case(1)
                                                      CONSTRUCCIÓN
                                                      @break
                                                   @case(2)
                                                      RECORRIDO
                                                      @break
                                                   @case(3)
                                                      CERRADA
                                                      @break
                                                @endswitch
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                    {{$planillas->links()}}
                                 @else
                                    Seleciona una empresa.
                                 @endif
                           </div>
                  <hr>

                  <hr>
               </div>
               <!-- /.card-body -->
               <div class="card-footer">

               </div>
         </div>
         <!-- /.card -->
      </section>
      <!-- /.content -->
   </div>
</div>
