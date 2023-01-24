@extends('adminlte::master')
@section('titulo')
   Bienvenido(a)
@endsection
@section('encabezado')
   Tablero de Control
@endsection
@section('body')
   <section class="content">
      <div class="container-fluid">
         @if (Auth::user()->empresa==3)
            @if (Auth::user()->estado==1)
               <form class="form-inline" action="{{ route('empresarifa')}}" method="POST">
                  @csrf
                  <input type="hidden"  name="user_id" id="user_id" value="{{Auth::user()->id }}">
                  <button type="submit" class="btn btn-default btn-sm">IR A VENTAS</button>
               </form>
            @endif
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Muestra todas las Rifas</h5>
                  <p class="card-text">De hecho</p>
               </div>
            </div>
         @else
            @switch(Auth::user()->estado)
               @case(1)
                  <div class="row justify-content-center">
                     <div class="col-lg-3 col-6">
                        <div class="card text-white bg-warning">
                           <div class="card-body">
                              <livewire:user.ubicacion />
                           </div>
                        </div>
                     </div>
                     <!-- ./col -->
                  </div>
                  @break
               @case(2)

                  @break
               @case(3)
                  <div class="row justify-content-center">
                     <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                           <div class="inner">
                                 <h3 class="text-center"><i class="fas fa-exclamation-triangle"></i></h3>
                                 <p>¡Tu usuario se encuentra INACTIVO!. Debes Comunicarte con el administrador del sistema.</p>
                           </div>
                           <div class="icon">
                                 <i class="ion ion-pie-graph"></i>
                           </div>
                        </div>
                     </div>
                     <!-- ./col -->
                  </div>
                  @break
            @endswitch
         @endif
      </div>
   </section>
@endsection
