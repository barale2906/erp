<div class="btn-group" role="group" aria-label="Basic example">
   @can('haveaccess','misdatos')
      @if ($estado!=6)
         <button type="button" class="btn btn-warning" data-toggle="modal"
               onclick=cerrar(this) id="{{$id}}" name="{{Auth::user()->id}}">
               <i class="fas fa-door-closed"></i>
         </button>
      @endif
      <a class="btn btn-info" href="{{route('corres.edit', $id)}}"><i class="fas fa-search-plus"></i></a>
   @endcan
</div>
