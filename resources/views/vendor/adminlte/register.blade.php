@extends('adminlte::master')
@section('titulo')
    Registrate
@endsection
@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', 'register-page')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
       <div id="registro">
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ $dashboard_url }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
            </div>
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">{{ __('adminlte::adminlte.register_message') }}</p>
                    <form action="{{ $register_url }}" method="post">
                        {{ csrf_field() }}

                        <div class="input-group mb-3">
                            <input v-model="nit"

                                    @blur="getRegistro"
                                    @focus = "div_aparecer= false"

                                type="number" name="nit" id="nit" class="form-control "
                                value="{{ old('nit') }}"
                                   placeholder="NIT Empresa" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-industry"></span>
                                </div>
                            </div>

                            @if ($errors->has('nit'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('nit') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div v-if="div_aparecer" v-bind:class="div_clase_registro">
                            @{{ div_mensajeregistro }}
                         </div>
                         <br v-if="div_aparecer">


                         <div class="input-group mb-3">
                            <input v-model="username"

                            @blur="getUsername"
                            @focus = "div_apauser= false"
                             :disabled = "deshabilitar_username==1" type="number" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                value="{{ old('username') }}"
                                   placeholder="Cédula de Ciudadanía" >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="far fa-id-card"></span>
                                </div>
                            </div>

                            @if ($errors->has('username'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div v-if="div_apauser" v-bind:class="div_clase_username">
                            @{{ div_mensajeusername }}
                         </div>
                         <br v-if="div_apauser">

                        <div class="input-group mb-3">
                            <input :disabled = "deshabilitar_name==1" type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}"
                                   placeholder="{{ __('adminlte::adminlte.full_name') }}" >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>

                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <input v-model="email"

                            @blur="getEmail"
                            @focus = "div_apaemail= false"
                             :disabled = "deshabilitar_email==1" type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}"
                                   placeholder="{{ __('adminlte::adminlte.email') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div v-if="div_apaemail" v-bind:class="div_clase_email">
                            @{{ div_mensajemail }}
                         </div>
                         <br v-if="div_apaemail">
                        <div class="input-group mb-3">
                            <input :disabled = "deshabilitar_password==1"  type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   placeholder="{{ __('adminlte::adminlte.password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <input :disabled = "deshabilitar_password_confirmation==1"  type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                   placeholder="{{ __('adminlte::adminlte.retype_password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </div>
                            @endif
                        </div>


                        <button :disabled = "deshabilitar_boton==1" type="submit" class="btn btn-info btn-block btn-flat">
                            {{ __('adminlte::adminlte.register') }}
                        </button>
                    </form>
                    <p class="mt-2 mb-1">
                        <a href="{{ $login_url }}">
                            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
                        </a>
                    </p>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.register-box -->
       </div>

    </div>
</div>

@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
