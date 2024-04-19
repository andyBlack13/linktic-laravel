<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Superadministrador',
                'description' => 'Tiene todos los permisos de administración.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Administrador',
                'description' => 'Tiene permisos de administración básicos.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Usuario',
                'description' => 'No tiene permisos de administrador.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
