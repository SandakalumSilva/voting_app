<?php 
namespace App\Interfaces;

interface ElectionInterface
{
    public function ongoingElection();
    public function getOngoingElection();
    public function completedElection();
    public function getCompletedElection();
    public function getElectionResult($id);
}