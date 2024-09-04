<?php

namespace Database\Seeders;

use App\Models\PrecioMarquesita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarquesitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrecioMarquesita::create([
            'precio' => 40.0,
        ]);
    }
}
