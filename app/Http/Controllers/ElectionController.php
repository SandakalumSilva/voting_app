<?php

namespace App\Http\Controllers;

use App\Interfaces\ElectionInterface;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    protected $electionRepository;

    public function __construct(ElectionInterface $electionRepository)
    {
        $this->electionRepository = $electionRepository;
    }

    public function ongoingElection()
    {
        return $this->electionRepository->ongoingElection();
    }
    public function getOngoingElection(){
        return $this->electionRepository->getOngoingElection();
    }
    public function completedElection(){
        return $this->electionRepository->completedElection();
    }
    public function getCompletedElection(){
        return $this->electionRepository->getCompletedElection();
    }

    public function getElectionResult($id){
        return $this->electionRepository->getElectionResult($id);
    }
}
