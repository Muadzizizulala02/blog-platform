<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // FIX: Use $request->user() instead of auth()->user()
        // We also add a "Type Hint" so the editor knows this is YOUR User model
        // and that it has a 'role' property.
        
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        // Check if user is authenticated (logged in)
        if (! $user) {
            return redirect('login')->with('error', 'You must be logged in.');
        }
        
        // Check if authenticated user has admin role
        if ($user->role !== 'admin') {
            return redirect('dashboard')->with('error', 'You do not have admin access.');
        }
        
        return $next($request);
    }
}