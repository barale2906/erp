<?php

namespace App\Http\Controllers\Auth;

use App\Empresa;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Role;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nit' => ['required'],
            'username' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $empresa = Empresa::where('nit',$data['nit'])->first();

        $rol = Role::where('name','Usuario')->first();

        $usuario = User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'empresa' => $empresa->id,
            'password' => Hash::make($data['password']),
        ]);

        $usuarioid = User::where('username', $data['username'])->first();
        // Asignación de rol
        DB::table('role_user')->insert([
            'role_id' => $rol->id,
            'user_id' => $usuarioid->id,

        ]);
            // Asignación de Empresa - rol
        DB::table('empresa_users')->insert([
            'role_id'   => $rol->id,
            'user_id'   => $usuarioid->id,
            'name'      => $usuarioid->name,
            'empresa_id'=> $empresa->id,

        ]);



        return $usuario;

    }
}
