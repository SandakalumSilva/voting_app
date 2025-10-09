<?php 
namespace App\Interfaces;
interface ElectionOfficerInterface{
    public function index();
    public function getCandidates();
    public function getVoters();
    public function saveElection($request);
}