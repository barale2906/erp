<div class="btn-group" role="group" aria-label="Basic example">
    @can('haveaccess','misdatos')
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-danger" data-toggle="modal"
                onclick=eliminar(this) id="{{$id}}">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    @endcan
</div>

