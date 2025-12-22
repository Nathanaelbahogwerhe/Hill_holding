<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class novacoreAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.novacore-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('novacore')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->route('novacore.dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('novacore')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('novacore.login');
    }
}




