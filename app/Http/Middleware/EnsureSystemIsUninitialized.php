<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSystemIsUninitialized
{
    public function handle(Request $request, Closure $next): Response
    {
        if (User::exists()) {
            return redirect()->route('login')->with('error', 'System is already initialized.');
        }

        return $next($request);
    }
}
