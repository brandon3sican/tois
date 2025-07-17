<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivSecUnitSeeder extends Seeder
{
    public function run()
    {
        DB::table('div_sec_units')->insert([
            [
                'name' => 'Forest Management Division',
                'description' => 'Handles forest resource management and conservation',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Wildlife Resources Division',
                'description' => 'Manages wildlife conservation and protection',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Environmental Management Division',
                'description' => 'Oversees environmental protection programs',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Planning and Development Division',
                'description' => 'Handles strategic planning and development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Legal Services Division',
                'description' => 'Provides legal support and services',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
