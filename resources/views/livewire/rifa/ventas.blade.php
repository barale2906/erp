<div class="row justify-content-center">
   <div class="row">
      <div class="card-group">
         @foreach ($rifas as $rifa)
            <div class="card mb-3" style="max-width: 540px;">
               <div class="row no-gutters">
                  <div class="col-md-4">
                  <img src="{{Auth::user()->foto}}" class="card-img" alt="...">
                  </div>
                  <div class="col-md-8">
                     <div class="card-body">
                     <h5 class="card-title">
                        <button type="button" class="btn btn-default" wire:click="seleccionar({{$rifa->id}})">
                           {{$rifa->fecha}}
                        </button>
                     </h5>
                     <p class="card-text">{{$rifa->premio}}</p>
                     <p class="card-text"><small class="text-muted">{{number_format($rifa->valor, 2)}}</small></p>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
      @if ($idrifa)
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th></th>
                  <th scope="col">Boleta</th>
               <th scope="col">Números</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($boletasel as $boletase)
                  <tr>
                     <td></td>
                     <td>{{$boletase->idboleta}}</td>
                     <td>{{$boletase->numero}}</td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      @endif

   </div>
</div>
