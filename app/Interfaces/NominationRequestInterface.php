<?php

namespace App\Interfaces;

interface NominationRequestInterface
{
    public function nominationRequests();
    public function createNominationRequest($request);
    public function withdrawNominationRequest($id);
    public function allNominations();
    public function getNominationRequests($id);
    public function changeStatus($request);
}
