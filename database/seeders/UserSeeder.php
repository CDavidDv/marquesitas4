<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $admin = User::create([
            'name' => 'Admin',
            'sucursal_id' => '0',
            'email' => 'admin@marquesitas.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $trabajador = User::create([
            'name' => 'Sucursal 1',
            'sucursal_id' => '1',
            'email' => 'sucursal1@marquesitas.com',
            'password' => bcrypt('password'),
        ]);
        $trabajador->assignRole('trabajador');

        $trabajador = User::create([
            'name' => 'Sucursal 2',
            'sucursal_id' => '2',
            'email' => 'sucursal2@marquesitas.com',
            'password' => bcrypt('password'),
        ]);
        $trabajador->assignRole('trabajador');

        $trabajador = User::create([
            'name' => 'Sucursal 3',
            'sucursal_id' => '3',
            'email' => 'sucursal3@marquesitas.com',
            'password' => bcrypt('password'),
        ]);
        $trabajador->assignRole('trabajador');

        $trabajador = User::create([
            'name' => 'Sucursal 4',
            'sucursal_id' => '4',
            'email' => 'sucursal4@marquesitas.com',
            'password' => bcrypt('password'),
        ]);
        $trabajador->assignRole('trabajador');
    }
}
