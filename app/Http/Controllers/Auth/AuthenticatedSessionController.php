<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('voting.auth.role-selection');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->session()->forget([
            'login_type',
        ]);

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        AuditLog::create([
            'user_id' => $user->id,
            'action'  => 'Login',
            'details' => json_encode($user),
        ]);

        return match ($user->role) {
            'admin'            => redirect()->route('admin.index'),
            'election_officer' => redirect()->route('election.officer.index'),
            'voter'            => redirect()->route('voter.index'),
            default            => redirect()->route('dashboard'),
        };
    }

    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     // Find user by email first
    //     $user = User::where('email', $request->email)->first();

    //     if (! $user) {
    //         throw ValidationException::withMessages([
    //             'email' => __('auth.failed'),
    //         ]);
    //     }

    //     // Election Officer Login
    //     if (
    //         $user->electionOfficer !== null
    //         && $user->electionOfficer->email == $request->email
    //     ) {

    //         $officer = $user->electionOfficer;

    //         if (! $officer) {
    //             throw ValidationException::withMessages([
    //                 'email' => 'Unauthorized election officer.',
    //             ]);
    //         }

    //         if ($officer->admin_approval_status !== 'approved') {
    //             throw ValidationException::withMessages([
    //                 'email' => 'Your account is not approved by admin.',
    //             ]);
    //         }

    //         if (! Hash::check($request->password, $officer->password)) {
    //             throw ValidationException::withMessages([
    //                 'email' => __('auth.failed'),
    //             ]);
    //         }

    //         Auth::login($user);
    //     }
    //     // Normal Breeze Login (Admin / Voter)
    //     else {
    //         $request->authenticate();
    //     }

    //     // 🔁 Security
    //     $request->session()->regenerate();
    //     $user = Auth::user();


    //     // Audit Log
    //     AuditLog::create([
    //         'user_id' => $user->id,
    //         'action'  => 'Login',
    //         'details' => json_encode([
    //             'role' => $user->role,
    //             'email' => $user->email,
    //         ]),
    //     ]);

    //     // Redirect logic
    //     if ($user->electionOfficer && $user->electionOfficer->admin_approval_status === 'approved') {
    //         return redirect()->route('election.officer.index');
    //     }

    //     return match ($user->role) {
    //         'admin' => redirect()->route('admin.index'),
    //         'voter' => redirect()->route('voter.index'),
    //         default => redirect()->route('dashboard'),
    //     };
    // }

    public function electionOfficerLogin(LoginRequest $request): RedirectResponse
    {
        // Find user by email first
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Election Officer Login
        if (
            $user->electionOfficer !== null
            && $user->electionOfficer->email == $request->email
        ) {

            $officer = $user->electionOfficer;

            if (! $officer) {
                throw ValidationException::withMessages([
                    'email' => 'Unauthorized election officer.',
                ]);
            }

            if ($officer->admin_approval_status !== 'approved') {
                throw ValidationException::withMessages([
                    'email' => 'Your account is not approved by admin.',
                ]);
            }

            if (! Hash::check($request->password, $officer->password)) {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            $request->session()->forget([
                'login_type',
            ]);

            $request->session()->put([
                'login_type'         => 'election_officer',
            ]);

            Auth::login($user);
            // Security
            $request->session()->regenerate();
            $user = Auth::user();
        }





        // Audit Log
        AuditLog::create([
            'user_id' => $user->id,
            'action'  => 'Login',
            'details' => json_encode([
                'role' => $user->role,
                'email' => $user->email,
            ]),
        ]);

        // Redirect logic
        return redirect()->route('election.officer.index');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'Log out',
            'details' => json_encode(Auth::user()),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
