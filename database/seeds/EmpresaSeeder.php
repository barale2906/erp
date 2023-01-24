<?php

use App\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      Empresa::create([
         'nit'		    => '900474371',
         'nombre'		=> 'Somos Envios y Diligencias S.A.S.',
         'direccion'		=> 'Calle 24 A Sur N° 69 c - 32',
         'telefono'	    => '2906773 / 310 477 1708',
         'email'		    => 'somos.enviosydiligencias@gmail.com',
         'logo'          => '../logos/900474371.jpg',
         'tipo'          => 'Jurídico',
         'metodopago'    => 'efectivo'

      ]);



      Empresa::create([
         'nit'		    => '900277244',
         'nombre'		=> 'Helpharma S.A.',
         'direccion'		=> 'Calle 31 N° 13 A - 51 Ed Panorama Of 318',
         'telefono'	    => '605 25 55 Ext 1101',
         'email'		    => 'correspondencia@helpharma.com.co',
         'logo'          => '../logos/seyd.jpg',
         'tipo'          => 'Jurídico',
         'metodopago'    => 'efectivo'
      ]);
/*
      Empresa::create([
         'nit'		    => '800065396',
         'nombre'		=> 'Instituto de Diagnóstico Médico, IDIME S.A.',
         'direccion'		=> 'Calle 76 N° 13 - 46',
         'telefono'	    => '343 87 70',
         'email'		    => 'correspondencia@idime.com.co',
         'logo'          => '../logos/seyd.jpg'
      ]);

      */
   }
}
