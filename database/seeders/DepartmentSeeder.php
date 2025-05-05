<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'HR' => 'Human Resources Department',
            'Sales' => 'Sales and Marketing Department',
            'Marketing' => 'Marketing and Advertising Department',
            'IT' => 'Information Technology Department',
            'Finance' => 'Financial Services Department',
            'Operations' => 'Operations and Logistics Department',
            'Legal' => 'Legal Affairs Department',
            'Support' => 'Customer Support Department',
            'Engineering' => 'Engineering and Development Department',
            'R&D' => 'Research and Development Department'
        ];

        foreach ($departments as $name => $description) {
            Department::create([
                'name' => $name,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
