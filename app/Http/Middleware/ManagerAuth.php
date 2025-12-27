<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('manager_authenticated')) {
            return redirect()->route('manager.login');
        }

        return $next($request);
    }
}