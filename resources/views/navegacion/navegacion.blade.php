<div id="navegacion">
   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light" >
      <!-- Left navbar links -->
      <ul class="navbar-nav">
         <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
               Bienvenido(a) <span class="text-uppercase text-bold">@{{ navegar.nombre  }}</span> al sistema ERP - SEYD.
         </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
         @if (Auth::user()->estado==2)
            @can('haveaccess','diligencia.mensajero')
               <!-- Diligencias mensajero -->
               <livewire:diligencias.mensajero />
            @endcan
            <!-- Asignación de planillas -->
            <livewire:correspondencia.navplanilla />
            <!-- Diligencias en mi poder -->
            <livewire:correspondencia.navvueltas />

         @endif
         <!-- Messages Dropdown Menu -->

         <li class="nav-item">
               <a class="nav-link" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"
                                 data-widget="control-sidebar" data-slide="true"
                                 role="button" >


                     <i class="fas fa-power-off"></i>
               </a>

               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
               </form>
         </li>
      </ul>
   </nav>
   <!-- /.navbar -->
   @if (Auth::user()->estado!=3)
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4" >
         <!-- Brand Logo -->
         <a href="/home" class="brand-link">
            <img :src=  navegar.logo  alt="Somos Envíos y Diligencias S.A.S." class="brand-image img-circle elevation-3"
            style="opacity: .8">
         <span class="brand-text font-weight-light"> </span>
         </a>
         <!-- Sidebar -->
         <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
               <img src="{{ Auth::user()->foto }}" class="img-circle elevation-2" alt="">
               </div>
               <div class="info">
                     <a href="#" class="d-block">{{ Auth::user()->name }}</a>
               </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
                     role="menu" data-accordion="false">
                     @switch(Auth::user()->estado)
                        @case(1)
                           @if (Auth::user()->empresa!=3)
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                    <i class="fas fa-file-signature"></i>
                                    <p>
                                       MI CUENTA
                                       <i class="right fas fa-angle-left"></i>
                                    </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','misdatos')
                                       <li class="nav-item">
                                          <a href="{{route('user.edit', Auth::user()->id)}}" class="nav-link">
                                             <i class="fas fa-id-card-alt"></i>
                                             <p class="text text-teal">Mi Perfil</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endif
                           @break
                        @case(2)
                           @can('haveaccess','user.index')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>
                                       PANEL DE CONTROL
                                       <i class="right fas fa-angle-left"></i>
                                    </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','user.index')
                                       <li class="nav-item">
                                       <a href="/userindex" class="nav-link">
                                          <i class="fas fa-user-edit nav-icon"></i>
                                          <p class="text text-yellow">Definición de Usuarios</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','role.index')
                                       <li class="nav-item">
                                          <a href="{{route('role.index')}}" class="nav-link">
                                             <i class="fas fa-door-open nav-icon"></i>
                                             <p class="text text-yellow">Roles y Permisos</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','empresa.index')
                                       <li class="nav-item">
                                          <a href="{{route('empresa.index')}}" class="nav-link">
                                             <i class="fas fa-industry"></i>
                                             <p class="text text-yellow">Listado de Empresas</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','superadministrador')
                                       <li class="nav-item">
                                          <a href="/paramefes" class="nav-link">
                                             <i class="fas fa-user-edit nav-icon"></i>
                                             <p class="text text-yellow">Festivos</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endcan
                           @can('haveaccess','sucursal')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">

                                 <i class="nav-icon fas fa-industry"></i>
                                 <p>
                                    EMPRESA ACTUAL
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','sucursal')
                                       <li class="nav-item">
                                          <a href="{{route('sucursal')}}" class="nav-link">
                                          <i class="fas fa-door-open nav-icon"></i>
                                          <p class="text text-teal">Sucursales</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','area.index')
                                       <li class="nav-item">
                                          <a href="{{route('areas')}}" class="nav-link">
                                          <i class="fas fa-industry"></i>
                                          <p class="text text-teal">Áreas</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endcan
                           @can('haveaccess','misdatos')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                 <i class="fas fa-file-signature"></i>
                                 <p>
                                    MI CUENTA
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','misdatos')
                                       <li class="nav-item">
                                          <a href="{{route('user.edit', Auth::user()->id)}}" class="nav-link">
                                          <i class="fas fa-id-card-alt"></i>
                                          <p class="text text-yellow">Mi Perfil</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endcan
                           @can('haveaccess','venrifa')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                    <i class="fas fa-person-booth"></i>
                                 <p>
                                    GESTIÓN HUMANA
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','adminhumana')
                                       <li class="nav-item">
                                          <a href="/paramehum" class="nav-link">
                                          <i class="fas fa-id-card-alt"></i>
                                          <p class="text text-yellow">Parámetros</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','adminhumana')
                                       <li class="nav-item">
                                          <a href="/paramehum" class="nav-link">
                                          <i class="fas fa-id-card-alt"></i>
                                          <p class="text text-yellow">Contratación</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','misdatos')
                                       <li class="nav-item">
                                          <a href="{{route('user.edit', Auth::user()->id)}}" class="nav-link">
                                             <i class="fas fa-stamp"></i>
                                          <p class="text text-yellow">Certificados</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                       @can('haveaccess','opehumana')
                                       <li class="nav-item">
                                          <a href="{{route('user.edit', Auth::user()->id)}}" class="nav-link">
                                             <i class="fas fa-user-secret"></i>
                                          <p class="text text-yellow">Dotaciones</p>
                                          </a>
                                       </li>
                                       @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                       @can('haveaccess','opehumana')
                                       <li class="nav-item">
                                          <a href="{{route('user.edit', Auth::user()->id)}}" class="nav-link">
                                             <i class="fas fa-plane-departure"></i>
                                          <p class="text text-yellow">Vacaciones</p>
                                          </a>
                                       </li>
                                       @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                       @can('haveaccess','opehumana')
                                       <li class="nav-item">
                                          <a href="{{route('incapacidad.index')}}" class="nav-link">
                                             <i class="fas fa-crutch"></i>
                                          <p class="text text-yellow">Incapacidades</p>

                                          </a>
                                       </li>
                                       @endcan

                                 </ul>
                              </li>
                           @endcan
                           @can('haveaccess','venrifa')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                       <i class="fas fa-shipping-fast"></i>
                                 <p>
                                       CORRESPONDENCIA
                                       <i class="right fas fa-angle-left"></i>
                                 </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','misdatos')
                                       <li class="nav-item">
                                             <a href="/micorrespondencia" class="nav-link">
                                                <i class="fas fa-truck-loading"></i>
                                             <p class="text text-teal" >Correspondencia</p>
                                             </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','corres.index')
                                       <li class="nav-item">
                                             <a href="/gestioncorres" class="nav-link">
                                                <i class="fas fa-tasks"></i>
                                                <p class="text text-teal">Gestión</p>
                                             </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','auditorcorres')
                                       <li class="nav-item">
                                             <a href="/inditiempos" class="nav-link">
                                                <i class="fas fa-chart-line"></i>
                                                <p class="text text-teal">Control</p>
                                             </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endcan
                           @can('haveaccess','diligencia.list')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                    <i class="fas fa-dolly"></i>
                                 <p>
                                    DILIGENCIAS
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','diligencia.list')
                                       <li class="nav-item">
                                          <a href="{{route('lasmias')}}" class="nav-link">
                                             <i class="fas fa-gift"></i>
                                          <p class="text text-yellow">Mis Diligencias</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','diligencia.gest')
                                       <li class="nav-item">
                                          <a href="{{route('gestiondiligencia')}}" class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                          <p class="text text-yellow">Gestión</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','diligencia.mensajero')
                                       <li class="nav-item">
                                          <a href="{{route('mensajerodili')}}" class="nav-link">
                                             <i class="fas fa-atlas"></i>
                                          <p class="text text-yellow">Mensajero</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endcan
                           @can('haveaccess','audifac')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                 <i class="fas fa-file-invoice-dollar"></i>
                                 <p>
                                    FACTURACIÓN
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','adminfac')
                                       <li class="nav-item">
                                          <a href="/paramefac" class="nav-link">
                                             <i class="fas fa-cogs"></i>
                                          <p class="text text-teal">Configuración</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','coorfac')
                                       <li class="nav-item">
                                          <a href="/factura" class="nav-link">
                                             <i class="fas fa-file-invoice"></i>
                                          <p class="text text-teal">Facturar</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','coorfac')
                                       <li class="nav-item">
                                          <a href="/prepago" class="nav-link">
                                             <i class="fas fa-file-invoice"></i>
                                          <p class="text text-teal">Prepagado</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','audifac')
                                       <li class="nav-item">
                                          <a href="/listafactura" class="nav-link">
                                             <i class="fas fa-list-ol"></i>
                                          <p class="text text-teal">Lista de Facturas</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','coorfac')
                                       <li class="nav-item">
                                          <a href="/cuentacobro" class="nav-link">
                                             <i class="fas fa-file-invoice"></i>
                                          <p class="text text-teal">Cuentas</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','audifac')
                                       <li class="nav-item">
                                          <a href="/paramefac" class="nav-link">
                                             <i class="fas fa-clipboard-list"></i>
                                          <p class="text text-teal">Lista de Cuentas</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','cliefac')
                                       <li class="nav-item">
                                          <a href="/paramefac" class="nav-link">
                                             <i class="fas fa-cogs"></i>
                                          <p class="text text-teal">Modulo de Clientes</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','misdatos')
                                       <li class="nav-item">
                                          <a href="/paramefac" class="nav-link">
                                             <i class="fas fa-cogs"></i>
                                          <p class="text text-teal">Mis Cuentas</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endcan
                           @can('haveaccess','financiero.list')
                              <li class="nav-item has-treeview ">
                                 <a href="#" class="nav-link ">
                                    <i class="fas fa-coins"></i>
                                 <p>
                                    FINANCIERO
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                    @can('haveaccess','financiero.gest')
                                       <li class="nav-item">
                                          <a href="{{route('financiero')}}" class="nav-link">
                                             <i class="fas fa-file-invoice-dollar"></i>
                                          <p class="text text-yellow">Productos Financieros</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','financiero.list')
                                       <li class="nav-item">
                                          <a href="{{route('efectivo')}}" class="nav-link">
                                             <i class="fas fa-money-bill-wave"></i>
                                          <p class="text text-yellow">Efectivo</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','financiero.gest')
                                       <li class="nav-item">
                                          <a href="{{route('movimiento')}}" class="nav-link">
                                             <i class="fas fa-chart-line"></i>
                                          <p class="text text-yellow">Movimientos Financieros</p>
                                          </a>
                                       </li>
                                    @endcan
                                    @can('haveaccess','financiero.gest')
                                       <li class="nav-item">
                                          <a href="{{route('obligaciones')}}" class="nav-link">
                                             <i class="fas fa-hand-holding-usd"></i>
                                          <p class="text text-yellow">Gestión de Obligaciones</p>
                                          </a>
                                       </li>
                                    @endcan
                                 </ul>
                              </li>
                           @endcan
                           @break
                     @endswitch
               </ul>
            </nav>
            <!-- /.sidebar-menu -->
         </div>
         <!-- /.sidebar -->
      </aside>
   @endif
</div>
