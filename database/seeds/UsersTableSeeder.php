<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()

   {
      User::create([
         'username'		    => '79844910',
         'name'		        => 'Ing. Alexander Barajas Vargas',
         'password'		    => bcrypt('Mi_Clau_2020'),
         'email'		        => 'alexanderbarajas@gmail.com',
         'empresa'           => 1
      ]);

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '1',  'user_id' => '1' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '1',  'user_id' => '1', 'name' => 'Ing. Alexander Barajas Vargas',
         'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '1', 'area' => 'Gerencia General' ]
      );

      User::create([
         'username'		    => '79843878',
         'name'		        => 'Jorge Enrique Corredor Camacho',
         'password'		    => bcrypt('joko3878'),
         'email'		        => 'somos.enviosydiligencias@gmail.com',
         'empresa'           => 1
      ]);

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '1',  'user_id' => '2' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '1',  'user_id' => '2', 'name' => 'Jorge Enrique Corredor Camacho',
         'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '1', 'area' => 'Gerencia General' ]
      );
/*
      User::create([
         'username'		    => '1233491472',
         'name'		        => 'Diego Alejandro Barajas Sanabria',
         'password'		    => bcrypt('10203040'),
         'email'		        => 'diegoabarajas@gmail.com',
         'empresa'           => 1
      ]);

      User::create([
         'username'		    => '1030535862',
         'name'		        => 'Daniela Barajas Jimenez',
         'password'		    => bcrypt('10203040'),
         'email'		        => 'danielabarajasjimenez@gmail.com',
         'empresa'           => 1
      ]);

      User::create([
         'username'		    => '52314764',
         'name'		        => 'Claudia Mireya Silva Vanegas',
         'password'		    => bcrypt('10203040'),
         'email'		        => 'claudiasilvavanegas@gmail.com',
         'empresa'           => 1
      ]);

   /*   factory(User::class, 20)->create();

      // Asignar roles a los usuarios
      DB::table('role_user')
      ->insert(
         [ 'role_id' => '1',  'user_id' => '1' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '2',  'user_id' => '2' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '3' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '4' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '5' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '6' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '7' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '8' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '9' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '10' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '11' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '12' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '13' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '2',  'user_id' => '14' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '15' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '16' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '17' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '2',  'user_id' => '18' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '19' ]
      );

      DB::table('role_user')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '20' ]
      );

      // Asignar empresas a los usuarios
      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '1',  'user_id' => '1', 'name' => 'Usuario 1', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '1', 'area' => 'Gerencia' ]
      );
      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '2',  'user_id' => '2', 'name' => 'Usuario 2', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '2', 'area' => 'Contabilidad' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '3', 'name' => 'Usuario 3', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '3', 'area' => 'Recursos' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '4', 'name' => 'Usuario 4', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '4', 'area' => 'Gerencia Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '5', 'name' => 'Usuario 5', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '5', 'area' => 'Comercial' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '6', 'name' => 'Usuario 6', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '6', 'area' => 'Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '7', 'name' => 'Usuario 7', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '2', 'area' => 'Contabilidad' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '8', 'name' => 'Usuario 8', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '3', 'area' => 'Recursos' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '9', 'name' => 'Usuario 9', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '4', 'area' => 'Gerencia Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '10', 'name' => 'Usuario 10', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '5', 'area' => 'Comercial' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '11', 'name' => 'Usuario 11', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '6', 'area' => 'Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '12', 'name' => 'Usuario 12', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '3', 'area' => 'Recursos' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '13', 'name' => 'Usuario 13', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '4', 'area' => 'Gerencia Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '2',  'user_id' => '14', 'name' => 'Usuario 14', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '5', 'area' => 'Comercial' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '15', 'name' => 'Usuario 15', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '6', 'area' => 'Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '16', 'name' => 'Usuario 16', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '3', 'area' => 'Recursos' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '17', 'name' => 'Usuario 17', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '4', 'area' => 'Gerencia Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(

         [ 'role_id' => '2',  'user_id' => '18', 'name' => 'Usuario 18', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '5', 'area' => 'Comercial' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '19', 'name' => 'Usuario 19', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '6', 'area' => 'Operaciones' ]
      );

      DB::table('empresa_users')
      ->insert(
         [ 'role_id' => '3',  'user_id' => '20', 'name' => 'Usuario 20', 'empresa_id' => '1', 'sucursal_id' => '1', 'sucursal' => 'Principal', 'area_id' => '3', 'area' => 'Recursos' ]
      );

      */
   }
}
