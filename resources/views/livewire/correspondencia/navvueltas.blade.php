<div>
   @if ($dilitengo>0)
      <li class="nav-item dropdown">
         <a class="nav-link" data-toggle="dropdown" href="#" >
            <i class="fas fa-motorcycle"></i>
         <span class="badge badge-success navbar-badge">{{$dilitengo}}</span>
         </a>
         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <span class="dropdown-item dropdown-header">{{$dilitengo}} Diligencia(s) en mi poder</span>
         <div class="dropdown-divider"></div>
            <a href="/dilitengo" class="dropdown-item">
                  <i class="fas fa-motorcycle"></i> ¡¡Ir a Verlas!!
                  <span class="float-right text-muted text-sm">{{$dilitengo}}</span>
            </a>
      </li>
   @endif
</div>
