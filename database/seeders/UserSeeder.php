<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create users for each employee
        foreach (EmployeeSeeder::$employeeIds as $index => $employeeId) {
            $username = match($index) {
                0 => 'john_smith',
                1 => 'maria_garcia',
                2 => 'james_rodriguez',
                3 => 'ana_perez',
                4 => 'carlos_santos'
            };

            DB::table('users')->insert([
                'username' => $username,
                'password' => Hash::make('password123'),
                'employee_id' => $employeeId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Create admin user (not linked to any employee)
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
