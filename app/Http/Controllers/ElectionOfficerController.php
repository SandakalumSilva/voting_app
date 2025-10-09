<?php

namespace App\Http\Controllers;

use App\Http\Requests\ElectionRequest;
use App\Interfaces\ElectionOfficerInterface;
use Illuminate\Http\Request;

class ElectionOfficerController extends Controller
{
    protected $electionOfficerRepository;
    public function __construct(ElectionOfficerInterface $electionOfficerRepository)
    {
        $this->electionOfficerRepository = $electionOfficerRepository;
    }

    public function index(Request $request)
    {
        return $this->electionOfficerRepository->index();
    }

    public function getCandidates()
    {
        return $this->electionOfficerRepository->getCandidates();
    }
    public function getVoters()
    {
        return $this->electionOfficerRepository->getVoters();
    }

    public function saveElection(ElectionRequest $request)
    {
        return $this->electionOfficerRepository->saveElection($request);
    }
}
