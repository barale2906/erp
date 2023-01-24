<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{csrf_token()}}">

      <title> @yield('titulo')</title>

      @if(! config('adminlte.enabled_laravel_mix'))
               <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
               <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

               @include('adminlte::plugins', ['type' => 'css'])

               @yield('adminlte_css_pre')

               <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

               @yield('adminlte_css')

               <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
         @else
               <link rel="stylesheet" href="{{ mix('css/app.css') }}">
      @endif
      @yield('load_css')
      @yield('meta_tags')

      @if(config('adminlte.use_ico_only'))
               <link rel="shortcut icon" href="{{ asset('logos/900474371.ico') }}" />
      @elseif(config('adminlte.use_full_favicon'))
         <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
         <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
         <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
         <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
         <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
         <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
         <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
         <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
         <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
         <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
         <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
         <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
         <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
         <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
         <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
         <meta name="msapplication-TileColor" content="#ffffff">
         <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
      @endif
      <livewire:styles>
   </head>
   <body class="hold-transition sidebar-mini sidebar-collapse">

      <div class="wrapper">

         @if (Route::has('login'))

                     @auth
                        @include('navegacion.navegacion')
                     @else
                              <div class="alert alert-secondary" role="alert">
                                 <h2 class="text-center">Bienvenido(a) a ERP - SEYD </h2>
                                 <h4 class="text-center">Por favor registrese o inicie sesión</h4>
                              </div>
                     @endauth

               @endif
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">

                  <!-- Content Header (Page header) -->
                  <div class="content-header">
                     <div class="container-fluid">
                           <div class="row mb-2">
                              <div class="col-sm-6">
                                 <h1 class="m-0 text-dark">@yield('encabezado')</h1>
                              </div><!-- /.col -->
                              <div class="col-sm-6">
                                 <ol class="breadcrumb float-sm-right">
                                       <li class="breadcrumb-item"><a href="@yield('link')">@yield('modulo')</a></li>
                                       <li class="breadcrumb-item active">@yield('detallemodulo')</li>
                                 </ol>
                              </div>

                           </div><!-- /.row -->
                     </div><!-- /.container-fluid -->
                  </div>
                  <!-- /.content-header -->

               @yield('body')
         </div>


         <!-- Main Footer -->
         <footer class="main-footer">
               <strong>Copyright &copy; 2020-2026 </strong>
               Todos los derechos reservados. <small>Adecuado de AdminLTE</small>
               <div class="float-right d-none d-sm-inline-block">
               <b>Version</b> 2.0.2
               </div>
         </footer>

      </div>


         @if(! config('adminlte.enabled_laravel_mix'))

               <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
               <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
               <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

         @include('adminlte::plugins', ['type' => 'js'])

               <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

               @yield('adminlte_js')

         @else

               <script src="{{ mix('js/app.js') }}"></script>

         @endif

         <!-- Scripts -->
         <script src="{{ asset('js/app.js') }}" defer></script>

         @yield('load_js')
         <livewire:scripts>

   </body>
</html>
