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

    public function profile()
    {
        return view('admin.pages.profile.index', [
            'user' => Auth::user()
        ]);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Ambil data lama untuk log
        $oldData = $user->only(['name', 'email']);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = $request->password; // otomatis di-hash oleh cast
        }

        $user->save();

        // Bandingkan perubahan
        $changes = [];
        foreach (['name', 'email'] as $field) {
            if (($oldData[$field] ?? null) != $user->$field) {
                $changes[$field] = [
                    'old' => $oldData[$field] ?? null,
                    'new' => $user->$field,
                ];
            }
        }

        if ($request->filled('password')) {
            $changes['password'] = [
                'old' => '********',
                'new' => '********', // jangan simpan password asli, cukup tandai berubah
            ];
        }

        // Catat aktivitas
        if (!empty($changes)) {
            activity('user_profile')
                ->causedBy($user)
                ->performedOn($user)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Memperbarui profil pengguna');
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
