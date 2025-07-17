<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public static $employeeIds = [];

    public function run()
    {
        $employees = [
            [
                'first_name' => 'John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'suffix' => 'Jr.',
                'age' => 35,
                'gender' => 'male',
                'address' => '123 Forest Ave, Quezon City',
                'contact_num' => '09123456789',
                'birthdate' => '1988-05-15',
                'date_hired' => '2020-01-15',
                'position_id' => 1,
                'div_sec_unit_id' => 1,
                'employment_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Maria',
                'middle_name' => 'Garcia',
                'last_name' => 'Garcia',
                'age' => 32,
                'gender' => 'female',
                'address' => '456 Wildlife St, Quezon City',
                'contact_num' => '09987654321',
                'birthdate' => '1991-08-20',
                'date_hired' => '2021-03-10',
                'position_id' => 2,
                'div_sec_unit_id' => 2,
                'employment_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'James',
                'middle_name' => 'John',
                'last_name' => 'Rodriguez',
                'suffix' => 'Sr.',
                'age' => 40,
                'gender' => 'male',
                'address' => '789 Conservation Rd, Quezon City',
                'contact_num' => '09156789456',
                'birthdate' => '1985-11-30',
                'date_hired' => '2018-06-01',
                'position_id' => 3,
                'div_sec_unit_id' => 3,
                'employment_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Ana',
                'middle_name' => 'Maria',
                'last_name' => 'Perez',
                'age' => 28,
                'gender' => 'female',
                'address' => '321 Planning Blvd, Quezon City',
                'contact_num' => '09234567890',
                'birthdate' => '1997-02-14',
                'date_hired' => '2022-09-15',
                'position_id' => 4,
                'div_sec_unit_id' => 4,
                'employment_status_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Carlos',
                'middle_name' => 'Juan',
                'last_name' => 'Santos',
                'age' => 38,
                'gender' => 'male',
                'address' => '987 Legal Ave, Quezon City',
                'contact_num' => '09345678901',
                'birthdate' => '1987-07-25',
                'date_hired' => '2019-04-22',
                'position_id' => 5,
                'div_sec_unit_id' => 5,
                'employment_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($employees as $employee) {
            $result = DB::table('employees')->insertGetId($employee);
            self::$employeeIds[] = $result;
        }
    }
}
