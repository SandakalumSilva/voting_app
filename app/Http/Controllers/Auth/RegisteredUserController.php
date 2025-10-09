<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('voting.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'department' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:255', 'unique:users'],
            'profile_image' => ['required', 'image', 'max:2048'],
            'gender' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'department' => $request->department,
            'student_id' => $request->student_id,
            'profile_image' => $path,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $user = Auth::user();

        // if ($user->role == 'admin') {
        //     return redirect()->route('admin.index');
        // } elseif ($user->role == 'election_officer') {
        //     return redirect()->route('dashboard');
        // } elseif ($user->role == 'voter') {
        //     return redirect()->route('voter.index');
        // }

        return redirect(route('dashboard', absolute: false));
    }
}
