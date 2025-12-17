<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'ip' => request()->ip(),
                    'method' => request()->method(),
                ])
                ->log('Admin login');

            return redirect()->route('admin.dashboard')->with('just_logged_in', true);
        }


        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        activity()
            ->causedBy(Auth::user())
            ->log('Admin logout');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
