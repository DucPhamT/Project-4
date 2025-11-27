<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check())
            return redirect('/homepage');
        return Inertia::render('Auth/Login', [

        ]);
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

        if (Auth::attempt($credentials, )) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            session(['api_token' => $token]);
            return redirect('/homepage');
        }

        return back()->withErrors([
            'email' => 'Wrong Username or Password',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

