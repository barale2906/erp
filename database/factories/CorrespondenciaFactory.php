<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Correspondencia;
use Faker\Generator as Faker;

$factory->define(Correspondencia::class, function (Faker $faker) {
    return [
        'solicita'=>rand(1,20),
        'empresa_id' => '1',
        'name' => $faker->name,
        'sucursal'=>'1',
        'nombresucursal' => $faker->name,
        'area'=>rand(1,10),
        'nombrearea' => $faker->name,
        'clase'=>rand(1,2),
        'destinatario'=>rand(1,20),
        'nombredestinatario' => $faker->name,
        'sede'=>rand(1,6),
        'nombresede' => $faker->name,
        'ubicacion'=>rand(1,10),
        'nombreubicacion' => $faker->name,
        'horario'=>'Lunes a viernes de 5 - 8',
        'descripcion'=>'Un sobre',
        'detalle'=> 'contiene cosas muy importantes para nuestra organización, desde mucha información hasta vario datos de nuestra gente, es increible todo lo que uno
                    puede escribir cuando hecha carreta. Esa es Esa Es',
        'observaciones'=> 'Este es mas largo que el anterior, contiene cosas muy importantes para nuestra organización, desde mucha información hasta vario datos de nuestra gente, es increible todo lo que uno
                    puede escribir cuando hecha carreta. Esa es Esa Es',



    ];
});
