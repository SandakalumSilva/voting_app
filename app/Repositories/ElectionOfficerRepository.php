<?php

namespace App\Repositories;

use App\Interfaces\ElectionOfficerInterface;
use App\Models\AuditLog;
use App\Models\Election;
use App\Models\ElectionVoter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ElectionOfficerRepository implements ElectionOfficerInterface
{
    public function index()
    {
        return view('voting.dashbord.election_officer.index');
    }
    public function getCandidates()
    {
        $candidates = User::where('role', '!=','admin')
        ->where('role', '!=','election_officer')
        ->get();
        return response()->json(['candidates' => $candidates]);
    }
    public function getVoters()
    {
        $voters = User::where('role', 'voter')->get();
        return response()->json(['voters' => $voters]);
    }
    public function saveElection($request)
    {
        try {
            //  Use transaction for safety
            DB::beginTransaction();

            $departments = $request->departments;
            $positions = $request->positions;

            $departmentVoters = User::whereIn('department', $departments)->where('role', $positions)->get();


            $election = Election::create([
                'election_name' => $request->election_name,
                'election_date' => $request->election_date,
                'start_time'    => $request->start_time,
                'end_time'      => $request->end_time,
                'candidates'    => json_encode($request->candidates),
                'positions'     => json_encode($request->positions),
                'departments'   => json_encode($request->departments),
            ]);

            foreach ($request->candidates as $candidate) {
                User::where('id', $candidate)->update(['role' => 'candidate']);
            }



            $departmentVoterIds = $departmentVoters->pluck('id')->toArray(); // IDs from department
            $selectedVoterIds = $request->voters ?? []; // IDs from request

            // Merge and remove duplicates
            $allVoterIds = array_unique(array_merge($departmentVoterIds, $selectedVoterIds));

            foreach ($allVoterIds as $voterId) {
                ElectionVoter::firstOrCreate(
                    ['election_id' => $election->id, 'voter_id' => $voterId]
                );
            }

            AuditLog::create([
                'user_id' => Auth::user()->id,
                'action'    => 'Create Election',
                'details' => json_encode($election),
            ]);

            DB::commit();

            return response()->json([
                'status'   => 'success',
                'message'  => 'Election created successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating election: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create election',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
