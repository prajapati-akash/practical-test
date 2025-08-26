<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(StoreUserRequest $request)
    {
        $data = $request->only(['user_name','user_email','password','user_mobile_no','user_type','parent_id']);
        $data['activation_token'] = Str::random(64);
        $data['user_status'] = 'inactive';

        $user = User::create($data);

        // In demo: create activation link, do not send mail
        $activationLink = route('activate', ['token' => $user->activation_token]);

        return redirect()->route('login')->with('success', "User registered. Activation link: {$activationLink}");
    }

    public function activate($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activation_token = null;
        $user->user_status = 'active';
        $user->save();

        return redirect()->route('login')->with('success', 'Account activated. You can now login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_email' => 'required|email',
            'password'   => 'required|string',
        ]);
        
        // Try to login with email/password only
        if (Auth::attempt([
            'user_email' => $credentials['user_email'],
            'password'   => $credentials['password']
        ], $request->filled('remember'))) {
            
            $request->session()->regenerate();

            // Check active status
            if (Auth::user()->user_status !== 'active') {
                Auth::logout();
                return back()->withInput()->with('error', 'Your account is inactive. Please activate it first.');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withInput()->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}