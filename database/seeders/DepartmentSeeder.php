<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allDepartments = [
            ['department_name' => 'Department of Computer Science'],
            ['department_name' => 'Department of Business Administration'],
            ['department_name' => 'Department of Engineering'],
            ['department_name' => 'Department of Medicine'],
            ['department_name' => 'Department of Law'],
            ['department_name' => 'Department of Psychology'],
            ['department_name' => 'Department of Education'],
            ['department_name' => 'Department of Languages'],
            ['department_name' => 'Department of Fine Arts'],
        ];

        foreach ($allDepartments as $allDepartment) {
            Department::create($allDepartment);
        }
    }
}
