<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentStatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('employment_statuses')->insert([
            [
                'name' => 'Permanent',
                'description' => 'Regular and permanent employee',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Contractual',
                'description' => 'Employee hired under a fixed-term contract',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Job Order',
                'description' => 'Temporary employee hired for specific tasks',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'On Detail',
                'description' => 'Employee temporarily assigned to another unit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'On Leave',
                'description' => 'Employee on authorized leave',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
