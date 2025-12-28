<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesAuthController extends Controller
{
    public function show()
    {
        return view('auth.sales-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if ($request->password !== env('SALES_PASSWORD')) {
            return back()->withErrors(['password' => 'Invalid password']);
        }

        session(['sales_authenticated' => true]);

        return redirect()->intended(route('accounts.index'));
    }

    public function logout()
    {
        session()->forget('sales_authenticated');
        return redirect()->route('dashboard');
    }
}
