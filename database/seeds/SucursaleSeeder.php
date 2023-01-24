<?php

use App\Sucursale;
use Illuminate\Database\Seeder;

class SucursaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sucursale::create([
            'nombre'      => 'Principal',
            'direccion'   => 'Calle 24 A Sur N° 69 C - 32 Piso 2',
            'empresa_id'  => '1',
            'ciudad_id'   => '1',
        ]);
/*
        Sucursale::create([
            'nombre'      => 'Centro Internacional',
            'direccion'   => 'Calle 31 N° 13 A - 51 Ed Panorama Of 318',
            'empresa_id'  => '2',
            'ciudad_id'   => '1',
        ]);

        Sucursale::create([
            'nombre'      => 'Lago',
            'direccion'   => 'Calle 76 N° 13 - 46',
            'empresa_id'  => '3',
            'ciudad_id'   => '1',
        ]);

        Sucursale::create([
            'nombre'      => 'Norte',
            'direccion'   => 'Autopista Norte N° 122 - 76',
            'empresa_id'  => '3',
            'ciudad_id'   => '1',
        ]);
*/
    }
}
