<?php

namespace Database\Seeders;

use App\Models\TravelOrderStatus;
use Illuminate\Database\Seeder;

class TravelOrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'For recommendation', 'description' => 'Pending recommendation from designated personnel'],
            ['name' => 'For approval', 'description' => 'Pending approval from authorized signatory'],
            ['name' => 'Approved', 'description' => 'Travel order has been approved'],
            ['name' => 'Disapproved', 'description' => 'Travel order has been disapproved'],
            ['name' => 'Cancelled', 'description' => 'Travel order has been cancelled'],
            ['name' => 'Completed', 'description' => 'Travel order has been completed'],
        ];

        foreach ($statuses as $status) {
            TravelOrderStatus::firstOrCreate(
                ['name' => $status['name']],
                $status
            );
        }
    }
}
