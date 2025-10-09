<?php 
namespace App\Repositories;

use App\Interfaces\DepartmentInterface;
use App\Models\Department;

class DepartmentRepository implements DepartmentInterface
{
    public function allDepartment()
    {
        $allDepartment = Department::all();
        return response()->json(['departments' => $allDepartment]);
    }
}