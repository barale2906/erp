<div>
   @if ($misplanillas->count()>0)
   <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
         <i class="fas fa-list-ol"></i>
      <span class="badge badge-warning navbar-badge">{{$misplanillas->count()}}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">{{$misplanillas->count()}} Planilla(s) asignada(s)</span>
      @foreach ($misplanillas as $mispla)
         <div class="dropdown-divider"></div>
         <a href="/dilitengo" class="dropdown-item">
               <i class="fas fa-envelope mr-2"></i> {{$mispla->nombre}}
               <span class="float-right text-muted text-sm">{{$mispla->fecha}}</span>
         </a>
      @endforeach
   </li>
   @endif
</div>
