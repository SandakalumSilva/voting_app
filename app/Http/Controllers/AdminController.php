<?php

namespace App\Http\Controllers;

use App\Interfaces\AdminInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminRepository;

    public function __construct(AdminInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        return $this->adminRepository->index();
    }

    public function users()
    {
        return $this->adminRepository->users();
    }
    public function allVoters()
    {
        return $this->adminRepository->allVoters();
    }
    public function voterDelete($id)
    {
        return $this->adminRepository->voterDelete($id);
    }
    public function enrollment()
    {
        return $this->adminRepository->enrollment();
    }

    public function allEnrollment()
    {
        return $this->adminRepository->allEnrollment();
    }
    public function voterStatus($id, $status)
    {
        // Assuming you have a method in the repository to handle voter status updates
        return $this->adminRepository->voterStatus($id, $status);
    }
}
