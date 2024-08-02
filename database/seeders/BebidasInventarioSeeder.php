<?php

namespace Database\Seeders;

use App\Models\BebidasInventario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BebidasInventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BebidasInventario::create([
            'nombre' => 'Americano',
            'detalles' => 'Punta del cielo',
            'precio' => 30.0,
        ]);
        BebidasInventario::create([
            'nombre' => 'Espresso',
            'detalles' => 'Punta del cielo',
            'precio' => 30.0,
        ]);
        BebidasInventario::create([
            'nombre' => 'Capuchino',
            'precio' => 40.0,
        ]);
        BebidasInventario::create([
            'nombre' => 'Café especial',
            'detalles' => 'Dolce Gusto',
            'precio' => 40.0,
        ]);
        BebidasInventario::create([
            'nombre' => 'Café Starbucks',
            'detalles' => 'Variedad de sabores',
            'precio' => 50.0,
        ]);
        BebidasInventario::create([
            'nombre' => 'Té',
            'detalles' => 'Variedad de sabores',
            'precio' => 20.0,
        ]);
        BebidasInventario::create([
            'nombre' => 'Refresco',
            'detalles' => 'Variedad de sabores',
            'precio' => 15.0,
        ]);
        BebidasInventario::create([
            'nombre' => 'Agua embotellada',
            'detalles' => '',
            'precio' => 15.0,
        ]);
        
    }
}
