<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BebidasInventarioSeeder::class,
            IngredienteSeeder::class, 
            SucursalSeeder::class,
            RoleSeeder::class,
            UserSeeder::class
        ]);
        
    }
}
