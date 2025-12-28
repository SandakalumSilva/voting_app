<?php

namespace App\Http\Controllers;

use App\Interfaces\NominationInterface;
use Illuminate\Http\Request;

class NominationController extends Controller
{
    protected $NominationRepository;
    public function __construct(NominationInterface $NominationRepository)
    {
        $this->NominationRepository = $NominationRepository;
    }

    public function createNomination(Request $request)
    {
        return $this->NominationRepository->createNomination($request);
    }

    public function getNominations($id)
    {
        return $this->NominationRepository->getNominations($id);
    }

    public function allNominations()
    {
        return $this->NominationRepository->allNominations();
    }
}
