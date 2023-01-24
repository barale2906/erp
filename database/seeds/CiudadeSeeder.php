<?php

use App\Ciudade;
use Illuminate\Database\Seeder;

class CiudadeSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      Ciudade::create([
         'ciudad'		   => 'Bogotá',
         'departamento'	=> 'Cundinamarca',
         'codigociudad' => 1,
         'codigodepto'  => 1

      ]);

      Ciudade::create([
         'ciudad'		      => 'Pereira',
         'departamento'		=> 'Risaralda',
         'codigociudad'    => 2,
            'codigodepto'  => 2

      ]);

      Ciudade::create([
         'ciudad'		      => 'Ibague',
         'departamento'		=> 'Tolima',
         'codigociudad'    => 3,
         'codigodepto'     => 3

      ]);

      Ciudade::create([
         'ciudad'		      => 'Armenia',
         'departamento'		=> 'Quindio',
         'codigociudad'    => 4,
         'codigodepto'     => 4

      ]);

      Ciudade::create([
         'ciudad'		      => 'Neiva',
         'departamento'		=> 'Huila',
         'codigociudad'    => 5,
         'codigodepto'     => 5

      ]);

      Ciudade::create([
         'ciudad'		      => 'Girardot',
         'departamento'		=> 'Cundinamarca',
         'codigociudad'    => 6,
         'codigodepto'     => 1

      ]);

      Ciudade::create([
         'ciudad'		      => 'Zipaquira',
         'departamento'		=> 'Cundinamarca',
         'codigociudad'    => 8,
         'codigodepto'     => 1

      ]);


      Ciudade::create([
         'ciudad'		      => 'Cartago',
         'departamento'		=> 'Valle',
         'codigociudad'    => 7,
         'codigodepto'     => 6

      ]);



      Ciudade::create([
         'ciudad'		      => 'Valledupar',
         'departamento'		=> 'Cesar',
         'codigociudad'    => 9,
         'codigodepto'     => 7

      ]);
   }
}
