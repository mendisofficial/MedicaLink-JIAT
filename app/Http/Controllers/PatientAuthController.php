<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PatientAuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.patient-login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'nic' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('patient')->attempt($credentials)) {
            $request->session()->regenerate();
            Session::put('guard','patient');
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors([
            'nic' => 'The provided credentials do not match our records.',
        ]);
    }

        public function logout(Request $request) {
            Auth::guard('patient')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
}
