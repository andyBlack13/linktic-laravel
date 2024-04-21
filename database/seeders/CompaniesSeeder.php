<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'Company 1',
                'email' => 'company1@example.com',
                'logo' => 'company1_logo.png',
                'website' => 'https://www.company1.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 2',
                'email' => 'company2@example.com',
                'logo' => 'company2_logo.png',
                'website' => 'https://www.company2.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 3',
                'email' => 'company3@example.com',
                'logo' => 'company3_logo.png',
                'website' => 'https://www.company3.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 4',
                'email' => 'company4@example.com',
                'logo' => 'company4_logo.png',
                'website' => 'https://www.company4.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 5',
                'email' => 'company5@example.com',
                'logo' => 'company5_logo.png',
                'website' => 'https://www.company5.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 6',
                'email' => 'company6@example.com',
                'logo' => 'company6_logo.png',
                'website' => 'https://www.company6.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 7',
                'email' => 'company7@example.com',
                'logo' => 'company7_logo.png',
                'website' => 'https://www.company7.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 8',
                'email' => 'company8@example.com',
                'logo' => 'company8_logo.png',
                'website' => 'https://www.company8.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 9',
                'email' => 'company9@example.com',
                'logo' => 'company9_logo.png',
                'website' => 'https://www.company9.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company 10',
                'email' => 'company10@example.com',
                'logo' => 'company10_logo.png',
                'website' => 'https://www.company10.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
