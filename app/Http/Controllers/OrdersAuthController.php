<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersAuthController extends Controller
{
    public function show()
    {
        return view('auth.orders-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if ($request->password !== env('ORDERS_PASSWORD')) {
            return back()->withErrors(['password' => 'Invalid password']);
        }

        session(['orders_authenticated' => true]);

        return redirect()->intended(route('orders.index'));
    }

    public function logout()
    {
        session()->forget('orders_authenticated');
        return redirect()->route('dashboard');
    }
}
