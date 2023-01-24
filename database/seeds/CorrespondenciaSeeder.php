<?php

use App\Correspondencia;
use Illuminate\Database\Seeder;

class CorrespondenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Correspondencia::class, 1000)->create();
    }
}
