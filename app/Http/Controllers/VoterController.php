<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Http\Requests\VoteRequest;
use App\Interfaces\VoterInterface;
use App\Models\Election;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    protected $voterRepository;

    public function __construct(VoterInterface $voterRepository)
    {
        $this->voterRepository = $voterRepository;
    }

    public function index()
    {
        return $this->voterRepository->index();
    }

    public function election(Election $election)
    {
        return $this->voterRepository->election($election);
    }

    public function vote(VoteRequest $request)
    {
        return $this->voterRepository->vote($request);
    }

    public function otpVerify($id)
    {
        return $this->voterRepository->otpVerify($id);
    }

    public function otpVerifyPost(OtpRequest $request)
    {
        return $this->voterRepository->otpVerifyPost($request);
    }
}
