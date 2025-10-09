<?php 
namespace App\Interfaces;

interface AdminInterface
{
    public function index();
    public function users();
    public function allVoters();
    public function voterDelete($id);
    public function enrollment();
    public function allEnrollment();
    public function voterStatus($id, $status);
}