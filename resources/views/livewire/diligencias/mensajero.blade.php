<div>
   @if ($cantidad>0)
      <li class="nav-item dropdown">
         <a class="nav-link" data-toggle="dropdown" href="#" >
            <i class="fas fa-dolly"></i>
         <span class="badge badge-success navbar-badge">{{$cantidad}}</span>
         </a>
         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <span class="dropdown-item dropdown-header">{{$cantidad}} Diligencia(s) asignada(s)</span>
         <div class="dropdown-divider"></div>
            <a href="{{route('mensajerodili')}}" class="dropdown-item">
               <i class="fas fa-dolly"></i> ¡¡Ir a Verlas!!
                  <span class="float-right text-muted text-sm">{{$cantidad}}</span>
            </a>
      </li>
   @endif
</div>
