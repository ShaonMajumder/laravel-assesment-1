<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $departments = Department::all();

        foreach (range(1, 100) as $i) {
            $employees = [];

            foreach (range(1, 1000) as $j) {
                $uuid = (string) Str::uuid();
                $employees[] = [
                    'id' => $uuid,
                    'name' => $faker->name,
                    'email' => $faker->unique()->email,
                    'department_id' => $departments->random()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $employeeDetails[] = [
                    'employee_id' => $uuid,
                    'designation' => $faker->jobTitle,
                    'salary' => $faker->randomFloat(2, 3000, 10000),
                    'address' => $faker->address,
                    'joined_date' => $faker->date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Employee::insert($employees);
            EmployeeDetail::insert($employeeDetails);

            unset($employeeDetails);
        }
    }
}
