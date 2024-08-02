<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        Sucursal::create([
            'nombre' => 'Sucursal 1',
            'direccion' => '1ro de Mayo #407',
            'telefono' => '771-181-72-03',
        ]);
        Sucursal::create([
            'nombre' => 'Sucursal 2',
            'direccion' => 'Muse del ferrocarril',
            'telefono' => '771-181-72-03',
        ]);
        Sucursal::create([
            'nombre' => 'Sucursal 3',
            'direccion' => 'Jardín la floresta',
            'telefono' => '771-181-72-03',
        ]);
        Sucursal::create([
            'nombre' => 'Sucursal 4',
            'direccion' => '',
            'telefono' => '771-181-72-03',
        ]);
        
    }
}
