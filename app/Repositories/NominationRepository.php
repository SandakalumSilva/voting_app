<?php

namespace App\Repositories;

use App\Interfaces\NominationInterface;
use App\Models\ElectionNomination;
use Illuminate\Support\Facades\Auth;

class NominationRepository implements NominationInterface
{
    //nomination create
    public function createNomination($request)
    {

        $request->validate([
            'election_positions' => 'required|max:255',
            'start_time' => 'required',
            'end_time' => 'required|after_or_equal:start_time',
        ]);

        $createNomination = ElectionNomination::create([
            'user_id' => Auth::id(),
            'positions' => json_encode($request->election_positions),
            'start_date' => $request->start_time,
            'end_date' => $request->end_time,
        ]);

        return response()->json(['message' => 'Nomination created successfully']);
    }

    public function getNominations($id)
    {
        $nominations = ElectionNomination::with([
            'nominationRequests' => function ($query) {
                $query->where('user_id', Auth::id());
            }
        ])
            ->where('id', $id)
            ->get();

        return response()->json([
            'nominations' => $nominations
        ]);
        // return response()->json(['nominations' => $nominations]);
    }

    public function allNominations()
    {
        $nominations = ElectionNomination::with('nominationRequests')->get();
        return view('voting.dashbord.election_officer.all-nomination', compact('nominations'));
    }
}
