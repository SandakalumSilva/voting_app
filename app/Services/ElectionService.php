<?php

namespace App\Services;

use App\Models\Election;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ElectionService
{
    public function getElection()
    {
        try {
            $elections = Election::where('status', 'ongoing')
                ->whereDate('election_date', Carbon::today())
                ->where('end_time', '<', Carbon::now())
                ->get();

            Log::info('Election completed: ' . count($elections));
            foreach ($elections as $election) {
                $election->status = 'completed';
                $election->save();
                Log::info('Election completed: ' . $election->election_name);
            }
        } catch (\Throwable $th) {
            Log::error('Error getting election: ' . $th->getMessage());
            return null;
        }
    }
}
