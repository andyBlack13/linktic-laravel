<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rol_company')->insert([
            [
                'title' => 'Gerente de Recursos Humanos',
                'min_salary' => 50000,
                'max_salary' => 80000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Analista de Recursos Humanos',
                'min_salary' => 30000,
                'max_salary' => 50000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Gerente de Ventas',
                'min_salary' => 60000,
                'max_salary' => 90000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Ejecutivo de Ventas',
                'min_salary' => 30000,
                'max_salary' => 60000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Gerente de Marketing',
                'min_salary' => 55000,
                'max_salary' => 85000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Analista de Marketing',
                'min_salary' => 35000,
                'max_salary' => 55000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Desarrollador Web',
                'min_salary' => 40000,
                'max_salary' => 70000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Desarrollador de Software',
                'min_salary' => 45000,
                'max_salary' => 80000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Diseñador Gráfico',
                'min_salary' => 35000,
                'max_salary' => 60000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Especialista en SEO',
                'min_salary' => 45000,
                'max_salary' => 75000,
                'currency' => 'USD',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
