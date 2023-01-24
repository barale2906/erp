<div class="btn-group" role="group" aria-label="Basic example">
   @can('haveaccess','corres.edit')
      @if ($estado!=6)
         <button type="button" class="btn btn-success" data-toggle="modal"
               onclick=recibir(this) id="{{$id}}" name="{{Auth::user()->id}}">
               <i class="fas fa-motorcycle"></i>
         </button>
      @endif
   @endcan
   @can('haveaccess','misdatos')
      <a class="btn btn-info" href="{{route('corres.edit', $id)}}"><i class="fas fa-search-plus"></i></a>
   @endcan
</div>
