<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.manager-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if ($request->password !== config('app.manager_password')) {
            return back()->withErrors([
                'password' => 'Invalid password'
            ]);
        }

        session(['manager_authenticated' => true]);

        // ✅ Redirect to originally requested page
        return redirect()->intended(route('dashboard'));
    }
    public function logout(Request $request)
    {
        session()->forget('manager_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ Redirect to dashboard
        return redirect()->route('dashboard');
    }
}