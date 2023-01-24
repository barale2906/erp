<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
        	'name'		    => 'Superusuario',
            'slug'  	    => 'slug',
            'description'  	=> 'Este usuario tiene acceso a todos los modulos y parámetrización del sistema',
        	'full-access' 	=> 'yes'
        ]);

        Role::create([
        	'name'		    => 'Administrador',
            'slug'  	    => 'administrador',
            'description'  	=> 'Este usuario tiene acceso a todos los modulos y excepto a la parámetrización del sistema',
        	'full-access' 	=> 'no'
        ]);

        Role::create([
        	'name'		    => 'Mensajero',
            'slug'  	    => 'mensajero',
            'description'  	=> 'Su rol aplica sobretodo al modulo de correspondencia',
        	'full-access' 	=> 'no'
        ]);

        Role::create([
        	'name'		    => 'Usuario',
            'slug'  	    => 'usuario',
            'description'  	=> 'Usuario de consulta y acceso a parámetros básicos',
        	'full-access' 	=> 'no'
        ]);


    }
}
