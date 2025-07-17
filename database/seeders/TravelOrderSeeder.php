<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\TravelOrder;
use App\Models\TravelOrderStatus;
use App\Models\TravelOrderUserType;
use App\Models\TravelOrderSignatory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TravelOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_PH');
        
        // Get all statuses and user types
        $statuses = TravelOrderStatus::all()->keyBy('name');
        $userTypes = TravelOrderUserType::all()->keyBy('name');
        
        // Get some employees to be used in travel orders and as signatories
        $employees = Employee::with('user')->take(10)->get();
        
        if ($employees->isEmpty()) {
            $this->command->info('No employees found. Please run EmployeeSeeder first.');
            return;
        }
        
        // Create 20 sample travel orders
        for ($i = 0; $i < 20; $i++) {
            // Select a random employee for this travel order
            $employee = $employees->random();
            
            // Generate random dates
            $departureDate = $faker->dateTimeBetween('now', '+1 month');
            $arrivalDate = $faker->dateTimeBetween(
                $departureDate,
                Carbon::parse($departureDate)->addDays(5)
            );
            
            // Select a random status (weighted towards 'For recommendation' and 'For approval')
            $statusWeights = [
                'For recommendation' => 0.4,
                'For approval' => 0.3,
                'Approved' => 0.15,
                'Disapproved' => 0.05,
                'Cancelled' => 0.05,
                'Completed' => 0.05
            ];
            
            $status = $faker->randomElement(
                array_keys(
                    array_filter($statusWeights, function($weight) use ($faker) {
                        return $faker->boolean($weight * 100);
                    })
                )
            );
            
            if (empty($status)) {
                $status = 'For recommendation'; // Fallback
            }
            
            // Create the travel order
            $travelOrder = TravelOrder::create([
                'region' => $faker->randomElement([
                    'NCR', 'Region I', 'Region II', 'Region III', 'Region IV-A',
                    'Region IV-B', 'Region V', 'Region VI', 'Region VII', 'Region VIII',
                    'Region IX', 'Region X', 'Region XI', 'Region XII', 'CAR',
                    'CARAGA', 'ARMM', 'Region XIII', 'BARMM'
                ]),
                'address' => $faker->address,
                'date' => $faker->dateTimeBetween('-1 month', 'now'),
                'travel_order_no' => 'TO-' . now()->format('Y') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'employee_id' => $employee->id,
                'full_name' => $employee->first_name . ' ' . $employee->last_name,
                'salary' => $faker->randomFloat(2, 20000, 100000),
                'position' => $employee->position->name ?? 'Employee',
                'div_sec_unit' => $employee->divSecUnit->name ?? 'N/A',
                'departure_date' => $departureDate,
                'official_station' => $faker->city,
                'destination' => $faker->city . ', ' . $faker->state,
                'arrival_date' => $arrivalDate,
                'purpose_of_travel' => $faker->sentence(10),
                'per_diem_expenses' => $faker->randomFloat(2, 500, 5000),
                'assistant_or_laborers_allowed' => $faker->boolean(30), // 30% chance
                'appropriations' => $faker->randomElement(['MOOE', 'Local Funds', 'National Funds', 'Project Funds']),
                'remarks' => $faker->boolean(70) ? $faker->sentence(8) : null, // 70% chance of having remarks
                'status_id' => $statuses[$status]->id,
            ]);
            
            // Create signatories for this travel order
            $this->createSignatories($travelOrder, $employees, $userTypes);
        }
        
        $this->command->info('Travel orders seeded successfully!');
    }
    
    /**
     * Create signatories for a travel order
     */
    private function createSignatories($travelOrder, $employees, $userTypes)
    {
        // Get employees to be signatories (excluding the requester)
        $availableEmployees = $employees->where('id', '!=', $travelOrder->employee_id);
        
        // The employee who created the travel order is the requester
        TravelOrderSignatory::create([
            'travel_order_id' => $travelOrder->id,
            'employee_id' => $travelOrder->employee_id,
            'user_type_id' => $userTypes['Regular Employee']->id,
            'is_signed' => true,
            'signed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create recommender (if we have available employees)
        if ($availableEmployees->isNotEmpty()) {
            $recommender = $availableEmployees->random();
            $isSigned = rand(0, 1) === 1;
            
            TravelOrderSignatory::create([
                'travel_order_id' => $travelOrder->id,
                'employee_id' => $recommender->id,
                'user_type_id' => $userTypes['Recommender']->id,
                'is_signed' => $isSigned,
                'signed_at' => $isSigned ? now()->addHours(rand(1, 24)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Remove the recommender from available employees to avoid duplicates
            $availableEmployees = $availableEmployees->where('id', '!=', $recommender->id);
        }
        
        // Create approver (if we have available employees)
        if ($availableEmployees->isNotEmpty()) {
            $approver = $availableEmployees->random();
            $isSigned = rand(0, 1) === 1;
            
            TravelOrderSignatory::create([
                'travel_order_id' => $travelOrder->id,
                'employee_id' => $approver->id,
                'user_type_id' => $userTypes['Approver']->id,
                'is_signed' => $isSigned,
                'signed_at' => $isSigned ? now()->addHours(rand(25, 48)) : null, // Approver signs later
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
