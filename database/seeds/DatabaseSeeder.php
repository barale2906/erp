<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(CiudadeSeeder::class);
        $this->call(SucursaleSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(DotacionSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TipoEnvioSeeder::class);
        //$this->call(CorrespondenciaSeeder::class);
    }
}
