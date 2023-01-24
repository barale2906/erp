<?php

use App\Dotacion;
use Illuminate\Database\Seeder;

class DotacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dotacion::create([
            'elemento'      => 'Chaqueta Motociclista',
            'descripcion'   => 'chaqueta en lona con nivel de fricción media, cintas reflectivas según modelo, logos en pecho y espalda bordados, bordado en mangas con celular de la empresa.',
        ]);

        Dotacion::create([
            'elemento'      => 'Chaqueta Gerencial',
            'descripcion'   => 'chaqueta según diseño para la gerencia',
        ]);

        Dotacion::create([
            'elemento'      => 'Chaqueta rompevientos',
            'descripcion'   => 'chaqueta liviana, con cintas reflectivas y logo de la empresa según modelo',
        ]);

        Dotacion::create([
            'elemento'      => 'Camiseta Negra Logo',
            'descripcion'   => 'Camiseta en algodón de cuello redondo con logo bordado en el pecho',
        ]);

        Dotacion::create([
            'elemento'      => 'Camisa Administrativa Logo',
            'descripcion'   => 'Camisa tipo Oxford de color azul, con logo en el pecho',
        ]);

        Dotacion::create([
            'elemento'      => 'Camisa Polo Negra',
            'descripcion'   => 'Camisa tipo polo con logo en el pecho',
        ]);

        Dotacion::create([
            'elemento'      => 'Jean Azul Logo',
            'descripcion'   => 'Jean color azul de 22 onzas con logo bordado en la pierna izquierda y cintas reflectivas en las mangas a la altura de la pantorrilla',
        ]);

        Dotacion::create([
            'elemento'      => 'Botas con protector en la punta',
            'descripcion'   => 'Botas industriales con protector para los dedos',
        ]);

        Dotacion::create([
            'elemento'      => 'Cachucha negra con logo',
            'descripcion'   => 'Cachucha con logo de la empresa',
        ]);

        Dotacion::create([
            'elemento'      => 'Dotación Área Comercial',
            'descripcion'   => 'Dotación formal completa incluido calzado.',
        ]);
    }
}
