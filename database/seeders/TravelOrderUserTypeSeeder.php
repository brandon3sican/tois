<?php

namespace Database\Seeders;

use App\Models\TravelOrderUserType;
use Illuminate\Database\Seeder;

class TravelOrderUserTypeSeeder extends Seeder
{
    public function run(): void
    {
        $userTypes = [
            ['name' => 'Administrator', 'description' => 'System administrator with full access'],
            ['name' => 'Recommender', 'description' => 'Person who recommends the travel order'],
            ['name' => 'Approver', 'description' => 'Person who approves the travel order'],
            ['name' => 'Regular Employee', 'description' => 'Regular employee who can request travel orders'],
        ];

        foreach ($userTypes as $type) {
            TravelOrderUserType::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}
