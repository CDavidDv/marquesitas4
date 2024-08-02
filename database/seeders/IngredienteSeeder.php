<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingrediente;


class IngredienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        Ingrediente::create([
            'nombre' => 'Almendra',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Crema de avellana',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Crema de cacahuate',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Maple',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Hershe\'s',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Lechera',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Mermelada',
            'detalles' => 'Variedad de sabores',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Nuez',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Fresa',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Semillas de girasol garapiñadas',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Chispas de chocolate',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Arándanos',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Cajeta',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Duraznos en almíbar',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Mango en almíbar',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Coco rallado',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Miel',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Bocadín',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Malvaviscos',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Mazapán',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Ate',
            'detalles' => 'Variedad de sabores',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Jamón de pavo',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Pepperoni',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Tocino',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Queso philadelphia',
            'precio' => 10.0,
        ]);
        Ingrediente::create([
            'nombre' => 'Extra Queso EDAM',
            'precio' => 15.0,
        ]);

    }
}
