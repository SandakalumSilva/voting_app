<?php

namespace App\Repositories;

use App\Interfaces\NominationRequestInterface;
use App\Models\NominationRequest;
use Illuminate\Support\Facades\Auth;

class NominationRequestRepository implements NominationRequestInterface
{
    public function nominationRequests() {}

    public function createNominationRequest($request)
    {
        $request->validate([
            'nomination_id' => 'required',
            'positions' => 'required',
        ]);

        $createNominationRequest = NominationRequest::updateOrCreate(
            [
                'nomination_id' => $request->nomination_id,
                'user_id'       => Auth::id(),
            ],
            [
                'position' => $request->positions,
            ]
        );

        return response()->json(['message' => 'Nomination request created successfully']);
    }

    public function withdrawNominationRequest($id)
    {
        NominationRequest::where('id', $id)->delete();
        return response()->json(['message' => 'Nomination request withdrawn successfully']);
    }

    public function allNominations()
    {
        $nominations = NominationRequest::with('electionNomination')->where('user_id', Auth::id())->get();
        return view('voting.dashbord.election_officer.all-nomination', compact('nominations'));
    }

    public function getNominationRequests($id)
    {
        $nominationRequests = NominationRequest::with('user')
            ->where('nomination_id', $id)
            ->get();


        return response()->json([
            'nominationRequests' => $nominationRequests
        ]);
    }

    public function changeStatus($request)
    {
        // approve selected users
        foreach ($request->selectedUsers as $user) {
            NominationRequest::where('id', $user['user_id'])
                ->update(['status' => 'approved']);
        }

        // reject other users for the same position
        foreach ($request->selectedUsers as $user) {
            NominationRequest::where('position', $user['position'])
                ->where('nomination_id', $user['nominationId'])
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }

        return response()->json(['message' => 'Nomination request approved successfully']);
    }
}
