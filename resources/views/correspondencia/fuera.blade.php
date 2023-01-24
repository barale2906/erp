@extends('adminlte::master')
@section('titulo')
    Enrutar envíos fuera
@endsection
@section('plugins.Datatables', true)

@section('encabezado')
    GESTIONAR ENVIOS FUERA DE LA CIUDAD
@endsection

@section('link')
/gestioncorres
@endsection
@section('modulo')
    CORRRESPONDENCIA/GESTIÓN DE CORRESPONDENCIA
@endsection
@section('detallemodulo')
    Envíos fuera de la Ciudad
@endsection

@section('body')
  <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-5">
                    @include('custom.message')
                </div>
            </div>
            @php
                $control=3;
            @endphp
            @include('correspondencia.navegacion')
            <div class="row justify-content-center">
                <div class="col-6">
                    <livewire:correspondencia.transpor />
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6">
                    <livewire:correspondencia.enviar />
                </div>
                <div class="col-12 col-sm-6">
                    <livewire:correspondencia.recibir />
                </div>
            </div>

        </div>
    </section>
@endsection
