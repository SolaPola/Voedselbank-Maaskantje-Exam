<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Toegang geweigerd: log eerst in'], 401);
            }
            return redirect()->route('login')->with('error', 'Toegang geweigerd: log eerst in');
        }

        return $next($request);
    }
}
