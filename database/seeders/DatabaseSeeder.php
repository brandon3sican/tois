<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PositionSeeder;
use Database\Seeders\EmploymentStatusSeeder;
use Database\Seeders\DivSecUnitSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in order
        $this->call([
            PositionSeeder::class,
            EmploymentStatusSeeder::class,
            DivSecUnitSeeder::class,
            EmployeeSeeder::class,
            UserSeeder::class
        ]);
    }
}
