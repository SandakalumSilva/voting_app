<?php

namespace App\Http\Controllers;

use App\Interfaces\NominationRequestInterface;
use Illuminate\Http\Request;

class NominationRequestCOntroller extends Controller
{

    protected $NominationRequestRepository;
    public function __construct(NominationRequestInterface $NominationRequestRepository)
    {
        $this->NominationRequestRepository = $NominationRequestRepository;
    }

    public function nominationRequests()
    {
        return $this->NominationRequestRepository->nominationRequests();
    }

    public function createNominationRequest(Request $request)
    {
        return $this->NominationRequestRepository->createNominationRequest($request);
    }
    public function withdrawNominationRequest($id)
    {
        return $this->NominationRequestRepository->withdrawNominationRequest($id);
    }
    public function getNominationRequests($id)
    {
        return $this->NominationRequestRepository->getNominationRequests($id);
    }

    public function changeStatus(Request $request)
    {
        return $this->NominationRequestRepository->changeStatus($request);
    }

    
}
