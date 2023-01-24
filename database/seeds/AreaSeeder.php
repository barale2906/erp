<?php

use App\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'area'      => 'Gerencia General',
            'empresa_id'  => '1',

        ]);

        Area::create([
            'area'      => 'Contabilidad',
            'empresa_id'  => '1',

        ]);

        Area::create([
            'area'      => 'Gerencia de Operaciones',
            'empresa_id'  => '1',

        ]);

        Area::create([
            'area'      => 'Gestión Humana',
            'empresa_id'  => '1',

        ]);

        Area::create([
            'area'      => 'Comercial',
            'empresa_id'  => '1',

        ]);

        Area::create([
            'area'      => 'Operaciones',
            'empresa_id'  => '1',

        ]);
/*
        Area::create([
            'area'      => 'Gerencia General',
            'empresa_id'  => '2',

        ]);

        Area::create([
            'area'      => 'Correspondencia',
            'empresa_id'  => '2',

        ]);

        Area::create([
            'area'      => 'Farmacía',
            'empresa_id'  => '2',

        ]);

        Area::create([
            'area'      => 'Contabilidad',
            'empresa_id'  => '3',

        ]);

        Area::create([
            'area'      => 'Gerencia General',
            'empresa_id'  => '3',

        ]);

        Area::create([
            'area'      => 'Correspondencia',
            'empresa_id'  => '3',

        ]);

        Area::create([
            'area'      => 'Radiología',
            'empresa_id'  => '3',

        ]);

        Area::create([
            'area'      => 'Escanografía',
            'empresa_id'  => '3',

        ]);

*/
    }
}
