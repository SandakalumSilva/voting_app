<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeCOntroller extends Controller
{
    public function index()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin.index');
            case 'election_officer':
                return redirect()->route('election.officer.index');
            case 'voter':
                return redirect()->route('voter.index');
                 case 'candidate':
                return redirect()->route('voter.index');
            default:
                Auth::logout();
                return redirect()->route('login');
        }
    }
}
