<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run()
    {
        DB::table('positions')->insert([
            [
                'name' => 'Environmental Officer',
                'salary' => 45000.00,
                'description' => 'Responsible for monitoring and enforcing environmental regulations',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Forestry Technician',
                'salary' => 35000.00,
                'description' => 'Assists in forest management and conservation activities',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Wildlife Specialist',
                'salary' => 42000.00,
                'description' => 'Specializes in wildlife conservation and management',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Water Resources Engineer',
                'salary' => 50000.00,
                'description' => 'Manages water resources and implements conservation projects',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Environmental Planner',
                'salary' => 48000.00,
                'description' => 'Develops and implements environmental protection plans',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
