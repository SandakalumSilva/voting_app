<?php

namespace App\Repositories;

use App\Interfaces\VoterInterface;
use App\Models\AuditLog;
use App\Models\Election;
use App\Models\ElectionVote;
use App\Models\ElectionVoter;
use App\Models\User;
use COM;
use Faker\Provider\ar_EG\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VoterRepository implements VoterInterface
{
  public function index()
  {
    $user = Auth::user();
    $elections = ElectionVoter::select(
      'election_voters.id',
      'election_voters.election_id',
      'election_voters.voter_id',
      'elections.start_time',
      'elections.end_time',
      'elections.election_name as election_name'
    )
      ->join('elections', 'election_voters.election_id', '=', 'elections.id')
      ->where('election_voters.voter_id', $user->id)
      ->where('elections.end_time', '>=', now())
      ->get();

    $results = ElectionVoter::select(
      'election_voters.id',
      'election_voters.election_id',
      'election_voters.voter_id',
      'elections.start_time',
      'elections.end_time',
      'elections.election_name as election_name'
    )
      ->join('elections', 'election_voters.election_id', '=', 'elections.id')
      ->where('election_voters.voter_id', $user->id)
      ->where('elections.end_time', '<', now())
      ->get();


    return view('voting.dashbord.voter.index', compact('elections', 'results'));
  }

  public function election($election)
  {
    $candidates = json_decode($election->candidates);
    $allCandidates = User::whereIn('id', $candidates)->get();
    return response()->json(['candidates' => $allCandidates]);
  }

  public function vote($request)
  {
    $voter = Auth::user();

    $voterHash     = hash('sha256', $voter->id);
    $candidateHash = hash('sha256', $request->candidates);

    $exists = ElectionVote::where('is_otp_verified', true)
      ->where('voter_id', $voterHash)
      ->where('election_id', $request->election_id)
      ->first();

    if ($exists) {
      return response()->json([
        'status'  => 'error',
        'message' => 'You have already voted for this election',
      ], 422);
    }

    $data = [
      'voter_id'        => $voterHash,
      'election_id'     => $request->election_id,
      'candidate_id'    => $request->candidates,
      'otp'             => rand(1000, 9999),
      'is_otp_verified' => false,
      'otp_expiration'  => now()->addMinutes(15),
    ];

    $vote = ElectionVote::create($data);
    Mail::to($voter->email)->queue(new \App\Mail\OtpSendMail($vote->otp));
    AuditLog::create([
      'user_id' => Auth::user()->id,
      'action'  => 'Vote',
      'details' => json_encode(['election_id' => $request->election_id]),
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Vote submitted successfully',
      'vote_id' => $vote->id
    ]);
  }

  public function otpVerify($id)
  {

    return view('voting.dashbord.voter.otp-verify', compact('id'));
  }

  public function otpVerifyPost($request)
  {
    $vote = ElectionVote::where('id', $request->voter_id)
      ->first();
    if ($vote->is_otp_verified == true) {
      return response()->json([
        'status' => 'error',
        'message' => 'OTP already confirmed',
      ], 422);
    } elseif ($vote->otp_expiration < now()) {
      return response()->json([
        'status' => 'error',
        'message' => 'OTP expired',

      ], 422);
    } elseif ($vote->otp != $request->otp) {
      return response()->json([
        'status' => 'error',
        'message' => 'Invalid OTP',
      ], 422);
    } elseif ($vote->otp == $request->otp && $vote->otp_expiration > now()) {
      $vote->is_otp_verified = true;
      $vote->save();
      AuditLog::create([
        'user_id' => Auth::user()->id,
        'action'  => 'Vote otp verified',
        'details' => json_encode($vote),
      ]);
      return response()->json([
        'status' => 'success',
        'message' => 'OTP verified successfully',
      ]);
    } else {
      return response()->json([
        'status' => 'error',
        'message' => 'Invalid OTP',
      ], 422);
    }
  }
}
