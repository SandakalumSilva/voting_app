<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('voting.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'Login',
            'details' => json_encode($user),
        ]);

        if ($user->role == 'admin') {
            return redirect()->route('admin.index');
        } elseif ($user->role == 'election_officer') {
            return redirect()->route('election.officer.index');
        } elseif ($user->role == 'voter') {
            return redirect()->route('voter.index');
        }

        return redirect()->intended(route('dashboard', absolute: false));
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
