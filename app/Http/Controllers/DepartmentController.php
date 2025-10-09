<?php

namespace App\Http\Controllers;

use App\Interfaces\DepartmentInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentRepository;
    public function __construct(DepartmentInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function allDepartment()
    {
        return $this->departmentRepository->allDepartment();
    }
}
