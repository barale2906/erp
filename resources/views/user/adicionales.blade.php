<div class="btn-group" role="group" aria-label="Basic example">

   @can('haveaccess','user.show')
      <a class="btn btn-info" href="{{route('user.show', $id)}}"><i class="fas fa-search"></i></a>
   @endcan
   @can('haveaccess','user.edit')
      <a class="btn btn-success" href="{{route('user.edit', $id)}}"><i class="fas fa-user-edit"></i></a>
   @endcan
   @can('haveaccess','user.destroy')

      @if (Auth::user()->id != $id)
      <form action="{{route('user.destroy', $id)}}" method="POST">
         @csrf
         @method('DELETE')
         <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
      </form>
      @endif
   @endcan


</div>
