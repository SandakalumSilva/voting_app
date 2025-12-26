<?php

namespace App\Repositories;

use App\Interfaces\AdminInterface;
use App\Models\AuditLog;
use App\Models\ElectionOfficer;
use App\Models\EnrollmentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AdminRepository implements AdminInterface
{
    public function index()
    {
        return view('voting.dashbord.admin.index');
    }
    public function users()
    {
        return view('voting.dashbord.admin.users');
    }
    public function allVoters()
    {
        $allVoters = User::where('role', 'voter')->select('id', 'first_name', 'last_name', 'email')->get();

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'watch all voters',
            'details' => json_encode(200),
        ]);

        return DataTables::of($allVoters)
            ->addIndexColumn()
            ->addColumn('action', function ($voter) {
                return '<button data-id="' . $voter->id . '" class="btn btn-sm btn-danger voter-delete">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function voterDelete($id)
    {
        $voter = User::findOrFail($id);
        $voter->delete();

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'Voter Delete',
            'details' => json_encode($voter),
        ]);

        return response()->json([
            'message' => 'Voter deleted successfully',
        ], 200);
    }
    public function enrollment()
    {
        return view('voting.dashbord.admin.enrollment');
    }
    public function allEnrollment()
    {
        $enrollmentRequests = ElectionOfficer::with('user')
            ->where('admin_approval_status', 'pending')
            ->orderBy('id', 'desc')->get();

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'Enrollment Request',
            'details' => json_encode($enrollmentRequests),
        ]);

        return DataTables::of($enrollmentRequests)
            ->addIndexColumn()
            ->addColumn('user_name', function ($request) {
                return $request->user ? $request->user->first_name . ' ' . $request->user->last_name : 'N/A';
            })
            ->addColumn('action', function ($request) {
                return '<button data-id="' . $request->id . '" data-status="approved" class="btn btn-sm btn-primary approve-enrollment">Approve</button>
                        <button data-id="' . $request->id . '" data-status="rejected" class="btn btn-sm btn-danger reject-enrollment">Reject</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function voterStatus($id, $status)
    {
        $user = ElectionOfficer::findOrFail($id);
        $user->admin_approval_status = $status;
        $user->save();

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'Enrollment status change',
            'details' => json_encode($user),
        ]);

        // if ($user->user_become_status == 'voter') {
        //     $user->user->role = 'voter';
        //     $user->user->save();
        // } elseif ($user->user_become_status == 'election_officer') {
        //     $user->user->role = 'election_officer';
        //     $user->user->save();
        // } elseif ($user->user_become_status == 'candidate') {
        //     $user->user->role = 'candidate';
        //     $user->user->save();
        // }

        return response()->json([
            'message' => 'Voter status updated successfully',
        ], 200);
    }
}
