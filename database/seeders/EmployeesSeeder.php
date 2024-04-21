<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'company_id' => 1,
                'rol_company_id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone_number' => '123-456-7890',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'rol_company_id' => 1,
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane.doe@example.com',
                'phone' => '987-654-3210',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 2,
                'rol_company_id' => 2,
                'first_name' => 'Michael',
                'last_name' => 'Smith',
                'email' => 'michael.smith@example.com',
                'phone' => '111-222-3333',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 2,
                'rol_company_id' => 2,
                'first_name' => 'Emily',
                'last_name' => 'Johnson',
                'email' => 'emily.johnson@example.com',
                'phone' => '444-555-6666',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 3,
                'rol_company_id' => 3,
                'first_name' => 'William',
                'last_name' => 'Brown',
                'email' => 'william.brown@example.com',
                'phone' => '777-888-9999',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 3,
                'rol_company_id' => 3,
                'first_name' => 'Olivia',
                'last_name' => 'Jones',
                'email' => 'olivia.jones@example.com',
                'phone' => '000-111-2222',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 4,
                'rol_company_id' => 3,
                'first_name' => 'James',
                'last_name' => 'Garcia',
                'email' => 'james.garcia@example.com',
                'phone' => '333-444-5555',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 4,
                'rol_company_id' => 3,
                'first_name' => 'Sophia',
                'last_name' => 'Martinez',
                'email' => 'sophia.martinez@example.com',
                'phone' => '666-777-8888',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 5,
                'rol_company_id' => 3,
                'first_name' => 'Benjamin',
                'last_name' => 'Robinson',
                'email' => 'benjamin.robinson@example.com',
                'phone' => '999-000-1111',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 5,
                'rol_company_id' => 3,
                'first_name' => 'Isabella',
                'last_name' => 'Clark',
                'email' => 'isabella.clark@example.com',
                'phone' => '222-333-4444',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
