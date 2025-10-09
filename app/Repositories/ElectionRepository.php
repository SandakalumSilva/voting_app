<?php

namespace App\Repositories;

use App\Interfaces\ElectionInterface;
use App\Models\AuditLog;
use App\Models\Election;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use TCPDF;
use Yajra\DataTables\Facades\DataTables;

class ElectionRepository implements ElectionInterface
{
    public function ongoingElection()
    {
        return view('voting.dashbord.election.ongoing');
    }

    public function getOngoingElection()
    {
        $elections = Election::with('votes')->where('status', 'ongoing')->get();
        $electionDetails = [];
        $electionsName = [];

        foreach ($elections as $election) {
            $candidates = [];
            $votes = [];

            $allCandidates = json_decode($election->candidates);
            $allVoteCount = $election->votes->count();

            foreach ($allCandidates as $candidateId) {
                $candidate = User::find($candidateId);
                $name = $candidate->first_name . ' ' . $candidate->last_name;

                $candidates[] = $name;

                $userVoteCount = $election->votes->where('candidate_id', $candidate->id)->count();

                $votes[$name] = $allVoteCount > 0
                    ? round(($userVoteCount / $allVoteCount) * 100, 2)
                    : 0;
            }

            $election->candidates = $candidates;
            $election->vote = $votes;

            $electionsName[] = $election->election_name;

            // Store in results array
            $electionDetails[$election->election_name] = [
                'candidates' => $candidates,
                'votes'      => $votes,
            ];
        }

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'View Ongoing Election',
            'details' => json_encode($electionsName),
        ]);

        return response()->json(['electionsName' => $electionsName, 'elections' => $electionDetails]);
    }

    public function completedElection()
    {
        return view('voting.dashbord.election.completed');
    }
    public function getCompletedElection()
    {
        $elctions = Election::where('status', 'completed')->get();

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'View Completed Election',
            'details' => json_encode($elctions),
        ]);

        return DataTables::of($elctions)
            ->addIndexColumn()
            ->addColumn('action', function ($election) {
                return '<a target="_blank" href="' . route('election.get.election.result', $election->id) . '"  class="btn btn-sm btn-primary">Result</a>';
            })
            ->make(true);
    }

    public function getElectionResult($id)
    {
        $elections = Election::with('votes')->where('id', $id)->get();
        $electionDetails = [];
        $electionsName = [];
        Log::info($elections);
        foreach ($elections as $election) {
            $candidates = []; // reset for this election
            $votes = [];      // reset for this election
            $voteCount = [];
            $allCandidates = json_decode($election->candidates);
            $allVoteCount = $election->votes->count();

            foreach ($allCandidates as $candidateId) {
                $candidate = User::find($candidateId);
                $name = $candidate->first_name . ' ' . $candidate->last_name;

                $candidates[] = $name;

                $userVoteCount = $election->votes->where('candidate_id', $candidate->id)->count();

                $voteCount[$name] = $userVoteCount;
                $votes[$name] = $allVoteCount > 0
                    ? round(($userVoteCount / $allVoteCount) * 100, 2)
                    : 0;
            }


            $electionsName[] = $election->election_name;

            // Store in results array
            $electionDetails[$election->election_name] = [
                'candidates' => $candidates,
                'votes'      => $votes,
                'voteCount'  => $voteCount
            ];
        }

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'View Completed Election Result',
            'details' => json_encode($election->election_name),
        ]);

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Election App');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Completed election PDF');
        $pdf->SetSubject('TCPDF Example');
        $pdf->SetKeywords('TCPDF, Laravel, PDF');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins
        $pdf->SetMargins(15, 15, 15);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add content (can be HTML too)
        $html = '
            <h1>' . $electionsName[0] . ' Final Result</h1>
            <p>Election Name: ' . $electionsName[0] . '</p>
            <p>Total Votes Count: ' . $elections[0]->votes->count() . '</p>
            <table border="1" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Candidate Name</th>
                    <th>Vote Count</th>
                    <th>Vote Percentage</th>
                </tr>
            ';

        $totalVotes = $elections[0]->votes->count();

        foreach ($electionDetails[$electionsName[0]]['candidates'] as $index => $candidate) {
            $votePrecentage = $electionDetails[$electionsName[0]]['votes'][$candidate];
            $voteCount = $electionDetails[$electionsName[0]]['voteCount'][$candidate];

            $html .= '
    <tr>
        <td>' . ($index + 1) . '</td>
        <td>' . $candidate . '</td>
        <td>' . $voteCount . '</td>
        <td>' . $votePrecentage . ' %</td>
    </tr>
    ';
        }

        $html .= '</table>';


        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF to browser
        $pdf->Output('election-results.pdf', 'I');
    }
}
