<?php

use App\TipoEnvio;
use Illuminate\Database\Seeder;

class TipoEnvioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEnvio::create([

            'nombre'		=> 'Correspondencia',

        ]);

        TipoEnvio::create([

            'nombre'		=> 'Carga',

        ]);
    }
}
